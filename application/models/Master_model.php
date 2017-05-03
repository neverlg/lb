<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Master_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	//选取已审核的，在服务区域内的师傅userid，暂不要服务类型判断
	public function get_suitable_userid($area_id, $service_type){
		$sql = "SELECT weixin_userid FROM master WHERE FIND_IN_SET($area_id, service_area_ids) AND status=1";
		return $this->db->query($sql)->result_array();
	}

}