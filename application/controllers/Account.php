<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 账号管理
*/

class Account extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('account_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	//首页
	public function index(){
		$data['info'] = $this->account_model->get_user_info($this->me_id);
		$category_conf = config_item('merchant_category');
		$data['info']['me_category'] = $category_conf[$data['info']['me_category']];
		$qiniu_conf = config_item('qiniu');
		$data['info']['me_headimg'] = empty($data['info']['me_headimg']) ? "" : $qiniu_conf['source_url'] . $data['info']['me_headimg'];
		//$data['info']['me_headimg'] = '';
		$this->load->view('account/index', $data);
	}

	//个人信息编辑页
	public function edit(){
		$data['info'] = $this->account_model->get_user_info($this->me_id);
		$category_conf = config_item('merchant_category');
		$data['info']['me_category'] = $category_conf[$data['info']['me_category']];
		$tmp_arr = array();
		$data['info']['province'] = $data['info']['city'] = $data['info']['district'] = '';

		if(!empty($data['info']['me_local_area'])){
			$tmp_arr = explode(',', $data['info']['me_local_area']);
			$data['info']['province'] = $tmp_arr[0];
			$data['info']['city'] = $tmp_arr[1];
			$data['info']['district'] = $tmp_arr[2];
		}
		$data['__provinces'] = get_province();
		
		$this->load->view('account/edit', $data);
	}

	//个人信息提交
	public function edit_submit(){
		$post = $this->input->post(array('truename', 'phoneps', 'qq', 'tb_name', 'tb_url', 'province', 'city', 'district', 'detail_address', 'jd_name', 'jd_url'), true);
		$result = $this->account_model->update_info($this->me_id, $post);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '服务器忙，请重试');
	}

	//个人头像页
	public function avatar(){
		$this->load->library('util');
		$qiniu_conf = config_item('qiniu');
		$data['upload_url'] = $qiniu_conf['upload_url'];
		$data['source_url'] = $qiniu_conf['source_url'];
		$bucket = 'lebang';
		$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);

		$this->load->view('account/avatar', $data);
	}

	//头像上传提交
	public function avatar_submit(){
		$url = $this->input->post('url');
		$this->form_validation->set_rules('url','url','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}
		$result = $this->account_model->update_avatar($this->me_id, $url);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '服务器忙，请重试');
	}

	//安全设置页面
	public function security(){
		$phone = $this->session->userdata('me_phone');
		$data['phone'] = substr($phone, 0, 3) . '*****' . substr($phone, -3);

		$this->load->view('account/security', $data);
	}

	//修改手机号
	public function change_phone(){
		$phone = $this->session->userdata('me_phone');
		$data['phone'] = substr($phone, 0, 3) . '*****' . substr($phone, -3);

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

		$this->load->view('account/change_phone', $data);
	}

	//修改手机号submit
	public function new_phone_save(){
		$data = $this->input->post(array('phone','code'));
		$this->form_validation->set_rules('phone','phone','required');
		$this->form_validation->set_rules('code','code','required');
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
		if($this->account_model->is_merchant_existed($data['phone'])){
			ajax_response(1, '用户名或手机号已经存在');
		}
		$result = $this->account_model->update_phone($this->me_id, $data['phone']);
		if($result > 0){
			$this->session->set_userdata('me_phone', $data['phone']);
			ajax_response(0,'success');
		}
		ajax_response(1,'系统异常，请稍后再试');
	}

	//修改密码页面
	public function change_password(){
		$this->load->view('account/change_password');
	}

	//修改密码submit
	public function new_password_save(){
		$data = $this->input->post(array('origin_password','password','passconf'));
		$this->form_validation->set_rules('origin_password','origin_password','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('passconf','passconf','required|matches[password]');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		if(!$this->account_model->check_password($this->me_id, $data['origin_password'])){
			ajax_response(1,'当前密码输入错误');
		}
		$result = $this->account_model->update_password($this->me_id, $data['password']);
		if($result > 0){
			$this->load->model('auth_model');
			$this->auth_model->log_out();
			ajax_response(0,'success');
		}
		ajax_response(1,'系统异常，请稍后再试');
	}

}