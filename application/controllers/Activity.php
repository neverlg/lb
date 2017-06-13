<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  优惠活动
*/

class Activity extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	//首页
	public function index(){
		$this->load->view('activity/index');
	}

}