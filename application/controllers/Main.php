<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//网站首页，关于我们，服务方式，服务保障
class Main extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->output->enable_profiler(TRUE);
	}

	//首页
	public function index($login=''){
		$data = array();
		$data['show_login'] = ($login=='login') ? true : false;
		if($this->session->userdata('me_id')){
			$data['show_login'] = false;
		}
		//首页统计数据，走缓存
		$this->load->library('lb_redis');
		$homepage_counts = Lb_redis::get('homepage_counts');
		if($homepage_counts){
			$data['total'] = unserialize($homepage_counts);
		}else{
			$this->load->model('main_model');
			$data['total'] = $this->main_model->get_index_num();
			Lb_redis::set('homepage_counts', serialize($data['total']), 600);
		}

		//图形验证码
		if($data['show_login']){
			$this->load->helper('captcha');
			$vals = array(
    				'img_path'  => './captcha/',
    				'img_url'   => http_type().$_SERVER['HTTP_HOST'].'/captcha/',
    				'font_path' => './assets/fonts/TextileRegular.ttf',
    				'expiration' => 300,
    				'word_length' => 4,
    				'colors'    => array(
				        'background' => array(0, 0, 0),
				        'border' => array(0, 0, 0),
				        'text' => array(255, 255, 255),
				        'grid' => array(255, 10, 10)
    				)
 				);
			$cap = create_captcha($vals);
			$this->session->set_flashdata('auth_capture', $cap['word']);
			$data['__captcha'] = $cap['image'];
		}

        $this->load->model('order_model');
        $data['newest'] = $this->order_model->get_newest_item(2);

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

	//快捷方式
	public function shortcut(){
		$content='
[DEFAULT]
BASEURL=http://shangjia.lebangdaojia.com
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2
[InternetShortcut]
URL=http://shangjia.lebangdaojia.com
IDList=[{000214A0-0000-0000-C000-000000000046}]
IconFile=http://shangjia.lebangdaojia.com/assets/images/51.png
IconIndex=1
HotKey=0
Prop3=19,2';
	header("Content-type:application/octet-stream");
	header("Content-Disposition:attachment; filename=乐帮到家.url;");
	echo $content;
	}
}
