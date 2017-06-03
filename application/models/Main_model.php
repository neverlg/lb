<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Main_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_index_num(){
		$total = array();
		$total['master'] = $this->db->from('master')->where(array('status'=>1))->count_all_results();
		$total['merchant'] = $this->db->from('merchant')->count_all_results();
		$total['city'] = $this->db->from('province')->where(array('stutas'=>0, 'parentid>'=>0))->count_all_results();
		return $total;
	}
}