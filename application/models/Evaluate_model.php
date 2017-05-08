<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Evaluate_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_total($me_id, $score){
		$where = array('oe_meid' => $me_id);
		if(!empty($score)){
			$where['oe_score'] = $score;
		}
		return $this->db->from('order_evaluate')->where($where)->count_all_results();
	}

	public function get_list($me_id, $score, $page, $num_per_page){
		$where = " WHERE a.oe_meid=$me_id";
		if(!empty($score)){
			$where .= " AND a.oe_score=$score ";
		}
		$start = ($page-1)*$num_per_page;
		$sql = "SELECT a.oe_score, a.oe_quality, a.oe_attitude, a.oe_ontime, a.oe_content, a.oe_response, a.oe_type, a.oe_add_time, b.order_number, b.service_type, c.real_name, c.phone FROM order_evaluate a LEFT JOIN orders b ON a.oe_orderid=b.id LEFT JOIN master c ON b.master_id=c.id {$where} ORDER BY a.oe_id DESC LIMIT $start, $num_per_page";
		$result = $this->db->query($sql)->result_array();

		$service_type = config_item('service_type');
		$icon_arr = array(
			1 => asset('images/4159.png'),
			2 => asset('images/33.png'),
			3 => asset('images/250.png')
			);
		foreach ($result as $key => $val) {
			$result[$key]['oe_add_time'] = date('Y-m-d H:i', $val['oe_add_time']);
			$result[$key]['service_type'] = isset($service_type[$val['service_type']]) ? $service_type[$val['service_type']] : '';
			$result[$key]['icon'] = isset($icon_arr[$val['oe_score']]) ? $icon_arr[$val['oe_score']] : $icon_arr[1];
			$result[$key]['oe_score_text'] = $val['oe_score']==3 ? '差评' : ($val['oe_score']==2 ? '中评' : '好评');
		}
		return $result;
	}

	//默认为人工评价 type=0
	public function add_record($me_id, $post, $order_id, $type=0){
		@extract($post);
		$score = in_array($score, array(1,2,3)) ? intval($score) : 1;
		$quality = in_array($quality, array(1,2,3,4,5)) ? intval($quality) : 5;
		$attitude = in_array($attitude, array(1,2,3,4,5)) ? intval($attitude) : 5;
		$ontime = in_array($ontime, array(1,2,3,4,5)) ? intval($ontime) : 5;

		$final_result = false;
		$time = time();
		$insert_sql = "INSERT INTO order_evaluate SET oe_orderid=$order_id, oe_score=$score, oe_quality=$quality, oe_attitude=$attitude, oe_ontime=$ontime, oe_meid=$me_id, oe_content='{$content}', oe_add_time=$time, oe_type=$type";
		$update_status_sql = "UPDATE orders_status SET evaluate_status=1, upd_time=$time WHERE order_id=$order_id";
		$update_num_sql = "UPDATE merchant_order_num SET wait_evaluate=wait_evaluate-1 WHERE me_id=$me_id AND order_type=1";

		$this->db->trans_begin();
		$this->db->query($insert_sql);
		$evaluate_id = $this->db->insert_id();
		$this->db->query($update_status_sql);
		$this->db->query($update_num_sql);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result ? $evaluate_id : false;
	}

	public function is_record_exist($order_id){
		$where = array('oe_orderid' => $order_id);
		$result = $this->db->where($where)->get('order_evaluate')->row_array();
		return empty($result) ? false : true;
	}

}