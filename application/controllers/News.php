<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 新闻中心
*/

class News extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('news_model');
	}

	//首页
//	public function index($caterogy=0){
//		$article_conf = config_item('news');
//		$data['category'] = $caterogy = array_key_exists($caterogy, $article_conf) ? intval($caterogy) : 0;
//		$data['category_name'] = $article_conf[$caterogy];
//		$data['info'] = $this->news_model->get_list($caterogy);
//
//		$this->load->view('news/index', $data);
//	}
    public function index($caterogy=5){
		$article_conf = config_item('news');
		$data['category'] = $caterogy = array_key_exists($caterogy, $article_conf) ? intval($caterogy) : 5;
		$data['category_name'] = $article_conf[$caterogy];
		$data['info'] = $this->article_model->get_list($caterogy);

		$this->load->view('news/index', $data);
	}

	//查看内容
//	public function detail($str){
//		$arr = explode('-', $str);
//		$data['category'] = $category = intval($arr[0]);
//		$news_conf = config_item('news');
//		$data['category_name'] = isset($news_conf[$category]) ? $news_conf[$category] : '';
//		$news_id = intval($arr[1]);
//		$data['detail'] = $this->news_model->get_news_by_id($news_id);
//
//		$this->load->view('news/detail', $data);
//	}
    public function detail($str){
        $arr = explode('-', $str);
        $data['category'] = $category = intval($arr[0]);
        $news_conf = config_item('news');
        $data['category_name'] = isset($news_conf[$category]) ? $news_conf[$category] : '';
        $news_id = intval($arr[1]);
        $data['detail'] = $this->article_model->get_article_by_id($news_id);

        $this->load->view('news/detail', $data);
    }

}