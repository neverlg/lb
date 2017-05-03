<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class News_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_list($caterogy='', $limit=''){
		$where = array('status' => 0);
		if(!empty($caterogy)){
			$where['category'] = $caterogy;
		}
		$this->db->select('id, title, create_time')->where($where)->order_by('id','DESC');
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		$result = $this->db->get('news')->result_array();
		foreach ($result as $key => $val) {
			$result[$key]['create_time'] = date('Y-m-d H:i', $val['create_time']);
		}
		return $result;
	}

	public function get_news_by_id($news_id){
		$where = array(
			'id' => $news_id,
			'status' => 0
			);
		$result = $this->db->select('title, content, create_time')->where($where)->get('news')->row_array();
		$result['create_time'] = date('Y-m-d H:i', $result['create_time']);
		$result['__content'] = $result['content'];
		unset($result['content']);
		return $result;
	}

	
}