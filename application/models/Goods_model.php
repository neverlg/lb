<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Goods_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_category_count($me_id, $priced_type){
		$where = array('go_priced_type'=>$priced_type, 'go_me_id'=>$me_id, 'go_status !='=>3);

		$this->db->select('go_type, count(*) as count')->from('goods')->where($where)->group_by('go_type');
		$result = $this->db->get()->result_array();
		return $this->format_category_count($result);
	}

	public function get_goods_list($me_id, $priced_type, $go_type, $page, $num_per_page){
		$where = array('go_priced_type'=>$priced_type, 'go_me_id'=>$me_id, 'go_status !='=>3);
		if(!empty($go_type)){
			$where['go_type'] = $go_type;
		}
		$start = ($page-1)*$num_per_page;
		$this->db->select('go_id, go_name, go_img, go_me_money')->from('goods')->where($where)->limit($num_per_page, $start);
		$result = $this->db->get()->result_array();

		$qiniu = config_item('qiniu');
		foreach ($result as $key => $val) {
			$result[$key]['go_img'] = $qiniu['source_url'].$val['go_img'];
		}
		return $result;
	}

	public function get_item($me_id, $go_id){
		$where = array(
			'go_me_id' => $me_id,
			'go_id' => $go_id
			);
		$result = $this->db->where($where)->get('goods')->row_array();

		$qiniu = config_item('qiniu');
		$result['go_img_full'] = $qiniu['source_url'].$result['go_img'];
		return $result;
	}

	public function update_goods($go_id, $post){
		@extract($post);
		$data = array(
			'go_name' => $name,
			'go_img' => $img,
			'go_type' => intval($type),
			'go_update_time' => time()
			);
		$where = array('go_id' => $go_id);
		$this->db->update('goods',$data,$where);
		return $this->db->affected_rows();
	}

	public function del_goods($go_id){
		$data = array('go_status' => 3);
		$where = array('go_id' => $go_id);
		$this->db->update('goods',$data,$where);
		return $this->db->affected_rows();
	}

	public function add($priced_type, $post){
		@extract($post);
		$ip = $this->input->ip_address();
		foreach ($name as $k => $val){
			if (!empty($val)){
				$data[$k]['go_name'] = $val;
				$data[$k]['go_type'] = intval($type[$k]);
				$data[$k]['go_img'] = $img[$k];
				$data[$k]['go_me_id'] = $this->session->userdata('me_id');
				$data[$k]['go_add_time'] = time();
				$data[$k]['go_add_ip'] = $ip;
				$data[$k]['go_priced_type'] = $priced_type;
			}
		}
		$this->db->insert_batch('goods', $data);
		return $this->db->affected_rows();
	}

	//格式化数组
	private function format_category_count($arr){
		$result = array();
		$len = count(config_item('goods'));
		$total = 0;
		for ($i=0; $i <= $len ; $i++) { 
			$result[$i] = 0;
		}
		if(!empty($arr)){
			$tmp = array_column($arr, 'count', 'go_type');
			foreach ($tmp as $key => $val) {
				$result[$key] = $val;
				$total += $val;
			}
			//下标为0，存储总数
			$result[0] = $total;
		}
		return $result;
	}

	public function get_goods_data($me_id, $priced_type){
		$where = array(
			'go_me_id' => $me_id,
			'go_priced_type' => $priced_type,
			'go_status!=' => 3
			);
		$result = $this->db->select("go_id, go_name, go_img, go_type")->from("goods")->where($where)->get()->result_array();

		$qiniu = config_item('qiniu');
		$goods_type = config_item('goods');
		$final_result = array();
		foreach ($result as $key => &$val) {
			$val['go_full_img'] = $qiniu['source_url'].$val['go_img'];
			$val['go_type_txt'] = $goods_type[$val['go_type']];
			$final_result[$val['go_type']][] = $val; 
		}
		$final_result[0] = $result;
		//将子数组键改为go_id
		foreach ($final_result as $key => $value) {
			$final_result[$key] = array_column($value, null, 'go_id');
		}
		return $final_result;
	}

	public function search_by_name($me_id, $priced_type, $name){
		$where = array(
			'go_me_id' => $me_id,
			'go_priced_type' => $priced_type,
			'go_status!=' => 3,
			'go_name' => $name
			);
		$result = $this->db->select("go_id, go_name, go_img, go_type")->from("goods")->where($where)->get()->result_array();

		$qiniu = config_item('qiniu');
		foreach ($result as &$val) {
			$val['go_full_img'] = $qiniu['source_url'].$val['go_img'];
		}
		return $result;
	}
}