<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 消息中心
*/

class Message extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->me_id = $this->session->userdata('me_id');
		$this->load->model('message_model');
	}

	//首页
	public function index($page=1){
		$page = ($page>1) ? intval($page) : 1;
		$data['total'] = $this->message_model->get_total($this->me_id);
		$num_per_page = config_item('num_per_page');
		$data['list'] = $this->message_model->get_list($this->me_id, $page, $num_per_page['message_index']);

		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("/message/index/");
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $num_per_page['message_index'];
		//$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();

		$this->load->view('message/index', $data);
	}

	//查看详情
	public function detail($id){
		$id = intval($id);
		$data['detail'] = $this->message_model->get_message_by_id($this->me_id, $id);
		//如果消息未读，则标记为已读
		if(!empty($data['detail']) && $data['detail']['status']==0){
			$this->message_model->already_read($this->me_id, $id);
		}

		$this->load->view('message/detail', $data);
	}

	//批量删除
	public function batch_del(){
		$ids = $this->input->post('message_id', true);
		if(!empty($ids)){
			foreach ($ids as $key => $val) {
				$ids[$key] = intval($val);
			}
			$result = $this->message_model->batch_del($this->me_id, $ids);
			if($result > 0){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统异常，请稍后再试');
	}

	//用户反馈页面
	public function feedback(){
		$this->load->view('message/feedback');
	}

	//用户反馈提交
	public function feedback_submit(){
		$content = $this->input->post('content', true);
		if(empty($content)){
			ajax_response(1, '请填写反馈内容');
		}
		$phone = $this->session->userdata('me_phone');
		$result = $this->message_model->add_feedback($this->me_id, $phone, $content);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '系统繁忙，请重试');
	}

}