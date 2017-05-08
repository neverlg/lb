<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Order_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	public function get_order_by_oid($me_id, $order_id){
		$sql = "SELECT a.order_number, a.service_type, a.merchant_price, b.real_name, b.phone FROM orders a LEFT JOIN master b ON a.master_id=b.id WHERE a.id=$order_id AND a.merchant_id=$me_id LIMIT 1";
		$result = $this->db->query($sql)->row_array();
		return $result;
	}

	public function get_refund_order($me_id, $order_id){
		$where = array(
			'merchant_id' => $me_id,
			'id' => $order_id
			);
		$result = $this->db->select('order_number,merchant_price,pay_type')->where($where)->get('orders')->row_array();

		$paytype_conf = config_item('pay_type');
		$result['pay_type'] = $paytype_conf[$result['pay_type']];
		return $result;
	}

	public function get_complain_order($me_id, $order_id){
		$sql = "SELECT a.order_number, a.merchant_price, a.master_name, b.phone FROM orders a LEFT JOIN master b ON a.master_id=b.id WHERE a.id=$order_id AND a.merchant_id=$me_id";
		$result = $this->db->query($sql)->row_array();
		return $result;
	}

	public function get_evaluate_order($me_id, $order_id){
		$sql = "SELECT a.order_number, a.service_type, a.master_name, b.phone FROM orders a LEFT JOIN master b ON a.master_id=b.id WHERE a.id=$order_id AND a.merchant_id=$me_id";
		$result = $this->db->query($sql)->row_array();

		$service_type = config_item('service_type');
		$result['service_type'] = isset($service_type[$result['service_type']]) ? $service_type[$result['service_type']] : '';
		return $result;
	}

	//检测用户与订单是否匹配
	public function check_power($me_id, $order_id){
		$where = array(
			'id' => $order_id,
			'merchant_id' => $me_id
			);
		$num = $this->db->from('orders')->where($where)->count_all_results();
		return ($num>0) ? true : false;
	}

	//获取不同种类订单的各种状态的数目（后台首页）
	public function get_distinct_order_num($me_id, $priced_type=0){
		$where = array('me_id' => $me_id);
		if(!empty($priced_type)){
			$where['order_type'] = $priced_type;
			return $this->db->where($where)->get('merchant_order_num')->row_array();

		}else{
			$result = $this->db->where($where)->get('merchant_order_num')->result_array();
			return array_column($result, null, 'order_type');
		}	
	}

	//获取用户的订单总数
	public function get_order_num($me_id, $priced_type){
		$where = array(
			'merchant_id' => $me_id,
			'order_type' => $priced_type
			);
		return $this->db->from('orders')->where($where)->count_all_results();
	}

	//查找服务完成之后，15天之内都没有回复的所有订单
	public function get_orders_without_evaluate($expire){
		$deadline = time()-$expire;
		$sql = "SELECT a.id, a.merchant_id FROM orders a LEFT JOIN orders_status b ON a.id=b.order_id WHERE b.finish_time<$deadline AND b.evaluate_status=0";
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	//用于报价订单的首页搜索记录数目
	public function get_baojia_search_num($me_id, $post){
		@extract($post); //'kehu','order_sn','logistics_no','ptype'
		$ptype = intval($ptype);
		$kehu = trim($kehu);
		$order_sn = trim($order_sn);
		$logistics_no = trim($logistics_no);

		$where = " WHERE a.merchant_id=$me_id ";
		$sql = '';
		if(in_array($ptype, array(1,2,3,4,5,6,7))){
			$where .= " AND b.merchant_status=$ptype ";
		}else if($ptype==8){
			$where .= " AND b.refund_status=1 "; 
		}else if($ptype==9){
			$where .= " AND b.arbitrate_status=1 "; 
		}else if($ptype==10){
			$where .= " AND b.except_status=1 "; 
		}else if($ptype==11){
			$where .= " AND b.merchant_status=7 AND b.evaluate_status=0 ";
		}else if($ptype==12){
			$where .= " AND b.complain_status=1 ";
		}
		if(!empty($order_sn)){
			$where .= " AND a.order_number='{$order_sn}' ";
		}
		if(!empty($kehu)){
			$where .= " AND (c.customer_name='{$kehu}' OR c.customer_phone='{$kehu}') ";
		}
		if(!empty($logistics_no)){
			$where .= " AND c.logistics_ticketnumber='{$logistics_no}'";
		}

		if(empty($kehu) && empty($logistics_no)){
			$sql = "SELECT COUNT(*) as num FROM orders a LEFT JOIN orders_status b ON a.id=b.order_id {$where}";
		}else if(empty($ptype)){
			$sql = "SELECT COUNT(*) as num FROM orders a LEFT JOIN orders_detail c ON a.id=c.order_id {$where}";
		}else{
			$sql = "SELECT COUNT(*) as num FROM orders a LEFT JOIN orders_status b ON a.id=b.order_id LEFT JOIN orders_detail c ON a.id=c.order_id {$where}";
		}
		$result = $this->db->query($sql)->row_array();
		return $result['num'];
	}

	//用于报价订单的首页搜索记录详情
	public function get_baojia_search_item($me_id, $post, $page, $num_per_page){
		@extract($post); //'kehu','order_sn','logistics_no','ptype'
		$ptype = intval($ptype);
		$kehu = trim($kehu);
		$order_sn = trim($order_sn);
		$logistics_no = trim($logistics_no);
		$start = ($page-1)*$num_per_page;

		$where = " WHERE a.merchant_id=$me_id ";
		$sql = '';
		if(in_array($ptype, array(1,2,3,4,5,6,7))){
			$where .= " AND b.merchant_status=$ptype ";
		}else if($ptype==8){
			$where .= " AND b.refund_status=1 "; 
		}else if($ptype==9){
			$where .= " AND b.arbitrate_status=1 "; 
		}else if($ptype==10){
			$where .= " AND b.except_status=1 "; 
		}else if($ptype==11){
			$where .= " AND b.merchant_status=7 AND b.evaluate_status=0 ";
		}else if($ptype==12){
			$where .= " AND b.complain_status=1 ";
		}
		if(!empty($order_sn)){
			$where .= " AND a.order_number='{$order_sn}' ";
		}
		if(!empty($kehu)){
			$where .= " AND (c.customer_name='{$kehu}' OR c.customer_phone='{$kehu}') ";
		}
		if(!empty($logistics_no)){
			$where .= " AND c.logistics_ticketnumber='{$logistics_no}'";
		}

		$sql = "SELECT a.id, a.order_number, a.service_type, a.add_time, a.merchant_price, b.merchant_status, b.except_status, b.refund_status, b.arbitrate_status, b.evaluate_status, c.customer_address, c.customer_name, c.customer_phone, c.merchant_remark FROM orders a LEFT JOIN orders_status b ON a.id=b.order_id LEFT JOIN orders_detail c ON a.id=c.order_id {$where}";
		$result = $this->db->query($sql)->result_array();

		$service_type = config_item('service_type');
		foreach ($result as $key => $val){
			$result[$key]['add_time'] = date('Y-m-d H:i', $val['add_time']);
			$result[$key]['service_type'] = isset($service_type[$val['service_type']]) ? $service_type[$val['service_type']] : '';
			$result[$key]['master_num'] = $this->get_master_num($val['id']);
		}
		return $result;
	}

	public function get_master_num($order_id){
		$where = array('order_id' => $order_id);
		return $this->db->from('orders_offer')->where($where)->count_all_results();
	}

	//获取报价订单详情
	public function get_baojia_detail($me_id, $order_id){
		$result = array();
		$sql = "SELECT a.id, a.order_number, a.service_type, a.merchant_price, a.add_time as xiadan_time, b.merchant_status, b.except_status, b.refund_status, b.arbitrate_status, b.evaluate_status, b.logistics_status, b.finish_time, c.* FROM orders a LEFT JOIN orders_status b ON a.id=b.order_id LEFT JOIN orders_detail c ON a.id=c.order_id WHERE a.id=$order_id AND a.merchant_id=$me_id";
		$result1 = $this->db->query($sql)->row_array();

		//整理数据
		$merchant_status = config_item('baojia_merchant_order_status');
		$result1['merchant_status_txt'] = isset($merchant_status[$result1['merchant_status']]) ? $merchant_status[$result1['merchant_status']] : '';
		$result1['xidan_time_txt'] = date('Y-m-d H:i', $result1['xiadan_time']);
		$service_type = config_item('service_type');
		$local_service_type = $result1['service_type'];
		$result1['service_type_txt'] = isset($service_type[$result1['service_type']]) ? $service_type[$result1['service_type']] : '';
		$result1['customer_elevator'] = ($result1['customer_elevator']==1) ? '电梯' : '步梯';
		$result1['customer_tmall_number'] = empty($result1['customer_tmall_number']) ? "否" : "需要天猫师傅核销  ".$result1['customer_tmall_number'];
		$result1['logistics_status_txt'] = ($result1['logistics_status']==2) ? '已到货' : '未到货';
		$result1['logistics_ticketnumber'] = empty($result1['logistics_ticketnumber']) ? '- -' : $result1['logistics_ticketnumber'];
		$result1['logistics_packages'] = empty($result1['logistics_packages']) ? '- -' : $result1['logistics_packages'];
		$result1['logistics_name'] = empty($result1['logistics_name']) ? '- -' : $result1['logistics_name'];
		$result1['logistics_phone'] = empty($result1['logistics_phone']) ? '- -' : $result1['logistics_phone'];
		$result1['logistics_address'] = empty($result1['logistics_address']) ? '- -' : $result1['logistics_address'];
		$result1['logistics_mark'] = empty($result1['logistics_mark']) ? '- -' : $result1['logistics_mark'];
		$result1['merchant_finish_time'] = empty($result1['merchant_finish_time']) ? '' : '希望师傅在'.date('Y-m-d H:i', $result1['merchant_finish_time']).'前完成任务。';
		if(empty($result1['customer_memark'])){
			if(empty($result1['merchant_finish_time'])){
				$result1['customer_memark'] = '- -';
			}else{
				$result1['customer_memark'] = $result1['merchant_finish_time'];
			}
		}else{
			$result1['customer_memark'] .= '。'.$result1['merchant_finish_time'];
		}

		$result2 = array();
		$result3 = array();
		//此处判断，防止越权
		if(!empty($result1)){
			$sql = "SELECT goods_type, goods_name, goods_mark, goods_num, goods_img FROM orders_goods WHERE order_id=$order_id";
			$result2 = $this->db->query($sql)->result_array();
			$goods_type = config_item('goods');
			$qiniu = config_item('qiniu');
			foreach ($result2 as $key => $val) {
				$result2[$key]['goods_type'] = isset($goods_type[$val['goods_type']]) ? $goods_type[$val['goods_type']] : '其他';
				$result2[$key]['goods_mark'] = empty($val['goods_mark']) ? '- -' : $val['goods_mark'];
				//当服务类型是维修时，goods_img字段是用逗号隔开的几个图片
				if($local_service_type == 3){
					$img_arr = explode(',', $val['goods_img']);
					foreach ($img_arr as $k => $v) {
						$img_arr[$k] = $qiniu['source_url'].$v;
					}
					$result2[$key]['goods_img'] = $img_arr;
				}else{
					$result2[$key]['goods_img'] = $qiniu['source_url'].$val['goods_img'];
				}
			}

			//获取师傅信息
			if($result1['merchant_status'] > 2){
				$sql = "SELECT a.master_name, b.phone FROM orders a LEFT JOIN master b ON a.master_id=b.id WHERE a.id=$order_id AND a.merchant_id=$me_id";
				$result3 = $this->db->query($sql)->row_array();
			}
		}
		$result['order'] = $result1;
		$result['goods'] = $result2;
		$result['master'] = $result3;
		$result['master_num'] = $this->get_master_num($order_id);
		return $result;
	}

	//取消报价订单
	public function del_baojia_order($me_id, $order_id, $from){
		$final_result = false;
		$time = time();
		if($this->check_power($me_id, $order_id)){
			$sql1 = "UPDATE orders_status SET except_status=1, upd_time=$time WHERE order_id=$order_id";
			$sql2 = "UPDATE merchant_order_num SET {$from}={$from}-1 WHERE me_id=$me_id AND order_type=1";

			$this->db->trans_begin();
			$this->db->query($sql1);
			$this->db->query($sql2);
			if ($this->db->trans_status() === FALSE){
	    		$this->db->trans_rollback();
			}else{
	    		$this->db->trans_commit();
	    		$final_result = true;
			}
		}
		return $final_result;
	}

	//获取服务节点
	public function get_baojia_trace($order_id){
		$sql ="SELECT merchant_status, master_status, except_status, refund_status, arbitrate_status, evaluate_status, door_time, deliver_imgs, deliver_except, finish_imgs, finish_ticket_img, finish_message, finish_time, appoint_time, deliver_time FROM orders_status WHERE order_id=$order_id";
		$result = $this->db->query($sql)->row_array();

		$week_arr = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
		$week = empty($result['door_time']) ? 0 : date('w', $result['door_time']);
		$door_time = empty($result['door_time']) ? 0 : date('m月d日,H:i', $result['door_time']);
		$door_time_arr = explode(',', $door_time);
		$result['door_time'] = $door_time_arr[0].'（'.$week_arr[$week].'）'.$door_time_arr[1];

		$result['finish_time_txt'] = empty($result['finish_time']) ? 0 : date('Y-m-d H:i', $result['finish_time']);
		$result['appoint_time'] = empty($result['appoint_time']) ? 0 : date('Y-m-d H:i', $result['appoint_time']);
		$result['deliver_time'] = empty($result['deliver_time']) ? 0 : date('Y-m-d H:i', $result['deliver_time']);
		$result['deliver_imgs'] = json_decode($result['deliver_imgs'], true);
		$result['finish_imgs'] = json_decode($result['finish_imgs'], true);
		$result['finish_ticket_img'] = json_decode($result['finish_ticket_img'], true);
		$qiniu = config_item('qiniu');
		foreach ($result['deliver_imgs'] as $key => $val) {
			$result['deliver_imgs'][$key] = $qiniu['source_url'].$val;
		}
		foreach ($result['finish_imgs'] as $key => &$val) {
			$result['finish_imgs'][$key] = $qiniu['source_url'].$val;
		}
		foreach ($result['finish_ticket_img'] as $key => &$val) {
			$result['finish_ticket_img'][$key] = $qiniu['source_url'].$val;
		}
		
		return $result;
	}

	//获取订单状态
	public function get_order_status($order_id){
		$sql ="SELECT merchant_status, master_status, except_status, refund_status, arbitrate_status, evaluate_status, finish_time FROM orders_status WHERE order_id=$order_id";
		$result = $this->db->query($sql)->row_array();
		return $result;
	}

	//查看师傅报价
	public function get_master_offer($order_id){
		$sql = "SELECT a.price, a.status, b.phone, b.real_name, b.head_img, b.id FROM orders_offer a LEFT JOIN master b ON a.master_id=b.id WHERE a.order_id=$order_id";
		$base = $this->db->query($sql)->result_array();
		//基本信息，key为master_id
		$base = array_column($base, null, 'id');
		$qiniu = config_item('qiniu');
		foreach ($base as $key => $val) {
			$base[$key]['head_img'] = $qiniu['source_url'].$val['head_img'];
			//商家展示价格是师傅的1.1倍
			$base[$key]['price'] = $val['price']*1.1;
		}

		$master_str = implode(',',array_keys($base));

		//统计信息
		$sql = "SELECT * FROM master_statistic WHERE master_id in ({$master_str})";
		$statistic = $this->db->query($sql)->result_array();
		$statistic = array_column($statistic, null, 'master_id');
		foreach ($statistic as $key => $val) {
			$statistic[$key]['good_rat'] = round($val['evaluate_praise_count']/$val['evaluate_count'] ,2).'%';
			$statistic[$key]['__score_icon'] = create_master_level_icon($val['points']);
		}

		//保证金
		$sql = "SELECT master_id, assure_fund FROM master_wallet WHERE master_id in ({$master_str})";
		$fund = $this->db->query($sql)->result_array();
		$fund = array_column($fund, null, 'master_id');

		$result = array(
			'base' => $base,
			'statistic' => $statistic,
			'fund' => $fund
			);

		return $result;
	}

	//解除师傅雇佣
	public function unhire_master($order_id, $hired_id){
		$where = array(
			'order_id' => $order_id,
			'master_id' => $hired_id
			);
		$data = array(
			'status' => 0
			);
		$this->db->update('orders_offer', $data, $where);
	}

	//雇佣师傅
	public function hire_master($me_id, $order_id, $master_id, $hired_id){
		//查询订单入选报价金额，放在最开始，避免伪造
		$ret = $this->db->query("SELECT a.price, b.real_name FROM orders_offer a LEFT JOIN master b ON a.master_id=b.id WHERE a.order_id=$order_id AND a.master_id=$master_id")->row_array();
		if(empty($ret)){
			return false;
		}
		$master_price = $ret['price'];
		$master_name = $ret['real_name'];
		$merchant_price = $master_price*1.1;
		$time = time();
		$final_result  = false;

		$this->db->trans_begin();
		$sql1 = "UPDATE orders_offer SET status=1, upd_time=$time WHERE order_id=$order_id AND master_id=$master_id";
		$sql2 = "UPDATE merchant_order_num SET wait_hired=wait_hired-1, wait_pay=wait_pay+1 WHERE me_id=$me_id AND order_type=1";
		$sql3 = "UPDATE orders_status SET merchant_status=3, upd_time=$time WHERE order_id=$order_id";

		//如果是首次雇佣，而不是替换师傅，需要更改统计
		if(empty($hired_id)){
			$this->db->query($sql2);
			//更改订单状态
			$this->db->query($sql3);
		}
		//不是第一次雇佣，将原师傅取消，不放在else里，确保只有一个师傅成功雇佣
		$this->db->query("UPDATE orders_offer SET status=0, upd_time=$time WHERE order_id=$order_id AND status=1");

		$this->db->query($sql1);
		//更新orders表的价格
		$this->db->query("UPDATE orders SET master_id=$master_id, merchant_price=$merchant_price, offer_price=$master_price, master_name='{$master_name}', upd_time=$time WHERE id=$order_id");
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	//创建订单支付页面 订单信息
	public function get_order_for_pay($order_id){
		$sql = "SELECT a.id, a.merchant_id, a.order_number, a.service_type, a.merchant_price, a.master_id, b.customer_name, b.customer_phone, b.customer_address FROM orders a LEFT JOIN orders_detail b ON a.id=b.order_id WHERE a.id=$order_id";
		$result = $this->db->query($sql)->row_array();

		$service_type = config_item('service_type');
		$result['service_type'] = isset($service_type[$result['service_type']]) ? $service_type[$result['service_type']] : '- -';
		return $result;
	}

	//创建订单支付页面 师傅信息
	public function get_master_for_pay($master_id){
		$sql = "SELECT a.real_name, a.phone, b.assure_fund FROM master a LEFT JOIN master_wallet b ON a.id=b.master_id WHERE a.id=$master_id";
		return $this->db->query($sql)->row_array();
	}

	//查询总价
	public function get_total_fee($me_id, $order_id){
		$sql = "SELECT merchant_price, order_number, service_type, master_name, add_time FROM orders WHERE id=$order_id AND merchant_id=$me_id";
		$ret = $this->db->query($sql)->row_array();
		return $ret;
	}

	//产生订单
	public function create_order($me_id, $type, $order_no, $post){
		@extract($post);
		$time = time();
		$ip = $this->input->ip_address();
		$final_result = false;

		$this->db->trans_begin();
		//如果非维修订单，将上传的货品加入仓库
		if(in_array($type, array(1,2,4))){
			$insert_value = '';
			//没有goods_id的，即为上传
			foreach($goods_id as $key => $val){
				if($val == 0){
					$insert_value .= "(null,'{$goods_name[$key]}','{$goods_img[$key]}','0.00',{$me_id},0,{$goods_type[$key]},{$time},'{$ip}','',1,0),";
				}
			}
			if(!empty($insert_value)){
				$insert_value = rtrim($insert_value, ',');
				$this->db->query("INSERT INTO goods VALUES {$insert_value}");
			}
		}
		//生成orders记录
		$this->db->query("INSERT INTO orders SET order_number='{$order_no}',merchant_id={$me_id},service_category=1,service_type={$type},add_time={$time},order_type=1,push_time={$time}");
		$order_id = $this->db->insert_id();

		//货品加入orders_goods表
		if(in_array($type, array(1,2,4))){
			$insert_value = '';
			foreach($goods_id as $key => $val){
				$insert_value .= "(null,{$order_id},{$val},{$goods_type[$key]},'{$goods_name[$key]}','{$goods_remark[$key]}',{$goods_num[$key]},'{$goods_img[$key]}',0.00,{$time},0),";
			}
			$insert_value = rtrim($insert_value, ',');
		}else if($type==3){
			//目前维修只有一个货品，货品图片为逗号隔开的url
			$insert_value = '';
			foreach($goods_type as $key => $val){
				$insert_value .= "(null,{$order_id},0,{$goods_type[$key]},'','{$goods_remark[$key]}',0,'{$goods_img[$key]}',0.00,{$time},0),";
			}
			$insert_value = rtrim($insert_value, ',');
		}
		$this->db->query("INSERT INTO orders_goods VALUES {$insert_value}");

		//更新orders_detail
		$this->db->query("INSERT INTO orders_detail SET order_id={$order_id},customer_name='{$customer_name}',customer_phone='{$customer_phone}',customer_area_id={$district},customer_address='{$address}',customer_elevator={$elevater},customer_floor={$floor},customer_tmall_number='{$tmall_number}',customer_memark='{$customer_remark}',logistics_packages={$goodnum},logistics_ticketnumber='{$logistics_no}',logistics_name='{$logistics_name}',logistics_phone='{$logistics_phone}',logistics_address='{$logistics_address}',logistics_mark='{$logistics_remark}',merchant_name='{$me_name}',merchant_phone='{$me_phone}',merchant_finish_time='{$hope_finish_time}',add_time={$time}");
		//更新orders_status
		$this->db->query("INSERT INTO orders_status SET order_id={$order_id},merchant_status=1,logistics_status={$cargo_arrive},add_time={$time}");

		//更新merchant_trade_log
		$this->db->query("UPDATE merchant_order_num SET wait_priced=wait_priced+1 WHERE me_id={$me_id} AND order_type=1");

		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result ? $order_id : false;
	}

	public function check_confirmed($me_id, $order_id){
		$time = time();
		$final_result = false;
		$this->db->trans_begin();
		$this->db->query("UPDATE orders_status SET merchant_status=7, upd_time=$time WHERE order_id=$order_id");
		$this->db->query("UPDATE merchant_order_num SET wait_accept=wait_accept-1, wait_evaluate=wait_evaluate+1 WHERE me_id=$me_id");
		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function get_master_status($order_id){
		$where = array('order_id' => $order_id);
		$this->db->select('master_status')->from('orders_status')->where($where);
		$result = $this->db->get()->row_array();
		return $result['master_status'];
	}

	public function edit_baojia_order($order_id, $post){
		@extract($post);
		$time = time();
		$final_result = false;
		$this->db->trans_begin();
		$this->db->query("UPDATE orders_detail SET customer_name='{$customer_name}',customer_phone='{$customer_phone}',customer_address='{$address}',logistics_packages={$goodnum},logistics_ticketnumber='{$logistics_no}',logistics_name='{$logistics_name}',logistics_phone='{$logistics_phone}',logistics_address='{$logistics_address}',logistics_mark='{$logistics_remark}',merchant_name='{$me_name}',merchant_phone='{$me_phone}',upd_time={$time} WHERE order_id={$order_id}");
		$this->db->query("UPDATE orders_status SET logistics_status={$cargo_arrive},upd_time={$time} WHERE order_id={$order_id}");

		if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
		}else{
    		$this->db->trans_commit();
    		$final_result = true;
		}
		return $final_result;
	}

	public function add_baojia_mark($order_id, $mark){
		$where = array(
			'order_id' => $order_id
			);
		$data = array(
			'merchant_remark' => $mark,
			'upd_time' => time()
			);
		$this->db->update('orders_detail', $data, $where);
		return $this->db->affected_rows();
	}

}