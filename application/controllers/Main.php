<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//网站首页，关于我们，服务方式，服务保障
class Main extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	//首页
	public function index($login=''){
		$data = array();
		$data['show_login'] = ($login=='login') ? true : false;
		if($this->session->userdata('me_id')){
			$data['show_login'] = false;
		}
		//图形验证码
		if($data['show_login']){
			$this->load->helper('captcha');
			$vals = array(
    				'img_path'  => './captcha/',
    				'img_url'   => http_type().$_SERVER['HTTP_HOST'].'/captcha/',
    				'font_path' => './assets/fonts/TextileRegular.ttf',
    				'font_size' => 20,
    				'expiration' => 300,
    				'word_length' => 4
 				);
			$cap = create_captcha($vals);
			$this->session->set_flashdata('auth_capture', $cap['word']);
			$data['__captcha'] = $cap['image'];
		}
		$this->load->view('main/index', $data);
	}

	//关于我们
	public function about_us(){
		$this->load->view('main/about_us');
	}

	//师傅入驻
	public function master_settle(){
		$this->load->view('main/master_settle');
	}

	//服务保障
	public function guarantee(){
		$this->load->view('main/service_guarantee');
	}

	//服务保障
	public function service(){
		$this->load->view('main/service_type');
	}
}
