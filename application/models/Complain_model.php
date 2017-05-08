<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Complain_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_total($me_id, $post){
		@extract($post);
		$where = " WHERE a.oc_meid=$me_id ";
		if(!empty($co_number)){
			$where .= " AND a.oc_number='$co_number'";
		}
		if(!empty($or_number)){
			$where .= " AND b.order_number='$or_number'";
		}
		if(!empty($handle_status)){
			$where .= " AND a.oc_handle_status=$handle_status";
		}

		$sql = "SELECT COUNT(*) as sum FROM order_complain a LEFT JOIN orders b ON a.oc_orderid=b.id {$where}";
		$result = $this->db->query($sql)->row_array();
		return $result['sum'];
	}

	public function get_list($me_id, $post, $page, $num_per_page){
		@extract($post);
		$where = " WHERE a.oc_meid=$me_id ";
		if(!empty($co_number)){
			$where .= " AND a.oc_number='$co_number'";
		}
		if(!empty($or_number)){
			$where .= " AND b.order_number='$or_number'";
		}
		if(!empty($handle_status)){
			$where .= " AND a.oc_handle_status=$handle_status";
		}
		$where = empty($where) ? '' : ltrim($where, ' AND');

		$start = ($page-1)*$num_per_page;
		$sql = "SELECT a.oc_id, a.oc_orderid, a.oc_add_time, a.oc_number, a.oc_handle_status, b.order_number, b.service_type, b.merchant_price, b.master_name FROM order_complain a LEFT JOIN orders b ON a.oc_orderid=b.id {$where} ORDER BY a.oc_id DESC LIMIT $start, $num_per_page";
		$result = $this->db->query($sql)->result_array();

		$handle_result = config_item('complain_result');
		$service_type = config_item('service_type');
		foreach ($result as $key => $val) {
			$result[$key]['oc_add_time'] = date('Y-m-d H:i', $val['oc_add_time']);
			$result[$key]['oc_handle_status_txt'] = isset($handle_result[$val['oc_handle_status']]) ? $handle_result[$val['oc_handle_status']] : '';
			$result[$key]['service_type'] = isset($service_type[$val['service_type']]) ? $service_type[$val['service_type']] : '';
		}
		return $result;
	}

	public function get_detail($me_id, $order_id){
		$where = array(
			'oc_meid' => $me_id,
			'oc_orderid' => $order_id
			);
		$result = $this->db->where($where)->get('order_complain')->row_array();

		$handle_result = config_item('complain_result');
		$qiniu = config_item('qiniu');
		$category = config_item('complain_category');
		$result['oc_add_time'] = date('Y-m-d H:i', $result['oc_add_time']);
		$result['oc_img'] = empty($result['oc_img']) ? array() : json_decode($result['oc_img'], true);
		foreach ($result['oc_img'] as $key => $val) {
			$result['oc_img'][$key] = $qiniu['source_url'] . $val;
		}
		$result['oc_handle_status_txt'] = isset($handle_result[$result['oc_handle_status']]) ? $handle_result[$result['oc_handle_status']] : '';
		$result['oc_handle_result'] = empty($result['oc_handle_result']) ? '- -' : ($result['oc_handle_result']==1 ? '投诉成立' : '投诉失败');
		$result['oc_handle_time'] = empty($result['oc_handle_time']) ? '- -' : date('Y-m-d H:i', $result['oc_handle_time']);
		$result['oc_handle_explain'] = empty($result['oc_handle_explain']) ? '- -' : $result['oc_handle_explain'];
		$result['oc_category_txt'] = empty($result['oc_category']) ? '' : ($result['oc_category']==1 ? '师傅服务不诚信' : '师傅服务不规范');
		$result['oc_subcategory_txt'] = isset($category[$result['oc_category']][$result['oc_subcategory']]) ? $category[$result['oc_category']][$result['oc_subcategory']] : '';
		return $result;
	}

	public function add_record($me_id, $post, $order_id, $number){
		@extract($post);
		$category = intval($category);
		$subcategory = intval($subcategory);
		$img = json_encode($img);
		$time = time();
		$final_result = false;
		$sql1 = "INSERT INTO order_complain SET oc_orderid=$order_id, oc_meid=$me_id, oc_category=$category, oc_subcategory=$subcategory, oc_content='{$content}', oc_img='{$img}', oc_add_time=$time, oc_number='{$number}', oc_handle_status=1";
		$sql2 = "UPDATE merchant_order_num SET under_complain=under_complain+1 WHERE me_id=$me_id AND order_type=1";
		$sql3 = "SELECT master_id FROM orders WHERE id=$order_id";
		
		$this->db->trans_begin();
		$this->db->query($sql1);
		$complain_id = $this->db->insert_id();
		$this->db->query($sql2);
		$result = $this->db->query($sql3)->row_array();
		$master_id = $result['master_id'];
		$this->db->query("UPDATE master_statistic SET complain_count=complain_count+1 WHERE master_id=$master_id");
		$this->db->query("UPDATE orders_status SET complain_status=1, upd_time={$time} WHERE order_id=$order_id");
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result ? $complain_id : false;
	}

	public function cancel_item($order_id, $me_id){
		$sql1 = "UPDATE order_complain SET oc_handle_status=2 WHERE oc_orderid=$order_id AND oc_meid=$me_id";
		$sql2 = "UPDATE merchant_order_num SET under_complain=under_complain-1 WHERE me_id=$me_id AND order_type=1";
		$sql3 = "SELECT master_id FROM orders WHERE id=$order_id";
		$final_result = false;
		
		$this->db->trans_begin();
		$this->db->query($sql1);
		$this->db->query($sql2);
		$result = $this->db->query($sql3)->row_array();
		$master_id = $result['master_id'];
		$this->db->query("UPDATE master_statistic SET complain_count=complain_count-1 WHERE master_id=$master_id");
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function is_record_exist($order_id){
		$where = array('oc_orderid' => $order_id);
		$result = $this->db->where($where)->get('order_complain')->row_array();
		return empty($result) ? false : true;
	}

}