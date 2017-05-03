<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 电子钱包
*/

class Ewallet extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('ewallet_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	//首页
	public function index($start_time=0, $end_time=0, $page=1){
		$page = ($page>0) ? intval($page) : 1;
		$num_per_page = config_item('num_per_page');
		//获取余额
		$data['balance'] = $this->ewallet_model->get_balance($this->me_id);
		//获取总数
		$total = $this->ewallet_model->get_trade_total($this->me_id, $start_time, $end_time);
		//获取列表
		$data['list'] = $this->ewallet_model->get_trade_list($this->me_id, $page, $num_per_page['ewallet_index'], $start_time, $end_time);

		$data['start_time'] = empty($start_time) ? '' : $start_time;
		$data['end_time'] = empty($end_time) ? '' : $end_time;
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("/ewallet/balance/".$start_time."/".$end_time."/");
		$config['total_rows'] = $total;
		$config['per_page'] = $num_per_page['ewallet_index'];
		//$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();

		$this->load->view('ewallet/balance',$data);
	}

	//设置钱包密码页面
	public function set_paypass(){
		$phone = $this->session->userdata('me_phone');
		$data['phone'] = substr_replace($phone, '*****', 3, 5);
		$pay_pass = $this->ewallet_model->get_paypass($this->me_id);

		if(empty($pay_pass)){
			//图形验证码
			$this->load->helper('captcha');
			$vals = array(
	    				'img_path'  => './captcha/',
	    				'img_url'   => http_type().$_SERVER['HTTP_HOST'].'/captcha/',
	    				'font_path' => './assets/fonts/TextileRegular.ttf',
	    				'font_size' => 20,
	    				'expiration' => 300,
	    				'img_id' => 'captcha',
	    				'word_length' => 4,
	 				);
			$cap = create_captcha($vals);
			$this->session->set_flashdata('auth_capture', $cap['word']);
			$data['__captcha_img'] = $cap['image'];

			$this->load->view('ewallet/set_paypass', $data);
		}else{
			$this->load->view('ewallet/seted_paypass');
		}	
	}

	//修改密码页面
	public function edit_paypass(){
		$this->load->view('ewallet/edit_paypass');
	}

	//找回密码页面
	public function forget_paypass(){
		$phone = $this->session->userdata('me_phone');
		$data['phone'] = substr_replace($phone, '*****', 3, 5);

		//图形验证码
		$this->load->helper('captcha');
		$vals = array(
    				'img_path'  => './captcha/',
    				'img_url'   => http_type().$_SERVER['HTTP_HOST'].'/captcha/',
    				'font_path' => './assets/fonts/TextileRegular.ttf',
    				'font_size' => 20,
    				'expiration' => 300,
    				'img_id' => 'captcha',
    				'word_length' => 4,
 				);
		$cap = create_captcha($vals);
		$this->session->set_flashdata('auth_capture', $cap['word']);
		$data['__captcha_img'] = $cap['image'];
		$this->load->view('ewallet/forget_paypass', $data);
	}

	//设置/找回 钱包密码
	public function set_paypass_submit(){
		$post = $this->input->post(array('code', 'password', 'passconf'), true);
		$this->form_validation->set_rules('code','code','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('passconf','passconf','required|matches[password]');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if($post['code'] != $this->session->userdata['sms_code']){
			ajax_response(1, '手机验证码错误');
		}
		if($this->session->userdata['sms_time'] < time()-config_item('sms_submit_expire')){
			ajax_response(1, '验证码已失效');
		}
		$result = $this->ewallet_model->update_paypass($this->me_id, $post['password']);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '服务器忙，请重试');
	}

	//更换钱包密码
	public function update_paypass_submit(){
		$post = $this->input->post(array('old_pass', 'password', 'passconf'), true);
		$this->form_validation->set_rules('old_pass','old_pass','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('passconf','passconf','required|matches[password]');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if($this->ewallet_model->get_paypass($this->me_id) != md5($post['old_pass'])){
			ajax_response(1, '旧支付密码输入错误');
		}
		$result = $this->ewallet_model->update_paypass($this->me_id, $post['password']);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '服务器忙，请重试');
	}

	//优惠券首页
	//status 0未使用  1已使用  2已过期
	public function coupon($status=0,$page=1){
		$page = ($page>0) ? intval($page) : 1;
		$data['status'] = $status = intval($status);
		$num_per_page = config_item('num_per_page');
		//统计各类总数
		$data['count'] = $this->ewallet_model->get_status_count($this->me_id);
		//详情查询
		$data['list'] = $this->ewallet_model->get_coupon_list($this->me_id, $status, $page, $num_per_page['coupon_index']);

		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("/ewallet/coupon/".$status."/");
		$config['total_rows'] = $data['count'][$status]['count'];
		$config['per_page'] = $num_per_page['coupon_index'];
		//$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();

		$this->load->view('ewallet/coupon',$data);
	}

	//充值页面
	public function recharge(){
		$this->load->view('ewallet/recharge');
	}

	//充值发起页面
	public function third_pay(){
		//支付回调，应该就需要一个新的控制器了吧？
		$fee = $this->input->post('fee', true);
		$this->form_validation->set_rules('fee','fee','required'); 
		if($this->form_validation->run() == false){ 
			exit('非法提交');
		}
		$fee = number_format($fee, 2, '.', '');
		//获取当前余额(回调成功再获取吧???)
		//$balance = $this->ewallet_model->get_balance($this->me_id);
		//生成支付流水号
		$this->load->helper('payment');
		$this->load->library('util');
		$tid = Util::genTradeNumber();
		//添加钱包充值交易记录
		$result = $this->ewallet_model->add_recharge_log($this->me_id, $tid, $fee);
		if(empty($result)){
			exit('服务器忙，请重试');
		}
		//存储充值金额，用于同步展示充值成功页
		$this->session->set_userdata('recharge_fee', $fee);

		header("Content-type:text/html;charset=utf-8");
		header("Cache-control: private");
		//设置异步配置的key
		$prefix = 'recharge';
		echo alipay_build($tid, '乐帮到家-充值', $fee, '乐帮到家-充值', $prefix);
	}

	//充值成功页
	public function pay_success(){
		$fee = $this->session->userdata('recharge_fee');
		$data['fee'] = empty($fee) ? 0.00 : $fee;
		$this->load->view('ewallet/pay_success', $data);
	}

}