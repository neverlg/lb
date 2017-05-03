<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Article_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_list($caterogy='', $limit=''){
		$where = array('status' => 0);
		if(!empty($caterogy)){
			$where['cat_id'] = $caterogy;
		}
		$this->db->select('id, title')->where($where)->order_by('id','DESC');
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		$result = $this->db->get('article')->result_array();
		return $result;
	}

	public function get_article_by_id($art_id){
		$where = array(
			'id' => $art_id,
			'status' => 0
			);
		$result = $this->db->select('title, content, add_time')->where($where)->get('article')->row_array();
		$result['add_time'] = date('Y-m-d H:i', $result['add_time']);
		$result['__content'] = $result['content'];
		unset($result['content']);
		return $result;
	}

	
}