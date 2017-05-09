<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 验证用户权限（所有敏感地方，使用弹出验证码，增加安全性）
*/

class Auth extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->helper('captcha');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	//ajax create captcha
	public function user_captcha($is_ajax=true){
		$vals = array(
    				'img_path'  => './captcha/',
    				'img_url'   => http_type().$_SERVER['HTTP_HOST'].'/captcha/',
    				'font_path' => './assets/fonts/TextileRegular.ttf',
    				'font_size' => 20,
    				'expiration' => 300,
    				'img_id' => 'captcha',
    				'word_length' => 4,
    				//'img_width' => '300',
    				//'img_height' => '50',
 				);

		$cap = create_captcha($vals);
		//$data['img'] = htmlspecialchars_decode($cap['image']);
		$this->session->set_flashdata('auth_capture', $cap['word']);
		if($is_ajax){
			ajax_response(0,'success', $cap['image'], false);
		}else{
			return $cap['image'];
		}
	}

	public function login_submit(){
		$user = $this->input->post(array('username','password','captcha'), true);
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('captcha','captcha','required');

		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		$capture_s = strtolower($this->session->flashdata('auth_capture'));
		$captcha = strtolower($user['captcha']);
		if($captcha != $capture_s){
			ajax_response(1,'图形验证码错误！');
		}

		if(!$this->auth_model->login($user)){
			ajax_response(1,'账号或密码有误');
		}

		ajax_response(0, 'success');
	}

	//发送短信验证码时，需要进行图形验证码确认
	//1注册 2修改手机号码 3找回密码 4报价 5补款 6退款 7设置钱包密码 8找回钱包密码
	public function send_sms($type=1){
		$type = intval($type);
		$data = $this->input->post(array('phone','captcha'), true);
		$se_phone = $this->session->userdata('me_phone');
		if($se_phone){
			$data['phone'] = $se_phone;
		}else{
			$this->form_validation->set_rules('phone','phone','required');
		}
		$this->form_validation->set_rules('captcha','captcha','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if(!check_mobile($data['phone'])){
			ajax_response(1, '手机号不合法');
		}

		//如果是修改手机号，则新旧手机号不能相同
		if($type == 2){
			if($data['phone'] == $se_phone){
				ajax_response(1, '新旧手机号相同');
			}
		}

		$capture_s = strtolower($this->session->flashdata('auth_capture'));
		if($capture_s == strtolower($data['captcha'])){
			//检查验证码次数，从配置文件获取
			$config_sms_counts = config_item('sms_count');
			$config_sms_expire = config_item('sms_expire');
			$config_sms_length = config_item('sms_length');
			$now_sms_counts = $this->session->userdata('sms_counts') ? $this->session->userdata('sms_counts') : 0;
			$now_sms_time = $this->session->userdata('sms_time');
			if($now_sms_counts<$config_sms_counts || ($now_sms_counts>=$config_sms_counts && (time()-$now_sms_time>$config_sms_expire))){
				$sms_code = generate_sms_code($config_sms_length);
				$msg = '';
				switch ($type) {
					case 1:
						$msg = '【乐帮到家】您的验证码为：'. $sms_code .',此验证码只用于注册';
						break;
					case 2:
						$msg = '【乐帮到家】您的验证码为：'. $sms_code .',此验证码只用于验证新手机号码';
						break;
					case 3:
						$msg = '【乐帮到家】您的验证码为：'. $sms_code .',此验证码只用于找回密码';
						break;
					case 7:
						$msg = '【乐帮到家】您的验证码为：'. $sms_code .',此验证码只用于支付密码设置';
						break;
					default:
						break;
				}
				send_sms($msg, $data['phone'], $type, $sms_code);
				$sms_count = ($now_sms_counts<$config_sms_counts) ? $now_sms_counts+1 : 1;
				//set session
				$arr = array(
					'sms_counts' => $sms_count,
					'sms_time' => time(),
					'sms_code' => $sms_code,
					'sms_phone' => $data['phone']
					);
				$this->session->set_userdata($arr);
				ajax_response(0,'success');
			}else{
				ajax_response(1,'短信验证码发送过于频繁！');
			}
		}else{
			ajax_response(1,'图形验证码错误！');
		}
	}

	//注册页面
	public function register(){
		$data['__captcha_img'] = $this->user_captcha(false);
		$this->load->view('auth/register', $data);
	}

	//注册信息提交
	public function register_submit(){
		$data = $this->input->post(array('phone','code','password','passconf','name','type'));
		$this->form_validation->set_rules('phone','phone','required');
		$this->form_validation->set_rules('code','code','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('passconf','passconf','required|matches[password]');
		$this->form_validation->set_rules('name','name','required');
		$this->form_validation->set_rules('type','type','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if(!check_mobile($data['phone'])){
			ajax_response(1, '手机号不合法');
		}
		if($data['phone'] != $this->session->userdata['sms_phone']){
			ajax_response(1, '手机号有误');
		}
		if($data['code'] != $this->session->userdata['sms_code']){
			ajax_response(1, '手机验证码错误');
		}
		if($this->session->userdata['sms_time'] < time()-config_item('sms_submit_expire')){
			ajax_response(1, '验证码已失效');
		}
		if($this->auth_model->is_merchant_existed($data['phone'], $data['name'])){
			ajax_response(1, '用户名或手机号已经存在');
		}
		if($this->auth_model->insert_merchant($data)){
			ajax_response(0,'success');
		}
		ajax_response(1, '系统异常，请稍后再试');
	}

	//忘记密码
	public function forget_password(){
		$data['__captcha_img'] = $this->user_captcha(false);
		$this->load->view('auth/forget_password', $data);
	}

	//忘记密码提交
	public function forget_submit(){
		$data = $this->input->post(array('phone','code','password','passconf'));
		$this->form_validation->set_rules('phone','phone','required');
		$this->form_validation->set_rules('code','code','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('passconf','passconf','required|matches[password]');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if(!check_mobile($data['phone'])){
			ajax_response(1, '手机号不合法');
		}
		if($data['phone'] != $this->session->userdata['sms_phone']){
			ajax_response(1, '手机号有误');
		}
		if($data['code'] != $this->session->userdata['sms_code']){
			ajax_response(1, '手机验证码错误');
		}
		if($this->session->userdata['sms_time'] < time()-config_item('sms_submit_expire')){
			ajax_response(1, '验证码已失效');
		}
		if(!$this->auth_model->is_merchant_existed($data['phone'])){
			ajax_response(1, '该用户不存在');
		}
		if($this->auth_model->change_password($data)){
			ajax_response(0,'success');
		}
		ajax_response(1, '系统异常，请稍后再试');
	}

	//安全退出
	public function log_out(){
		$this->auth_model->log_out();
		redirect('main/index');
	}

	//定价批量下单申请页
	public function priced_apply(){
		$this->load->view('auth/priced_apply');
	}

	//定价批量下单申请提交
	public function priced_submit(){
		$data = $this->input->post(array('name', 'phone', 'email', 'shop_url'), true);
		$this->form_validation->set_rules('name','name','required');
		$this->form_validation->set_rules('phone','phone','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if(!check_mobile($data['phone'])){
			ajax_response(1, '手机号不合法');
		}

		//根据入口，此处应该需要登录（功能上不一定）
		$me_id = $this->session->userdata('me_id');
		$me_id = empty($me_id) ? 0 : $me_id;
		$result = $this->auth_model->insert_apply($me_id, $data);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '系统繁忙，请稍后再试');
	}
}