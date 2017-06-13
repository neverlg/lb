<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  师傅
*/

class Master extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	//发现
	public function discover(){
		$this->load->view('master/discover');
	}

}