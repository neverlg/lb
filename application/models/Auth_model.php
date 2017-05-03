<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Auth_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function is_login(){
		if($this->session->userdata('me_phone')){
			return true;
		}
		return false;
	}

	public function login($user){
		@extract($user);
		//$where = array('m_name'=>$username, 'm_state'=>0);
		$where = "me_username='$username' OR me_phone='$username' AND me_status=1";
		$result = array();
		$this->db->select('me_id,me_username,me_pass,me_phone')->from('merchant')->where($where);
		$result = $this->db->get()->result_array();
		if(count($result)==1 && $result[0]['me_pass']==md5($password)){
			//$capture_s = strtolower($this->session->flashdata('auth_capture'));
			//if($capture_s == strtolower($capture)){
				$this->session->set_userdata('me_id', $result[0]['me_id']);
				$this->session->set_userdata('me_username', $result[0]['me_username']);
				$this->session->set_userdata('me_phone', $result[0]['me_phone']);

				//merchant_login_log insert
				$data = array(
					'mll_me_id' => $this->session->userdata['me_id'],
					'mll_login_time' => time(),
					'mll_login_ip' => $this->input->ip_address()
					);
				$this->db->insert('merchant_login_log', $data);
				return true;
			//}
		}
		return false;
	}

	public function is_merchant_existed($phone, $name=''){
		$where = array('me_phone'=>$phone);
		if(!empty($name)){
			$or_where = array('me_username'=>$name);
			$num = $this->db->from('merchant')->where($where)->or_where($or_where)->count_all_results();
		}else{
			$num = $this->db->from('merchant')->where($where)->count_all_results();
		}
		return ($num>0) ? true : false;
	}

	public function insert_merchant($data){
		$merchant_info = array(
			'me_username' => $data['name'],
			'me_pass' => md5($data['password']),
			'me_phone' => $data['phone'],
			'me_category' => $data['type'],
			'me_add_time' => time(),
			'me_update_time' => time(),
			'me_add_ip' => $this->input->ip_address(),
			'me_status' => 1
			);
		$this->db->insert('merchant', $merchant_info);
		$merchant_id = $this->db->insert_id();
		if($merchant_id){
			//merchant_login_log insert
			$login_arr = array(
				'mll_me_id' => $merchant_id,
				'mll_login_time' => time(),
				'mll_login_ip' => $this->input->ip_address()
				);
			$this->db->insert('merchant_login_log', $login_arr);
			$this->insert_order_num($merchant_id);
			return true;
		}
		return false;
	}

	//在统计表中插入两条数据，分别是报价、定价订单
	public function insert_order_num($me_id){
		$insert = array(
			array(
				'me_id' => $me_id,
				'order_type' => 1
				),
			array(
				'me_id' => $me_id,
				'order_type' => 2
				)
			);
		$this->db->insert_batch('merchant_order_num', $insert);
	} 

	public function log_out(){
		$this->session->unset_userdata(array('me_id', 'me_username', 'me_phone'));
	}

	//更改用户密码（忘记密码）
	public function change_password($data){
		@extract($data);
		$where = array('me_phone' => $phone);
		$data = array(
			'me_pass' => md5($password)
			);
		$this->db->update('merchant', $data, $where);
		return $this->db->affected_rows();
	}
}