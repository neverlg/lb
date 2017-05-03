<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//货品仓库（报价下单priced_type=1，定价下单priced_type=2）
class Goods extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('goods_model');
		$this->load->library('form_validation');
		$this->me_id = $this->session->userdata('me_id');
		$this->form_validation->set_error_delimiters('','');
	}

	//默认报价订单，全品类
	public function index($priced_type=1, $go_type=0, $page=1){
		$data['priced_type'] = $priced_type = intval($priced_type);
		$data['go_type'] = $go_type = intval($go_type);
		$page = ($page>0) ? intval($page) : 1;
		$num_per_page = config_item('num_per_page');
		
		//统计各品类的总数
		$data['category_count'] = $this->goods_model->get_category_count($this->me_id, $priced_type);
		//获取指定的货品列表
		$data['list'] = $this->goods_model->get_goods_list($this->me_id, $priced_type, $go_type, $page, $num_per_page['goods_index']);
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("goods/index/$priced_type/$go_type");
		$config['total_rows'] = $data['category_count'][$go_type];
		$config['per_page'] = $num_per_page['goods_index'];
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['__pagination_url'] = $this->pagination->create_links();
		
		$this->load->view('goods/index', $data);
	}

	//编辑用新页面吧
	public function edit($go_id){
		$data['go_id'] = $go_id = intval($go_id);
		$data['goods'] = $this->goods_model->get_item($this->me_id, $go_id);
		//此处编辑，暂不允许编辑图片
		/*
		$this->load->library('util');
		$qiniu_conf = config_item('qiniu');
		$data['upload_url'] = $qiniu_conf['upload_url'];
		$data['source_url'] = $qiniu_conf['source_url'];
		$bucket = 'lebang';
		$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);
		*/
		$this->load->view('goods/edit', $data);
	}

	//编辑提交
	public function edit_submit($go_id){
		$go_id = intval($go_id);
		$post = $this->input->post(array('name','img','type'), true);
		$this->form_validation->set_rules('name','name','required');
		$this->form_validation->set_rules('img','img','required');
		$this->form_validation->set_rules('type','type','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}
		$result = $this->goods_model->update_goods($go_id, $post);
		if($result > 0){
			ajax_response(0, 'success');
		}
		ajax_response(1, '系统异常，请稍后再试');
	}

	//删除提交
	public function del($priced_type, $go_type, $go_id){
		$priced_type = intval($priced_type);
		$go_type = intval($go_type);
		$go_id = intval($go_id);
		$result = $this->goods_model->del_goods($go_id);
		if($result > 0){
			redirect(site_url('goods/index/'.$priced_type.'/'.$go_type));
		}
	}

	//上传页面
	public function add($priced_type){
		$data['priced_type'] = intval($priced_type);
		$this->load->library('util');
		$qiniu_conf = config_item('qiniu');
		$data['upload_url'] = $qiniu_conf['upload_url'];
		$data['source_url'] = $qiniu_conf['source_url'];
		$bucket = 'lebang';
		$data['up_token'] = Util::get_qiniu_token($qiniu_conf['access_key'], $qiniu_conf['secret_key'], $bucket);

		$this->load->view('goods/add', $data);
	}

	//批量添加提交
	public function add_submit($priced_type){
		$priced_type = intval($priced_type);
		if(!in_array($priced_type, array(1,2))){
			ajax_response(1, '系统异常，请稍后再试');
		}
		$post = $this->input->post(array('name','img','type'),true);
		$this->form_validation->set_rules('name[]','name','required');
		$this->form_validation->set_rules('img[]','img','required');
		$this->form_validation->set_rules('type[]','type','required');
		if($this->form_validation->run() == false){
			ajax_response(1,validation_errors());
		}
		/*此处暂且不做name排重*/
		$result = $this->goods_model->add($priced_type, $post);
		if($result){
			ajax_response(0,'success');
		}
		ajax_response(1,'服务器繁忙，请重试');
	}

	//下单时，货品弹框统计数目
	public function ajax_get_goods_num(){
		$data = $this->goods_model->get_category_count($this->me_id, 1);
		ajax_response(0, 'success', $data);
	}

	//下单时，货品弹框获取用户所有的货品信息
	public function ajax_get_goods_info(){
		$data = $this->goods_model->get_goods_data($this->me_id, 1);
		ajax_response(0, 'success', $data, false);
	}

	//下单时，货品弹框搜索货品名称
	public function ajax_search_goods($name){
		$data = $this->goods_model->search_by_name($this->me_id, 1, $name);
		ajax_response(0, 'success', $data, false);
	}

}
