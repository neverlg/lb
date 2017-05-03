<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//用户评价（过期自动评价功能，用crontab实现）
class Evaluate extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('evaluate_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index($score=0, $page=1){
		$page = ($page>0) ? intval($page) : 1;
		$data['score'] = $score = intval($score);
		$num_per_page = config_item('num_per_page');

		//统计各品类的总数
		$data['total'] = $this->evaluate_model->get_total($this->me_id, $score);
		//获取指定的货品列表
		$data['list'] = $this->evaluate_model->get_list($this->me_id, $score, $page, $num_per_page['evaluate_index']);
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("evaluate/index/{$score}/");
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $num_per_page['evaluate_index'];
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();
		
		$this->load->view('evaluate/index', $data);
	}

	//评价
	public function add($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		$this->load->model('order_model');
		$data['order'] = $this->order_model->get_evaluate_order($this->me_id, $order_id);

		$this->load->view('evaluate/add', $data);
	}

	//评价提交
	public function add_submit($order_id){
		$order_id = intval($order_id);
		$post = $this->input->post(array('score','quality','attitude','ontime','content'), true);
		$this->form_validation->set_rules('score','score','required');
		$this->form_validation->set_rules('quality','quality','required');
		$this->form_validation->set_rules('attitude','attitude','required');
		$this->form_validation->set_rules('ontime','ontime','required');
		$this->form_validation->set_rules('content','content','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		$this->load->model('order_model');
		//此处需要检测用户是否有操作订单的权限
		if($this->order_model->check_power($this->me_id, $order_id)){
			if(!$this->evaluate_model->is_record_exist($order_id)){
				$result = $this->evaluate_model->add_record($this->me_id, $post, $order_id);
				if($result){
					ajax_response(0, 'success');
				}
			}else{
				ajax_response(1, '请勿重复评价该订单');
			}
		}
		ajax_response(1, '系统繁忙，请稍后再试');
	}

}
