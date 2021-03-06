<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Province_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_all_items(){
		$where = array(
			'stutas' => 0
			);
		$result = $this->db->select('id, name, parentid')->where($where)->get('province')->result_array();
		$result = $this->format_province($result);
		return $result;
	}

	private function format_province($result){
		$tmp_arr = array();
		foreach ($result as $val) {
			$tmp_arr[$val['parentid']][$val['id']] = $val['name'];
		}
		return $tmp_arr;
	}

	public function getParentsCouple($area_id){
	    $areas = getAreas();
        $crumbs = [];
	    do{
	        if (empty($areas[$area_id])){
	            break;
            }
            $area = $areas[$area_id];
            $crumbs[$area_id] = $area['n'];
            if (empty($area['p'])){
                break;
            }
            $area_id = $area['p'];
        }while(true);
        return array_reverse($crumbs,true);
    }
}