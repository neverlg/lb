<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Message_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_total($me_id){
		$where = array(
			'me_id' => $me_id,
			'status<' => 2
			);
		return $this->db->from('message')->where($where)->count_all_results();
	}

	public function get_unread_total($me_id){
		$where = array(
			'me_id' => $me_id,
			'status' => 0
			);
		return $this->db->from('message')->where($where)->count_all_results();
	}

	public function get_list($me_id, $page, $num_per_page){
		$where = array(
			'me_id' => $me_id,
			'status<' => 2
			);
		$start = ($page-1)*$num_per_page;
		$this->db->select('id, title, create_time, status')->from('message')->where($where)->order_by('status ASC, id DESC')->limit($num_per_page, $start);
		$result = $this->db->get()->result_array();
		foreach ($result as $key => $val) {
			$result[$key]['create_time'] = date('Y-m-d H:i', $val['create_time']);
		}
		return $result;
	}

	public function get_message_by_id($me_id, $id){
		$where = array(
			'id' => $id,
			'me_id' => $me_id,
			'status<' => 2
			);
		$result = $this->db->select('content, status')->where($where)->get('message')->row_array();
		$result['__content'] = $result['content'];
		unset($result['content']);
		return $result;
	}

	public function already_read($me_id, $id){
		$where = array(
			'id' => $id,
			'me_id' => $me_id
			);
		$data = array(
			'status' => 1,
			'read_time' => time()
			);
		$this->db->update('message', $data, $where);
		return $this->db->affected_rows();
	}

	public function batch_del($me_id, $ids){
		$this->db->set('status', 2);
		$this->db->where('me_id', $me_id);
		$this->db->where_in('id', $ids);
		$this->db->update('message');
		return $this->db->affected_rows();
	}

	public function add_feedback($me_id, $phone, $content){
		$data = array(
			'fe_me_id' => $me_id ? $me_id : 0,
			'fe_phone' => $phone ? $phone : '',
			'fe_info' => $content,
			'add_time' => time()
			);
		$this->db->insert('feedback', $data);
		return $this->db->insert_id();
	}
	
}