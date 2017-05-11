<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 后台首页 及 下单相关(注：报价订单和定价订单的操作，不用priced_type来分别，用不同的方法名)
*  @params : priced_type  1报价订单  2定价订单（功能暂时不做）
*/

class Order extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('order_model');
		$this->load->model('ewallet_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->me_name = $this->session->userdata('me_username');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	//后台首页
	public function index(){
		$data = array();
		$this->load->model('account_model');
		$this->load->model('ewallet_model');
		$data['user'] = $this->account_model->get_homepage_user($this->me_id);
		$merchant_conf = config_item('merchant_category');
		$data['user']['me_category'] = $merchant_conf[$data['user']['me_category']];

		$qiniu_conf = config_item('qiniu');
		$data['user']['me_headimg'] = empty($data['user']['me_headimg']) ? "" : $qiniu_conf['source_url'] . $data['user']['me_headimg'];

		$tmp_login_time = $this->account_model->get_last_login($this->me_id);
		$data['last_login_time'] = empty($tmp_login_time) ? '暂无' : date('Y-m-d H:i:s', $tmp_login_time);
		$data['coupon_num'] = $this->ewallet_model->get_coupon_num($this->me_id);

		$this->load->model('news_model');
		$this->load->model('article_model');
		$data['news'] = $this->news_model->get_list('', 3);
		$data['article'] = $this->article_model->get_list('', 3);

		//统计各种订单类型的数目
		$data['order_num'] = $this->order_model->get_distinct_order_num($this->me_id);

		$this->load->view('order/index', $data);
	}

	//报价订单首页
	//merchant_type 1待报价 2报价中 3已挑选师傅 4已支付预付款 5师傅服务中 6师傅完成服务 7验收交易成功
	//other_type 8退款中  9仲裁中  10交易关闭 11待评价 12投诉处理中
	public function baojia_index($type=0, $page=1){
		$count = $this->order_model->get_distinct_order_num($this->me_id, 1);
		$count['all'] = $this->order_model->get_order_num($this->me_id, 1);
		$data['top_num'] = $count;

		//这里搜索提交用post, 如果post里的type与get里的同时存在，取post
		$post = $this->input->post(array('kehu','order_sn','logistics_no','ptype'), true);
		$post['ptype'] = empty($post['ptype']) ? $type : $post['ptype'];
		$data['type'] = intval($post['ptype']);
		$data['kehu'] = empty($post['kehu']) ? '' : trim($post['kehu']);
		$data['order_sn'] = empty($post['order_sn']) ? '' : trim($post['order_sn']);
		$data['logistics_no'] = empty($post['logistics_no']) ? '' : trim($post['logistics_no']);
		//获取当前搜索的记录数
		$data['local_num'] = $this->order_model->get_baojia_search_num($this->me_id, $post);
		//获取搜索列表
		$num_per_page = config_item('num_per_page');
		$data['local_list'] = $this->order_model->get_baojia_search_item($this->me_id, $post, $page, $num_per_page['order_index']);
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("order/baojia_index/$type/");
		$config['total_rows'] = $data['local_num'];
		$config['per_page'] = $num_per_page['order_index'];
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();

		$this->load->view('order/baojia_index', $data);
	}

	//报价订单详情
	public function baojia_detail($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$data['detail'] = $this->order_model->get_baojia_detail($this->me_id, $order_id);
			$this->load->view('order/baojia_detail', $data);
		}
	}

	//商家标记订单
	public function add_baojia_mark(){
		$post = $this->input->post(array('order_id','mark'), true);
		@extract($post);
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$ret = $this->order_model->add_baojia_mark($order_id, $mark);
			if($ret > 0){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');
	}

	//报价订单取消
	//$from 当前的订单状态，用于计数
	public function baojia_del($order_id, $from){
		$order_id = intval($order_id);
		if(in_array($from, array('wait_priced', 'wait_hired', 'wait_pay'))){
			$result = $this->order_model->del_baojia_order($this->me_id, $order_id, $from);
			if($result){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');
	}

	//报价订单编辑提交
	public function edit($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$post = $this->input->post(array('customer_name', 'customer_phone', 'address', 'cargo_arrive', 'goodnum', 'logistics_no', 'logistics_name', 'logistics_phone', 'logistics_address', 'logistics_remark', 'me_name', 'me_phone'), true);

			$this->form_validation->set_rules('customer_name','customer_name','required');
			$this->form_validation->set_rules('customer_phone','customer_phone','required');
			$this->form_validation->set_rules('address','address','required');
			$this->form_validation->set_rules('me_name','me_name','required');
			$this->form_validation->set_rules('me_phone','me_phone','required');
			if($this->form_validation->run() == false){
				ajax_response(1,validation_errors());
			}

			//将传递过来的默认- -改为空
			foreach($post as $key => $val){
				if($val == '- -'){
					$post[$key] = '';
				} 
			}
			$post['cargo_arrive'] = empty($post['cargo_arrive']) ? 0 : intval($post['cargo_arrive']);
			$post['goodnum'] = empty($post['goodnum']) ? 0 : intval($post['goodnum']);
			$post['logistics_no'] = empty($post['logistics_no']) ? '' : $post['logistics_no'];
			$post['logistics_name'] = empty($post['logistics_name']) ? '' : $post['logistics_name'];
			$post['logistics_phone'] = empty($post['logistics_phone']) ? '' : $post['logistics_phone'];
			$post['logistics_address'] = empty($post['logistics_address']) ? '' : $post['logistics_address'];
			$post['logistics_remark'] = empty($post['logistics_remark']) ? '' : $post['logistics_remark'];

			//查询订单状态，如果为服务中或以后，不可编辑
			$master_status = $this->order_model->get_master_status($order_id);
			if($master_status > 0){
				ajax_response(1, '服务已开始，不可编辑');
			}
			$result = $this->order_model->edit_baojia_order($order_id, $post);
			if($result){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');
	}

	//验收放款
	public function check_to_confirm($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$ret = $this->order_model->check_confirmed($this->me_id, $order_id);
			if($ret){
				//通知后台
				$this->load->library('admin_server');
				$ret_arr = $this->admin_server->order_success_call($order_id);
				//如果失败，记录日志
				if(empty($ret_arr) || $ret_arr['code']!=200){
					$str = var_export($ret_arr, true);
					log_message('error', '【验收放款通知api失败】order_id='.$order_id."\r\n返回值为：".$str);
				}
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');
	}

	//查看服务节点
	public function baojia_trace($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$data['master_num'] = $this->order_model->get_master_num($order_id);
			$data['trace'] = $this->order_model->get_baojia_trace($order_id);

			$this->load->view('order/baojia_trace', $data);
		}
	}

	//查看师傅报价
	public function baojia_offer($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$data['master_num'] = $this->order_model->get_master_num($order_id);
			if($data['master_num']>0){
				$data['trace'] = $this->order_model->get_order_status($order_id);
				//list
				$data['master'] = $this->order_model->get_master_offer($order_id);

				$this->load->view('order/baojia_offer', $data);
			}
		}
	}

	//雇佣师傅
	public function hire_master($order_id, $master_id, $hired_id=0){
		$data['order_id'] = $order_id = intval($order_id);
		$master_id = intval($master_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			if(!empty($hired_id)){
				//当前已有雇佣，则解除
				$this->order_model->unhire_master($order_id, $hired_id);
			}
			$ret = $this->order_model->hire_master($this->me_id, $order_id, $master_id, $hired_id);

			if($ret){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');
	}

	//支付预览页
	public function order_pay($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$order_msg = $this->order_model->get_order_for_pay($order_id);
			$master_id = $order_msg['master_id'];
			$merchant_price = $order_msg['merchant_price'];
			$master_msg = $this->order_model->get_master_for_pay($master_id);
			//可用优惠券列表
			$coupons = $this->ewallet_model->get_coupon_for_pay($this->me_id, $merchant_price);

			$data = array(
				'order_id' => $order_id,
				'me_balance' => $this->ewallet_model->get_balance($this->me_id),
				'order' => $order_msg,
				'master' => $master_msg,
				'coupons' => $coupons
				);
			$this->load->view('order/baojia_payment', $data);
		}
	}

	//创建交易记录
	public function create_trade(){
		$post = $this->input->post(array('balance', 'order_id', 'coupon_id'), true);
		@extract($post);
		$order_id = intval($order_id);
		$coupon_id = empty($coupon_id) ? 0 : intval($coupon_id);
		$balance = intval($balance);

		$me_balance = 0.00;
		$me_coupon_fee = 0.00;
		//查询总价
		$ret_order = $this->order_model->get_total_fee($this->me_id, $order_id);
		if(empty($ret_order) || empty($ret_order['merchant_price'])){
			exit('服务异常');
		}
		$total_price = $ret_order['merchant_price'];
		$order_number = $ret_order['order_number'];
		$service_type = $ret_order['service_type'];
		$master_name = $ret_order['master_name'];
		$create_order_time = $ret_order['add_time'];
		//使用了余额
		if(!empty($balance)){
			$me_balance = $this->ewallet_model->get_balance($this->me_id);
		}
		//使用了优惠券
		if(!empty($coupon_id)){
			$ret = $this->ewallet_model->get_coupon_fee($coupon_id);
			if(!empty($ret) && $ret['c_fullmoney']>=$total_price){
				$me_coupon_fee = $ret['c_money'];
			}
		}

		//如果余额和优惠券的和大于订单金额，则直接操作支付
		if(($me_balance+$me_coupon_fee)>=$total_price){
			$use_balance = $total_price-$me_coupon_fee;
			$use_balance = ($use_balance > 0) ? $use_balance : 0.00;
			$result = $this->ewallet_model->payorder_by_balance($this->me_id, $this->me_name, $order_id, $order_number, $me_balance, $use_balance, $coupon_id, $me_coupon_fee);
			if($result){
				//组织数据
				$service_conf = config_item('service_type');
				$data = array(
					'order_id' => $order_id,
					'order_number' => $order_number,
					'service_type' => isset($service_conf[$service_type]) ? $service_conf[$service_type] : '- -',
					'fee' => $use_balance,
					'master_name' => $master_name
					);
				return $this->load->view('order/pay_success', $data);
			}
		}else{
			//需要在线支付
			$real_price = $total_price-$me_balance-$me_coupon_fee;
			$result = $this->ewallet_model->payorder_online($this->me_id, $this->me_name, $order_id, $order_number, $me_balance, $real_price, $coupon_id, $me_coupon_fee);
			if($result){
				$auto_close_time = config_item('auto_close_order');
				$data = array(
					'order_id' => $order_id,
					'real_price' => $real_price,
					'order_number' => $order_number,
					'deadline' => ($create_order_time + $auto_close_time - time())
					);
                return $this->load->view('order/online_pay', $data);
			}
		}
		exit('系统异常');
	}

	//发起支付
	public function do_pay($order_id){
		$order_id = intval($order_id);
		$ret = $this->ewallet_model->get_online_real_price($this->me_id, $order_id);
		if(empty($ret)){
			exit('系统异常');
		}
		$tid = $ret['trade_number'];
		$fee = $ret['amount'];

		//存储订单id，用于同步显示数据
		$arr = array(
			'baojia_orderid_pay' => $order_id,
			'baojia_real_pay' => $fee
			);
		$this->session->set_userdata($arr);
		$this->load->helper('payment');
		header("Content-type:text/html;charset=utf-8");
		header("Cache-control: private");
		//设置异步配置的key
		$prefix = 'order_pay';
		echo alipay_build($tid, '乐帮到家-支付', $fee, '乐帮到家-支付', $prefix);
	}

	//支付成功，同步页面
	public function pay_success(){
		$order_id = $this->session->userdata('baojia_orderid_pay');
		$fee = $this->session->userdata('baojia_real_pay');
		if(!empty($order_id)){
			$ret = $this->order_model->get_order_by_oid($this->me_id, $order_id);
			$service_conf = config_item('service_type');
			$data = array(
				'order_id' => $order_id,
				'order_number' => $ret['order_number'],
				'service_type' => isset($service_conf[$ret['service_type']]) ? $service_conf[$ret['service_type']] : '- -',
				'fee' => $fee,
				'master_name' => $ret['real_name'],
				'master_phone' => $ret['phone']
				);
			$this->load->view('order/pay_success', $data);
		}
	}

	//报价订单下单页面
	public function baojia($type=4){
		$data['type'] = $type = intval($type);
		$data['__provinces'] = get_province();

		$this->load->library('util');
		$qiniu_conf = config_item('qiniu');
		$data['upload_url'] = $qiniu_conf['upload_url'];
		$data['source_url'] = $qiniu_conf['source_url'];
		$bucket = 'lebang';
		$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);

		//1 2 4用同一个模板
		if(in_array($type, array(1, 2, 4))){
			$this->load->view('order/common_order', $data);
		}else if($type==3){
			$this->load->view('order/fix_order', $data);
		}else{
			exit('功能暂未开放');
		}
	}

	//下单提交
	public function baojia_submit($type=4){
		$type = intval($type);
		$post = $this->input->post(array('goods_id', 'goods_img', 'goods_type', 'goods_num', 'goods_name', 'goods_remark', 'customer_name', 'customer_phone', 'province', 'city', 'district', 'address', 'elevater', 'floor', 'cargo_arrive', 'has_tmall', 'tmall_number', 'customer_remark', 'goodnum', 'logistics_no', 'logistics_name', 'logistics_phone', 'logistics_address', 'logistics_remark', 'me_name', 'me_phone', 'hope_finish_time'), true);
		
		$this->form_validation->set_rules('goods_img[]','goods_img','required');
		$this->form_validation->set_rules('goods_type[]','goods_type','required');
		$this->form_validation->set_rules('customer_name','customer_name','required');
		$this->form_validation->set_rules('customer_phone','customer_phone','required');
		$this->form_validation->set_rules('province','province','required');
		$this->form_validation->set_rules('city','city','required');
		$this->form_validation->set_rules('district','district','required');
		$this->form_validation->set_rules('address','address','required');
		$this->form_validation->set_rules('elevater','elevater','required');
		$this->form_validation->set_rules('floor','floor','required');
		$this->form_validation->set_rules('me_name','me_name','required');
		$this->form_validation->set_rules('me_phone','me_phone','required');

		//整理参数
		if(in_array($type, array(1,2,4))){
			$this->form_validation->set_rules('goods_id[]','goods_id','required');
			$this->form_validation->set_rules('goods_name[]','goods_name','required');
			$this->form_validation->set_rules('goods_num[]','goods_num','required');
			$this->form_validation->set_rules('cargo_arrive','cargo_arrive','required');

			foreach ($post['goods_id'] as $key => $val) {
				$post['goods_id'][$key] = intval($val);
			}
			foreach ($post['goods_num'] as $key => $val) {
				$post['goods_num'][$key] = intval($val);
			}
			$post['cargo_arrive'] = intval($post['cargo_arrive']);
			$post['has_tmall'] = intval($post['has_tmall']);
			$post['tmall_number'] = empty($post['tmall_number']) ? '' : $post['tmall_number'];
			$post['customer_remark'] = empty($post['customer_remark']) ? '' : $post['customer_remark'];
		}
		if($type == 3){
			$post['cargo_arrive'] = 0;
		}

		foreach ($post['goods_type'] as $key => $val) {
			$post['goods_type'][$key] = intval($val);
		}
		$post['district'] = intval($post['district']);
		$post['elevater'] = intval($post['elevater']);
		$post['floor'] = intval($post['floor']);
		$post['goodnum'] = empty($post['goodnum']) ? 0 : intval($post['goodnum']);
		$post['logistics_no'] = empty($post['logistics_no']) ? '' : $post['logistics_no'];
		$post['logistics_name'] = empty($post['logistics_name']) ? '' : $post['logistics_name'];
		$post['logistics_phone'] = empty($post['logistics_phone']) ? '' : $post['logistics_phone'];
		$post['logistics_address'] = empty($post['logistics_address']) ? '' : $post['logistics_address'];
		$post['logistics_remark'] = empty($post['logistics_remark']) ? '' : $post['logistics_remark'];
		$post['hope_finish_time'] = empty($post['hope_finish_time']) ? 0 : strtotime($post['hope_finish_time']);

		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}
		//打包返货先不要
		if(in_array($type, array(1, 2, 3, 4))){
			$this->load->library('util');
			$order_no = Util::genOrderNumber();
			$ret = $this->order_model->create_order($this->me_id, $type, $order_no, $post);
			if($ret){
				//此处exec，推送订单消息
				$arr = array(
					'order_id' => $ret,
					'area_id' => $post['district'],
					'service_type' => $type
					);
				$cmd = '/usr/bin/php index.php task push_master "'. urlencode(serialize($arr)) .'" > /dev/null &';
				exec($cmd);
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后重试');

	}

	//师傅信息展示
	public function master($type='introduce', $master_id){
		$data['master_id'] = $master_id = intval($master_id);
		//获取头部统计信息
		$this->load->model('master_model');
		//统计信息
		$data['statistic'] = $this->master_model->get_master_statistic($master_id);
		//避免非法查看
		if(empty($data['statistic'])){
			exit;
		}
		if($type == 'introduce'){
			$data['base'] = $this->master_model->get_master_info($master_id);
			$this->load->view('order/master_introduce', $data);
		}else{
			$data['base'] = $this->master_model->get_master_service_info($master_id);
			$this->load->view('order/master_service', $data);
		}
	}

	//test send
	public function test_push(){
		$arr = array(
					'order_id' => 1,
					'area_id' => 1,
					'service_type' => 1
					);
		//$cmd = '/data/service/php53/bin/php index.php task push_master_test "'. urlencode(serialize($arr)) .'" > /dev/null &';
		$cmd = '/usr/bin/php index.php task push_master_test "'. urlencode(serialize($arr)) .'"';
		$a = exec($cmd,$output,$return_var);
		echo '<pre>';
		var_dump($cmd,$a,$output,$return_var);
	}


}