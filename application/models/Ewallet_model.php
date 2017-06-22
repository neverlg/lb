<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Ewallet_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_balance($me_id){
		$this->db->select('me_money')->from('merchant')->where(array('me_id'=>$me_id));
		$result = $this->db->get()->row_array();
		return $result['me_money'];
	}

	public function get_trade_total($me_id, $start_time, $end_time){
		$where = array(
			'merchant_id' => $me_id,
			'status' => 1
			);
		$start_time = strtotime($start_time);
		$end_time = strtotime($end_time);
		if($start_time){
			$where['add_time>'] = $start_time;
		}
		if($end_time){
			$where['add_time<'] = $end_time;
		}
		return $this->db->from('merchant_trade_log')->where($where)->group_start()->where('source',1)->or_where('type',1)->group_end()->count_all_results();
	}

	public function get_trade_list($me_id, $page, $num_per_page, $start_time, $end_time){
		//与钱包有关或者充值的
		$where = ' AND (source=1 OR type=1)';
		$start_time = strtotime($start_time);
		$end_time = strtotime($end_time);
		if($start_time){
			$where .= ' AND add_time>' . $start_time;
		}
		if($end_time){
			$where .= ' AND add_time<' . $end_time;
		}
		$start = ($page-1)*$num_per_page;
	
		$sql = "SELECT add_time, trade_number, type, alipay_no, direction, amount, balance, remark, order_serial_number_list as order_sn FROM merchant_trade_log WHERE merchant_id=$me_id AND status=1 $where ORDER BY id DESC LIMIT $start, $num_per_page";
		$result = $this->db->query($sql)->result_array();

		//此处需要变换数组，使之适应合并支付
		$trade_type = config_item('trade_type');
		foreach ($result as $key => $val) {
			$result[$key]['add_time'] = date("Y-m-d H:i", $val['add_time']);
			$result[$key]['amount'] = ($val['direction']=='in') ? '+'.$val['amount'] : '-'.$val['amount'];
			$result[$key]['type'] = $trade_type[$val['type']];
			$result[$key]['order_sn'] = explode(',', $val['order_sn']);
		}
		return $result;
	}

	public function get_paypass($me_id){
		$this->db->select('me_paypass')->from('merchant')->where(array('me_id'=>$me_id));
		$result = $this->db->get()->row_array();
		return $result['me_paypass'];
	}

	public function update_paypass($me_id, $password){
		$where = array('me_id' => $me_id);
		$data = array(
			'me_paypass' => md5($password),
			'me_update_time' => time()
			);
		$this->db->update('merchant', $data, $where);
		return $this->db->affected_rows();
	}

	public function get_status_count($me_id){
		$time = time();
		$final_arr = array(
			0 => array(
					'cg_status' => 0,
					'count' => 0,
					'total_price' => 0
					),
			1 => array(
					'cg_status' => 1,
					'count' => 0,
					'total_price' => 0
					),
			2 => array(
					'cg_status' => 2,
					'count' => 0,
					'total_price' => 0
					)
			);
		// 0 1
		$sql = "SELECT a.cg_status, COUNT(*) as count, SUM(b.c_money) as total_price FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_meid=$me_id AND a.cg_endtime>$time AND b.c_status=1 GROUP BY a.cg_status";
		$result = $this->db->query($sql)->result_array();
		if(!empty($result)){
			$result = array_column($result, null, 'cg_status');
			foreach ($result as $key => $val) {
				if($val['count'] > 0){
					$final_arr[$key] = $val;
				}
			}
		}
		//过期的 2
		$sql = "SELECT 2, COUNT(*) as count, SUM(b.c_money) as total_price FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_meid=$me_id AND a.cg_endtime<$time AND a.cg_status=0 AND b.c_status=1";
		$result = $this->db->query($sql)->row_array();
		if(!empty($result) && $result['count']>0){
			$final_arr[2] = $result;
		}
		return $final_arr;
	}

	public function get_coupon_list($me_id, $status, $page, $num_per_page){
		$time = time();
		$start = ($page-1)*$num_per_page;
		if(in_array($status, array(0, 1))){
			$sql = "SELECT c_type, c_name, c_fullmoney, cg_sncode, c_money, cg_starttime, cg_endtime FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_meid=$me_id AND a.cg_endtime>$time AND b.c_status=1 AND a.cg_status=$status ORDER BY a.cg_id DESC LIMIT $start, $num_per_page";
		}else{
			$sql = "SELECT c_type, c_name, c_fullmoney, cg_sncode, c_money, cg_starttime, cg_endtime FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_meid=$me_id AND a.cg_endtime<$time AND b.c_status=1 AND a.cg_status=0 ORDER BY a.cg_id DESC LIMIT $start, $num_per_page";
		}
		$result = $this->db->query($sql)->result_array();

		$coupon_type = config_item('coupon');
		foreach ($result as $key => $val) {
			$result[$key]['cg_starttime'] = date("Y-m-d", $val['cg_starttime']);
			$result[$key]['cg_endtime'] = date("Y-m-d", $val['cg_endtime']);
			$result[$key]['c_type'] = isset($coupon_type[$val['c_type']]) ? $coupon_type[$val['c_type']] : '电子券';
		}
		return $result;
	}

	public function add_recharge_log($me_id, $tid, $fee){
		$data = array(
			'merchant_id' => $me_id,
			'direction' => 'in',
			'amount' => $fee,
			'type' => 1,
			'trade_number' => $tid,
			'order_number_list' => '',
			'ip' => $this->input->ip_address(),
			'status' => 0,
			'error' => '',
			'info' => '',
			'alipay_no' => '',
			'add_time' => time(),
			'source' => 4,
			'balance' => 0.00,
			'coupon_id' => 0,
			'coupon_discount' => 0.00,
			'recharge_award' => 0.00,
			'update_time' => 0
			);
		$this->db->insert('merchant_trade_log', $data);
		return $this->db->insert_id();
	}

	public function get_record_by_tid($out_trade_no){
		$where = array('trade_number' => $out_trade_no);
		$this->db->select('id, merchant_id, balance, order_number_list, amount, coupon_id')->from('merchant_trade_log')->where($where)->order_by('id', 'DESC')->limit(1);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function update_recharge_log($amount, $balance, $recharge_award, $post, $trade_arr){
		$time = time();
		$info = json_encode($post);
		$alipay_no = $post['trade_no'];
		$trade_id = $trade_arr['id'];
		$me_id = $trade_arr['merchant_id'];
		$final_result = false;

		$sql1 = "UPDATE merchant_trade_log SET amount=$amount, status=1, info='{$info}', alipay_no='{$alipay_no}', balance=$balance, recharge_award=$recharge_award, update_time=$time WHERE id=$trade_id";
		$sql2 = "UPDATE merchant SET me_money=$balance, me_update_time=$time WHERE me_id=$me_id";

		$this->db->trans_begin();
		$this->db->query($sql1);
		$this->db->query($sql2);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function recharge_error_log($post, $error, $id){
		$where = array('id' => $id);
		$data = array(
			'error' => $error,
			'info' => json_encode($post),
			'status' => 2,
			'update_time' => time()
			);
		$this->db->update('merchant_trade_log', $data, $where);
		return $this->db->affected_rows();
	}

	public function get_coupon_num($me_id){
		$where = array(
			'cg_meid' => $me_id,
			'cg_status' => 0,
			'cg_endtime>' => time()
			);
		return $this->db->from('coupon_grantlist')->where($where)->count_all_results();
	}

	public function get_coupon_for_pay($me_id, $price){
		$time = time();
		$sql = "SELECT c_name, c_fullmoney, cg_sncode, c_money, cg_id FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_meid=$me_id AND a.cg_endtime>$time AND a.cg_status=0 AND b.c_status=1 AND b.c_fullmoney>=$price ORDER BY b.c_money DESC";
		
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	public function get_coupon_fee($coupon_id){
		$sql = "SELECT b.c_fullmoney, b.c_money FROM coupon_grantlist a LEFT JOIN coupon b ON a.cg_cid=b.c_id WHERE a.cg_id=$coupon_id";
		return $this->db->query($sql)->result_array();
	}

	//只用余额支付
	public function payorder_by_balance($me_id, $me_name, $order_id, $order_number, $me_balance, $use_balance, $coupon_id, $me_coupon_fee){
		$time = time();
		$ip = $this->input->ip_address();
		$final_result = false;
		$this->load->library('util');
		$trade_number = Util::genTradeNumber();
		$cur_balance = $me_balance-$use_balance;
		$sql1 = "INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$use_balance, type=2, trade_number='{$trade_number}', order_number_list='{$order_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=1, add_time=$time, source=1, balance=$cur_balance, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'";
		//更新商家总下单数目，总积分，总金额
		$sql2 = "UPDATE merchant SET me_money=$cur_balance, me_update_time=$time, me_points=me_points+1, me_total_orders=me_total_orders+1, me_total_fee=me_total_fee+$use_balance WHERE me_id=$me_id";
		$sql3 = "UPDATE orders_status SET merchant_status=4, upd_time=$time WHERE order_id=$order_id";
		$sql4 = "UPDATE merchant_order_num SET wait_pay=wait_pay-1, wait_cargo_arrive=wait_cargo_arrive+1 WHERE me_id=$me_id AND order_type=1";

		$this->db->trans_begin();
		$this->db->query($sql1);

		if(!empty($me_balance)){
			$this->db->query($sql2);
		}
		$this->db->query($sql3);
		$this->db->query($sql4);
		$this->db->query("UPDATE orders SET pay_type=1, pay_time=$time WHERE id=$order_id");
		//将雇佣师傅状态改为雇佣成功, 其他改为未被雇佣
		$this->db->query("UPDATE orders_offer SET status=2, upd_time=$time WHERE order_id=$order_id AND status=1");
		$this->db->query("UPDATE orders_offer SET status=3, upd_time=$time WHERE order_id=$order_id AND status=0");
		if(!empty($coupon_id)){
			$this->db->query("UPDATE coupon_grantlist SET cg_status=1, cg_use_time=$time, cg_user_order_number='{$order_number}' WHERE cg_id=$coupon_id");
		}
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	//需要在线支付
	public function payorder_online($me_id, $me_name, $order_id, $order_number, $me_balance, $real_price, $coupon_id, $me_coupon_fee){
		$time = time();
		$ip = $this->input->ip_address();
		$final_result = false;
		$this->load->library('util');
		$trade_number = Util::genTradeNumber();

		$this->db->trans_begin();
		$this->db->query("INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$real_price, type=2, trade_number='{$trade_number}', order_number_list='{$order_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=0, add_time=$time, source=4, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'");
		$online_payid = $this->db->insert_id();
		if(!empty($me_balance)){
			$trade_number = Util::genTradeNumber();
			//现有余额为0.00，异步通知成功，再设置
			$this->db->query("INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$me_balance, type=2, trade_number='{$trade_number}', order_number_list='{$order_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=0, add_time=$time, source=1, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'");
			$balance_payid = $this->db->insert_id();
			//此时将两种混合id存起来，方便异步通知时修改
			$this->load->library('lb_redis');
			Lb_redis::set('mixed_pay_'.$online_payid, $balance_payid, 3600);
		}
		if(!empty($coupon_id)){
			$this->db->query("UPDATE coupon_grantlist SET cg_status=0, cg_use_time=$time, cg_user_order_number='{$order_number}' WHERE cg_id=$coupon_id");
		}
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result ? $online_payid : false;
	}

	//在线支付获取参数
	public function get_online_real_price($me_id, $trade_id){
		$sql = "SELECT amount, trade_number FROM merchant_trade_log WHERE id=$trade_id AND merchant_id=$me_id";
		return $this->db->query($sql)->row_array();
	}

	//支付成功，更新
	public function update_pay_log($post, $trade_arr){
		$time = time();
		$info = json_encode($post);
		$alipay_no = $post['trade_no'];
		$trade_id = $trade_arr['id'];
		$me_id = $trade_arr['merchant_id'];
		$coupon_id = $trade_arr['coupon_id'];
		$order_list = $trade_arr['order_number_list'];
		$final_result = false;

		$this->db->trans_begin();
		//获取用户当前余额
		$ret1 = $this->db->query("SELECT me_money FROM merchant WHERE me_id=$me_id")->row_array();
		$cur_balance = $ret1['me_money'];
		//是否有余额支付参与
		$this->load->library('lb_redis');
		$merchant_set = '';
		$balance_pay = 0.00;
		$balance_pay_id = Lb_redis::get('mixed_pay_'.$trade_id);
		if(!empty($balance_pay_id)){
			$ret = $this->db->query("SELECT amount FROM merchant_trade_log WHERE id=$balance_pay_id AND merchant_id=$me_id")->row_array();
			$balance_pay = $ret['amount'];
			if($cur_balance < $balance_pay){
				log_message('error', '【混合支付失败】trade_id='.$trade_id."\r\n用户当前余额".$cur_balance."不足以支付订单余额部分".$balance_pay."\r\n但是异步支付成功");
				//$this->db->trans_rollback();
				return false;
			}else{
				$final_balance = $cur_balance - $balance_pay;
				$this->db->query("UPDATE merchant_trade_log SET status=1, update_time=$time, balance=$final_balance WHERE id=$balance_pay_id");
				$merchant_set =" me_money=$final_balance, ";
			}
		}
		$change_pay = $balance_pay+$trade_arr['amount'];
		$this->db->query("UPDATE merchant SET {$merchant_set} me_points=me_points+1, me_total_orders=me_total_orders+1, me_total_fee=me_total_fee+$change_pay WHERE me_id=$me_id");
		$this->db->query("UPDATE merchant_trade_log SET status=1, info='{$info}', alipay_no='{$alipay_no}', balance=$cur_balance, update_time=$time WHERE id=$trade_id");
		$this->db->query("UPDATE orders SET pay_type=4, pay_time=$time WHERE id IN ($order_list)");
		$this->db->query("UPDATE orders_status SET merchant_status=4, upd_time=$time WHERE order_id in ($order_list)");
		$this->db->query("UPDATE merchant_order_num SET wait_pay=wait_pay-1, wait_cargo_arrive=wait_cargo_arrive+1 WHERE me_id=$me_id AND order_type=1");
		//将雇佣师傅状态改为雇佣成功, 其他改为未被雇佣
		$this->db->query("UPDATE orders_offer SET status=2, upd_time=$time WHERE order_id in ($order_list) AND status=1");
		$this->db->query("UPDATE orders_offer SET status=3, upd_time=$time WHERE order_id in ($order_list) AND status=0");
		if(!empty($coupon_id)){
			$this->db->query("UPDATE coupon_grantlist SET cg_status=1 WHERE cg_id=$coupon_id");
		}

		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		//如果事务执行成功，有余额，就返回余额id，否则，trade_id
		return $final_result ? (!empty($balance_pay_id) ? $balance_pay_id : $trade_id) : false;
	}

    //只用余额补款
    public function payreplenish_by_balance($me_id, $me_name, $replenish_id, $order_number, $me_balance, $use_balance, $coupon_id, $me_coupon_fee){
        $time = time();
        $ip = $this->input->ip_address();
        $final_result = false;
        $this->load->library('util');
        $trade_number = Util::genTradeNumber();
        $cur_balance = $me_balance-$use_balance;
        $sql1 = "INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$use_balance, type=4, trade_number='{$trade_number}', order_number_list='{$replenish_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=1, add_time=$time, source=1, balance=$cur_balance, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'";
        //更新商家总下单数目，总积分，总金额
        $sql2 = "UPDATE merchant SET me_money=$cur_balance, me_update_time=$time, me_points=me_points+1, me_total_orders=me_total_orders+1, me_total_fee=me_total_fee+$use_balance WHERE me_id=$me_id";

        $this->db->trans_begin();
        $this->db->query($sql1);

        if(!empty($me_balance)){
            $this->db->query($sql2);
        }
        $this->db->query("UPDATE orders_replenish SET pay_time=$time WHERE id=$replenish_id");
        if(!empty($coupon_id)){
            $this->db->query("UPDATE coupon_grantlist SET cg_status=1, cg_use_time=$time, cg_user_order_number='{$order_number}' WHERE cg_id=$coupon_id");
        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $final_result = true;
        }
        return $final_result;
    }

    //需要在线支付
    public function payreplenish_online($me_id, $me_name, $replenish_id, $order_number, $me_balance, $real_price, $coupon_id, $me_coupon_fee){
        $time = time();
        $ip = $this->input->ip_address();
        $final_result = false;
        $this->load->library('util');
        $trade_number = Util::genTradeNumber();

        $this->db->trans_begin();
        $this->db->query("INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$real_price, type=4, trade_number='{$trade_number}', order_number_list='{$replenish_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=0, add_time=$time, source=4, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'");
        $online_payid = $this->db->insert_id();
        if(!empty($me_balance)){
            $trade_number = Util::genTradeNumber();
            //现有余额为0.00，异步通知成功，再设置
            $this->db->query("INSERT INTO merchant_trade_log SET merchant_id=$me_id, direction='out', amount=$me_balance, type=4, trade_number='{$trade_number}', order_number_list='{$replenish_id}', order_serial_number_list='{$order_number}', ip='{$ip}', status=0, add_time=$time, source=1, coupon_id=$coupon_id, coupon_discount=$me_coupon_fee, merchant_name='$me_name'");
            $balance_payid = $this->db->insert_id();
            //此时将两种混合id存起来，方便异步通知时修改
            $this->load->library('lb_redis');
            Lb_redis::set('mixed_replenish_'.$online_payid, $balance_payid, 3600);
        }
        if(!empty($coupon_id)){
            $this->db->query("UPDATE coupon_grantlist SET cg_status=0, cg_use_time=$time, cg_user_order_number='{$order_number}' WHERE cg_id=$coupon_id");
        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $final_result = true;
        }
        return $final_result ? $online_payid : false;
    }

    //支付成功，更新
    public function update_replenish_log($post, $trade_arr){
        $time = time();
        $info = json_encode($post);
        $alipay_no = $post['trade_no'];
        $trade_id = $trade_arr['id'];
        $me_id = $trade_arr['merchant_id'];
        $coupon_id = $trade_arr['coupon_id'];
        $order_list = $trade_arr['order_number_list'];
        $final_result = false;

        $this->db->trans_begin();
        //获取用户当前余额
        $ret1 = $this->db->query("SELECT me_money FROM merchant WHERE me_id=$me_id")->row_array();
        $cur_balance = $ret1['me_money'];
        //是否有余额支付参与
        $this->load->library('lb_redis');
        $merchant_set = '';
        $balance_pay = 0.00;
        $balance_pay_id = Lb_redis::get('mixed_replenish_'.$trade_id);
        if(!empty($balance_pay_id)){
            $ret = $this->db->query("SELECT amount FROM merchant_trade_log WHERE id=$balance_pay_id AND merchant_id=$me_id")->row_array();
            $balance_pay = $ret['amount'];
            if($cur_balance < $balance_pay){
                log_message('error', '【混合支付失败】trade_id='.$trade_id."\r\n用户当前余额".$cur_balance."不足以支付订单余额部分".$balance_pay."\r\n但是异步支付成功");
                //$this->db->trans_rollback();
                return false;
            }else{
                $final_balance = $cur_balance - $balance_pay;
                $this->db->query("UPDATE merchant_trade_log SET status=1, update_time=$time, balance=$final_balance WHERE id=$balance_pay_id");
                $merchant_set =" me_money=$final_balance, ";
            }
        }
        $change_pay = $balance_pay+$trade_arr['amount'];
        $this->db->query("UPDATE merchant_trade_log SET status=1, info='{$info}', alipay_no='{$alipay_no}', balance=$cur_balance, update_time=$time WHERE id=$trade_id");
        $this->db->query("UPDATE orders_replenish SET pay_time=$time WHERE id IN ($order_list)");
        if(!empty($coupon_id)){
            $this->db->query("UPDATE coupon_grantlist SET cg_status=1 WHERE cg_id=$coupon_id");
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $final_result = true;
        }
        //如果事务执行成功，有余额，就返回余额id，否则，trade_id
        return $final_result ? (!empty($balance_pay_id) ? $balance_pay_id : $trade_id) : false;
    }
}