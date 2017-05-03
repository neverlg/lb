<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Sms_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	
	public function add_sms_log($content,$to,$type,$code){
		$data = array(
			'sl_me_id' => $this->session->userdata('me_id'),
			'sl_content' => $content,
			'sl_phone' => $to,
			'sl_type' => $type,
			'sl_code' => $code,
			'sl_add_time' => time(),
			'sl_add_ip' => $this->input->ip_address()
			);
		$this->db->insert('sms_log', $data);
		return $this->db->insert_id();
	}

	public function upd_sms_log($sl_id,$result){
		$info = array('sl_error'=>$stutas);
		$where = array('sl_id'=>$id);
		$this->db->update('sms_log',$info,$where);
		return $this->db->affected_rows();
	}
}