<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//投诉
class Complain extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('complain_model');
		$this->load->model('order_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	
	public function index($co_number=0, $or_number=0, $handle_status=0, $page=1){
		$page = ($page>0) ? intval($page) : 1;
		$data['co_number'] =  empty($co_number) ? 0 : $co_number;
		$data['or_number'] =  empty($or_number) ? 0 : $or_number;
		$data['handle_status'] = empty($handle_status) ? 0 : intval($handle_status);
		$post = $data;

		$num_per_page = config_item('num_per_page');
		//统计各状态的总数
		$data['total'] = $this->complain_model->get_total($this->me_id, $post);

		//获取列表
		$data['list'] = $this->complain_model->get_list($this->me_id, $post, $page, $num_per_page['evaluate_index']);
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("complain/index/{$co_number}/{$or_number}/{$handle_status}/");
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $num_per_page['evaluate_index'];
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();
		
		$this->load->view('complain/index', $data);
	}

	//发起投诉
	public function add($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		$data['order'] = $this->order_model->get_complain_order($this->me_id, $order_id);
		$category = config_item('complain_category');
		$data['__category'] = json_encode($category);

		$this->load->library('util');
		$qiniu_conf = config_item('qiniu');
		$data['upload_url'] = $qiniu_conf['upload_url'];
		$data['source_url'] = $qiniu_conf['source_url'];
		$bucket = 'lebang';
		$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);

		$this->load->view('complain/add', $data);
	}

	//投诉提交
	public function add_submit($order_id){
		$order_id = intval($order_id);
		$post = $this->input->post(array('category','subcategory','content','img'), true);
		$this->form_validation->set_rules('category','category','required');
		$this->form_validation->set_rules('subcategory','subcategory','required');
		$this->form_validation->set_rules('content','content','required');
		$this->form_validation->set_rules('img[]','img','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}

		//此处需要检测用户是否有操作订单的权限
		if($this->order_model->check_power($this->me_id, $order_id)){
			//如果该订单的投诉存在，则不允许再次提交
			if($this->complain_model->is_record_exist($order_id)){
				ajax_response(1, '您已对该订单发起过投诉');
			}
			$this->load->library('util');
			$number = Util::getComplainNumber();
			$result = $this->complain_model->add_record($this->me_id, $post, $order_id, $number);
			if($result){
				$this->load->library('admin_server');
				$ret_arr = $this->admin_server->merchant_complain_call($result);
				//如果失败，记录日志
				if(empty($ret_arr) || $ret_arr['code']!=200){
					$str = var_export($ret_arr, true);
					log_message('error', '【投诉师傅通知api失败】complain_id='.$result."\r\n返回值为：".$str);
				}
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请稍后再试');
	}

	//投诉详情
	public function detail($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		$data['order'] = $this->order_model->get_complain_order($this->me_id, $order_id);
		$data['detail'] = $this->complain_model->get_detail($this->me_id, $order_id);

		$this->load->view('complain/detail', $data);
	}

	//撤销投诉
	public function del($order_id){
		$order_id = intval($order_id);
		$result = $this->complain_model->cancel_item($order_id, $this->me_id);
		redirect(site_url('complain/index'));
	}

}
