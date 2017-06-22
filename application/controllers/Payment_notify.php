<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 支付异步回调
*/

class Payment_notify extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('ewallet_model');
	}

	public function alipay_recharge(){
		$this->config->load('alipay', TRUE); 
		require_once(APPPATH."third_party/alipay/lib/alipay_notify.class.php");
		$alipayNotify = new AlipayNotify($this->config->item('alipay'));
		//计算得出通知验证结果
		$verify_result = $alipayNotify->verifyNotify();
		//商户订单号
		$out_trade_no = $_POST['out_trade_no'];
		$trade_log = $this->ewallet_model->get_record_by_tid($out_trade_no);
		$error = '';
		if($verify_result) {//验证成功
			if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
				//此处为充值，不需检测金额是否对上
				if(!empty($trade_log)){
					$amount = $_POST['total_fee'];
					$recharge_award_conf = config_item('recharge_award');
					$recharge_award = 0.00;
					if(array_key_exists($amount, $recharge_award_conf)){
						$recharge_award = $recharge_award_conf[$amount];
					}
					//查询现有余额
					$cur_balance = $this->ewallet_model->get_balance($trade_log['merchant_id']);
					$balance = $cur_balance + $amount + $recharge_award;

					$ret = $this->ewallet_model->update_recharge_log($amount, $balance, $recharge_award, $_POST, $trade_log);

					if($ret){
						//通知后台
						$this->load->library('admin_server');
						$ret_arr = $this->admin_server->merchant_charge_call($trade_log['id']);
						//如果失败，记录日志
						if(empty($ret_arr) || $ret_arr['code']!=200){
							$str = var_export($ret_arr, true);
							log_message('error', '【商家充值通知api失败】trade_id='.$trade_log['id']."\r\n返回值为：".$str);
						}
						exit('success');
					}else{
						$error = "事务执行失败";
					}
				}else{
					$error = "未获取到交易记录";
				}
			}
		}
		$error = empty($error) ? '验签失败' : $error;
		$this->ewallet_model->recharge_error_log($_POST, $error, $trade_log['id']);
		//验证失败
		exit('fail');
	}


	public function alipay_order(){
		$this->config->load('alipay', TRUE); 
		require_once(APPPATH."third_party/alipay/lib/alipay_notify.class.php");
		$alipayNotify = new AlipayNotify($this->config->item('alipay'));
		//计算得出通知验证结果
		$verify_result = $alipayNotify->verifyNotify();
		//商户订单号
		$out_trade_no = $_POST['out_trade_no'];
		$trade_log = $this->ewallet_model->get_record_by_tid($out_trade_no);
		$error = '';
		if($verify_result) {//验证成功
			if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
				//此处为充值，不需检测金额是否对上
				if(!empty($trade_log)){
					$amount = $_POST['total_fee'];
					//支付金额不小于价格
					if($amount >= $trade_log['amount']){
						$ret = $this->ewallet_model->update_pay_log($_POST, $trade_log);

						if($ret){
							//通知后台
							$this->load->library('admin_server');
							$ret_arr = $this->admin_server->order_employed_call($ret);
							//如果失败，记录日志
							if(empty($ret_arr) || $ret_arr['code']!=200){
								$str = var_export($ret_arr, true);
								log_message('error', '【预付款通知api失败】trade_id='.$ret."\r\n返回值为：".$str);
							}

							exit('success');
						}else{
							$error = "事务执行失败";
						}
					}else{
						$error = "支付金额{$amount}小于应付价格";
					}
				}else{
					$error = "未获取到交易记录";
				}
			}
		}
		$error = empty($error) ? '验签失败' : $error;
		$this->ewallet_model->recharge_error_log($_POST, $error, $trade_log['id']);
		//验证失败
		exit('fail');
	}

    public function alipay_replenish(){
        $this->config->load('alipay', TRUE);
        require_once(APPPATH."third_party/alipay/lib/alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($this->config->item('alipay'));
        //计算得出通知验证结果
        $verify_result = $alipayNotify->verifyNotify();
        //商户订单号
        $out_trade_no = $_POST['out_trade_no'];
        $trade_log = $this->ewallet_model->get_record_by_tid($out_trade_no);
        $error = '';
        if($verify_result) {//验证成功
            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                //此处为充值，不需检测金额是否对上
                if(!empty($trade_log)){
                    $amount = $_POST['total_fee'];
                    //支付金额不小于价格
                    if($amount >= $trade_log['amount']){
                        $ret = $this->ewallet_model->update_replenish_log($_POST, $trade_log);

                        if($ret){
//                            //通知后台
//                            $this->load->library('admin_server');
//                            $ret_arr = $this->admin_server->order_employed_call($ret);
//                            //如果失败，记录日志
//                            if(empty($ret_arr) || $ret_arr['code']!=200){
//                                $str = var_export($ret_arr, true);
//                                log_message('error', '【预付款通知api失败】trade_id='.$ret."\r\n返回值为：".$str);
//                            }

                            exit('success');
                        }else{
                            $error = "事务执行失败";
                        }
                    }else{
                        $error = "支付金额{$amount}小于应付价格";
                    }
                }else{
                    $error = "未获取到交易记录";
                }
            }
        }
        $error = empty($error) ? '验签失败' : $error;
        $this->ewallet_model->recharge_error_log($_POST, $error, $trade_log['id']);
        //验证失败
        exit('fail');
    }

}