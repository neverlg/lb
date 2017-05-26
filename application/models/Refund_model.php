<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Refund_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_refund_total($me_id, $order_type, $order_sn, $refund_status){
		$where = " WHERE b.merchant_id={$me_id} AND b.order_type={$order_type} ";
		if(!empty($order_sn)){
			$where .= " AND b.order_number='{$order_sn}'";
		}
		if(!empty($refund_status)){
			if($refund_status == 1){
				$where .= " AND a.refund_result_type=0 ";
			}else if($refund_status == 2){
				$where .= " AND a.refund_result_type=2 ";
			}else if($refund_status == 3){
				$where .= " AND a.refund_success_time>0 ";
			}else if($refund_status == 5){
				$where .= " AND a.arbitrate_time>0 ";
			}else if($refund_status == 6){
				$where .= " AND a.arbitrate_result_type=3 ";
			}
		}
		//此处只需要orders和orders_status联表即可
		$sql = "SELECT count(*) as num FROM orders_refund a LEFT JOIN orders b ON a.order_id=b.id {$where}";
		$result = $this->db->query($sql)->row_array();
		return $result['num'];
	}

	public function get_refund_list($me_id, $order_type, $order_sn, $refund_status, $page, $num_per_page){
		$where = " WHERE b.merchant_id={$me_id} AND b.order_type={$order_type} ";
		if(!empty($order_sn)){
			$where .= " AND b.order_number='{$order_sn}'";
		}
		if(!empty($refund_status)){
			if($refund_status == 1){
				$where .= " AND a.refund_result_type=0 ";
			}else if($refund_status == 2){
				$where .= " AND a.refund_result_type=2 ";
			}else if($refund_status == 3){
				$where .= " AND a.refund_success_time>0 ";
			}else if($refund_status == 5){
				$where .= " AND a.arbitrate_time>0 ";
			}else if($refund_status == 6){
				$where .= " AND a.arbitrate_result_type=3 ";
			}
		}
		$start = ($page-1)*$num_per_page;

		$sql = "SELECT a.order_id, a.refund_amount, a.refund_time, a.refund_result_type, a.arbitrate_time, a.arbitrate_result_type, a.refund_success_time, b.order_number, b.service_type, b.merchant_price, b.master_name FROM orders_refund a LEFT JOIN orders b ON a.order_id=b.id {$where} ORDER BY a.id DESC LIMIT $start, $num_per_page";
		$result = $this->db->query($sql)->result_array();

		$service_type_conf = config_item('service_type');
		//$refund_status_conf = config_item('refund_status');
		foreach ($result as $key => $val) {
			$result[$key]['refund_time'] = date('Y-m-d H:i', $val['refund_time']);
			if(empty($val['refund_success_time'])){
				$result[$key]['refund_amount'] = '- -';
			}
			$tmp_status = '';
			if($val['refund_result_type'] == 0){
				$tmp_status = '待师傅确认中';
			}else if($val['refund_result_type'] == 2){
				$tmp_status = '师傅拒绝退款';
			}
			if($val['arbitrate_time'] > 0){
				$tmp_status = '介入仲裁中';
			}
			if($val['arbitrate_result_type'] == 3){
				$tmp_status = '仲裁拒绝退款';
			}
			if($val['refund_success_time']>0){
				$tmp_status = '退款成功';
			}
			$result[$key]['refund_result_type'] = $tmp_status;
			$result[$key]['service_type'] = $service_type_conf[$val['service_type']];
		}
		return $result;
	}

	public function add_record($me_id, $order_id, $number, $post){
		@extract($post);
		$type = in_array($type, array(1,2)) ? intval($type) : 1;
		$method = in_array($method, array(1,2)) ? intval($method) : 1;
		$fee = number_format($fee, 2, '.', '');

		$final_result = false;
		$time = time();
		//此处需要插入refund表，更新status, num表
		$update_status_sql = "UPDATE orders_status SET refund_status=1, upd_time=$time WHERE order_id=$order_id";
		$update_num_sql = "UPDATE merchant_order_num SET under_refund=under_refund+1 WHERE me_id=$me_id AND order_type=1";

		$this->db->trans_begin();
		$insert_sql = "INSERT INTO orders_refund SET order_id=$order_id, refund_reason='{$reason}', refund_time=$time, refund_type=$type, refund_amount=$fee, add_time=$time, order_number='{$number}',refund_method=$method,refund_result_type=0";
		$this->db->query($insert_sql);
		$refund_id = $this->db->insert_id();
		$this->db->query($update_status_sql);
		$this->db->query($update_num_sql);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result ? $refund_id : false;
	}

	public function get_detail($order_id){
		$sql = "SELECT * FROM orders_refund WHERE order_id=$order_id";
		$result = $this->db->query($sql)->row_array();

		$refund_type_conf = config_item('refund_type');
		$refund_method_conf = config_item('refund_method');
		$result['refund_time_txt'] = date('Y-m-d H:i', $result['refund_time']);
		$result['refund_result_time'] = empty($result['refund_result_time']) ? '- -' : date('Y-m-d H:i', $result['refund_result_time']);
		$result['arbitrate_result_time'] = empty($result['arbitrate_result_time']) ? '- -' : date('Y-m-d H:i', $result['arbitrate_result_time']);
		$result['refund_type'] = $refund_type_conf[$result['refund_type']];
		$result['refund_method'] = $refund_method_conf[$result['refund_method']];

		return $result;
	}

	public function is_orderid_exist($order_id){
		$where = array(
			'order_id' => $order_id
			);
		return $this->db->from('orders_refund')->where($where)->count_all_results();
	}

	public function cancel_refund($me_id, $order_id){
		//此处需要更新orders_refund表和orders_status表
		$result = false;
		$time = time();
		$sql1 = "DELETE FROM orders_refund WHERE order_id=$order_id";
		$sql2 = "UPDATE orders_status SET refund_status=0, arbitrate_status=0, upd_time=$time WHERE order_id=$order_id";
		$sql3 = "UPDATE merchant_order_num SET under_refund=under_refund-1 WHERE me_id=$me_id AND order_type=1";

		$this->db->trans_begin();
		$this->db->query($sql1);
		$this->db->query($sql2);
		$this->db->query($sql3);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$result = true;
		}
		return $result;
	}

	public function update_record($me_id, $order_id, $post){
		@extract($post);
		$type = in_array($type, array(1,2)) ? intval($type) : 1;
		$method = in_array($method, array(1,2)) ? intval($method) : 1;
		$fee = number_format($fee, 2, '.', '');

		$final_result = false;
		$time = time();
		//此处需要插入refund表，更新status表
		$sql1 = "UPDATE orders_refund SET refund_reason='{$reason}', refund_time=$time, refund_type=$type, refund_amount=$fee, add_time=$time, refund_method=$method,refund_result_type=1 WHERE order_id=$order_id";
		$sql2 = "UPDATE orders_status SET refund_status=1, upd_time=$time WHERE order_id=$order_id";

		$this->db->trans_begin();
		$this->db->query($sql1);
		$this->db->query($sql2);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function add_arbitrate($me_id, $order_id, $post){
		@extract($post);
		$img = json_encode($img);

		$final_result = false;
		$time = time();
		$sql1 = "UPDATE orders_refund SET arbitrate_time=$time, arbitrate_name='{$name}', arbitrate_phone='{$phone}', arbitrate_reason='{$explain}', arbitrate_imgs='{$img}', upd_time=$time WHERE order_id=$order_id";
		$sql2 = "UPDATE orders_status SET arbitrate_status=1,upd_time=$time WHERE order_id=$order_id";
		$sql3 = "UPDATE merchant_order_num SET under_refund=under_refund-1, under_arbitrate=under_arbitrate+1 WHERE me_id=$me_id AND order_type=1";

		$this->db->trans_begin();
		$this->db->query($sql1);
		$this->db->query($sql2);
		$this->db->query($sql3);
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function get_refund_id($order_id){
		$where = array(
			'order_id' => $order_id
			);
		$result = $this->db->select('id')->from('orders_refund')->where($where)->get()->row_array();
		return $result['id'];
	}
}