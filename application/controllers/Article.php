<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 帮助中心
*/

class Article extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('article_model');
	}

	//首页
	public function index($caterogy=0){
		$article_conf = config_item('article');
		$data['category'] = $caterogy = array_key_exists($caterogy, $article_conf) ? intval($caterogy) : 0;
		$data['category_name'] = $article_conf[$caterogy];
		$data['info'] = $this->article_model->get_list($caterogy);

		$this->load->view('article/index', $data);
	}

	//查看内容
	public function detail($str){
		$arr = explode('-', $str);
		$data['category'] = $category = intval($arr[0]);
		$article_conf = config_item('article');
		$data['category_name'] = isset($article_conf[$category]) ? $article_conf[$category] : '';
		$art_id = intval($arr[1]);
		$data['detail'] = $this->article_model->get_article_by_id($art_id);

		$this->load->view('article/detail', $data);
	}	

}