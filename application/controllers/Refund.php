<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 退款管理
*/

class Refund extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('refund_model');
		$this->load->model('order_model');
		$this->me_id = $this->session->userdata('me_id');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	}

	//首页
	//order_type 1报价  2定价
	public function index($order_type=1, $order_sn=0, $refund_status=0, $page=1){
		$page = ($page>0) ? intval($page) : 1;
		$refund_status = intval($refund_status);
		$order_type = intval($order_type);

		$num_per_page = config_item('num_per_page');
		//获取总数
		$total = $this->refund_model->get_refund_total($this->me_id, $order_type, $order_sn, $refund_status);
		//获取列表
		$data['list'] = $this->refund_model->get_refund_list($this->me_id, $order_type, $order_sn, $refund_status, $page, $num_per_page['refund_index']);

		$data['order_type'] = $order_type;
		$data['order_sn'] = empty($order_sn) ? '' : $order_sn; 
		$data['refund_status'] = $refund_status;
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("/refund/index/".$order_type."/".$order_sn."/".$refund_status."/");
		$config['total_rows'] = $total;
		$config['per_page'] = $num_per_page['refund_index'];
		//$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();

		$this->load->view('refund/index',$data);
	}

	//详情页
	public function detail($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		$data['order'] = $this->order_model->get_refund_order($this->me_id, $order_id);
		$data['refund'] = $this->refund_model->get_detail($order_id);

		$tag = 1;
		switch ($data['refund']['refund_result_type']) {
			case '1':
				$tag = 1;
				$data['auto_refund_time'] = config_item('auto_refund_time');
				break;
			case '2':
				$tag = 2;
				$this->load->library('util');
				$qiniu_conf = config_item('qiniu');
				$data['upload_url'] = $qiniu_conf['upload_url'];
				$data['source_url'] = $qiniu_conf['source_url'];
				$bucket = 'lebang';
				$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);
				break;
			case '3':
			case '4':
				if($data['refund']['arbitrate_status'] == 0){
					$tag = '3_0';
				}else{
					$tag = '3_1';
				}
				break;
			case '5':
				$tag = 5;
				break;
			case '6':
				$tag = 6;
				break;
		}
		$this->load->view('refund/detail_'.$tag, $data);
	}

	//添加退款页面
	public function add($order_id){
		$data['order_id'] = $order_id = intval($order_id);
		$data['order'] = $this->order_model->get_refund_order($this->me_id, $order_id);

		$this->load->view('refund/add', $data);
	}

	//退款提交
	public function add_submit($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$post = $this->input->post(array('type', 'fee', 'method', 'reason'), true);
			$this->form_validation->set_rules('type','type','required');
			$this->form_validation->set_rules('fee','fee','required');
			$this->form_validation->set_rules('method','method','required');
			$this->form_validation->set_rules('reason','reason','required');
			if($this->form_validation->run() == false){
				ajax_response(1,validation_errors());
			}
			//此处应去重
			if($this->refund_model->is_orderid_exist($order_id)){
				ajax_response(1, '请勿重复提交退款');
			}

			$this->load->library('util');
			$number = Util::getRefundNumber();
			$result = $this->refund_model->add_record($this->me_id, $order_id, $number, $post);
			if($result){
				ajax_response(0, 'success');
			}	
		}
		ajax_response(1, '系统繁忙，请重试');
	}

	//取消退款
	public function cancel($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$result = $this->refund_model->cancel_refund($this->me_id, $order_id);
			if($result){
				redirect(site_url('refund/index'));
			}
		}
	}

	//重新申请退款，此处做成编辑模式，但不必获取原因数据
	public function edit($order_id){
		$order_id = intval($order_id);
		$data['order_id'] = $order_id = intval($order_id);
		$data['order'] = $this->order_model->get_refund_order($this->me_id, $order_id);

		$this->load->view('refund/edit', $data);
	}

	//编辑提交
	public function edit_submit($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$post = $this->input->post(array('type', 'fee', 'method', 'reason'), true);
			$this->form_validation->set_rules('type','type','required');
			$this->form_validation->set_rules('fee','fee','required');
			$this->form_validation->set_rules('method','method','required');
			$this->form_validation->set_rules('reason','reason','required');
			if($this->form_validation->run() == false){
				ajax_response(1,validation_errors());
			}

			$result = $this->refund_model->update_record($this->me_id, $order_id, $post);
			if($result){
				ajax_response(0, 'success');
			}	
		}
		ajax_response(1, '系统繁忙，请重试');
	}

	//仲裁提交
	public function add_arbitrate($order_id){
		$order_id = intval($order_id);
		if($this->order_model->check_power($this->me_id, $order_id)){
			$post = $this->input->post(array('name', 'phone', 'explain', 'img'), true);
			$this->form_validation->set_rules('name','name','required');
			$this->form_validation->set_rules('phone','phone','required');
			$this->form_validation->set_rules('explain','explain','required');
			$this->form_validation->set_rules('img[]','img[]','required');
			if($this->form_validation->run() == false){
				ajax_response(1,validation_errors());
			}

			if(!check_mobile($post['phone'])){
				ajax_response(1, '手机号不合法');
			}

			$result = $this->refund_model->add_arbitrate($this->me_id, $order_id, $post);
			if($result){
				ajax_response(0, 'success');
			}
		}
		ajax_response(1, '系统繁忙，请重试');
	}
}