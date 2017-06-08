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

	//获取师傅头像及姓名
	public function get_master_service_info($master_id){
		$sql = "SELECT a.real_name, a.head_img, b.extra_tmall_examine, b.extra_storage, b.extra_move_free, b.extra_finish_in, b.extra_nothing_fee, b.extra_repair_free, b.extra_floor_free, b.extra_carry_fee, b.extra_far_fee FROM master a LEFT JOIN master_detail b ON a.id=b.master_id WHERE a.id=$master_id";
		$result = $this->db->query($sql)->row_array();
		if(empty($result['head_img'])){
			$result['head_img'] = asset("images/default_head.png");
		}else if(stripos($result['head_img'], 'http') === FALSE){
			$qiniu = config_item('qiniu');
			$result['head_img'] = $qiniu['source_url'].$result['head_img'];
		}
		return $result;
	}

	//获取师傅基本信息
	public function get_master_info($master_id){
		$sql = "SELECT a.*, b.deliver_address, b.member_num, b.car_num, b.job_type, b.service_period, b.deliver_address FROM master a LEFT JOIN master_detail b ON a.id=b.master_id WHERE a.id=$master_id AND a.status=1";
		$result = $this->db->query($sql)->row_array();
		//format data
		if(empty($result['head_img'])){
			$result['head_img'] = asset("images/default_head.png");
		}else if(stripos($result['head_img'], 'http') === FALSE){
			$qiniu = config_item('qiniu');
			$result['head_img'] = $qiniu['source_url'].$result['head_img'];
		}
		$services = array(
			1 => '配送',
			2 => '安装',
			3 => '维修',
			4 => '搬运'
			);
		$result['service_type'] = explode(',', $result['service_type']);
		foreach ($result['service_type'] as $key => $val) {
			$result['service_type'][$key] = isset($services[$val]) ? $services[$val] : '';
		}
		//貌似只有家具类
		$result['service_category'] = '家具类';
		$result['service_area_txt'] =  empty($result['service_area_ids']) ? '' : $this->get_name_by_areaid($result['service_area_ids']);
		$result['job_type'] = ($result['job_type']==1) ? '全职' : '兼职';
		$result['member_num'] = empty($result['member_num']) ? '- -' : $result['member_num'];
		$result['car_num'] = empty($result['car_num']) ? '- -' : $result['car_num'];
		//服务时间
		$service_time = json_decode($result['service_period'], true);
		$result['service_time_txt'] = (empty($service_time)) ? '暂无' : '周'.$service_time['week_start'].'至周'.$service_time['week_end'].'  '.'上午'.$service_time['time_start'].':00至'.$service_time['time_end'].':00';
		return $result;
	}

	//获取师傅的统计信息
	public function get_master_statistic($master_id){
		$sql = "SELECT points, order_count, score_count, score_sum, evaluate_count, evaluate_praise_count, complain_count, assure_fund FROM master_statistic a LEFT JOIN master_wallet b ON a.master_id=b.master_id WHERE a.master_id=$master_id";

		$result = $this->db->query($sql)->row_array();
		if(empty($result)){
			return false;
		}
		$result['__score_icon'] = create_master_level_icon($result['points']);
		if(!empty($result['evaluate_count'])){
			$result['good_rat'] = round($result['evaluate_praise_count']/$result['evaluate_count'] ,2).'%';
		}else{
			$result['good_rat'] = '- -';
		}
		if(!empty($result['score_count'])){
			$result['score_sum'] = round($result['score_sum']/$result['score_count'] ,2);
		}else{
			$result['score_sum'] = '- -';
		}
		return $result;
	}

	//根据服务区域id获取名称
	public function get_name_by_areaid($area_str){
		$sql = "SELECT name, parentid FROM province WHERE id IN ({$area_str})";
		$result = $this->db->query($sql)->result_array();
		$district = array();
		foreach ($result as $val) {
			$district[] = $val['name'];
		}
		$district = implode(',', $district);
		//取其中的一个parentid，取出城市name
		$city_id = $result[0]['parentid'];
		$sql = "SELECT name FROM province WHERE id=$city_id";
		$ret = $this->db->query($sql)->row_array();
		$city_name = $ret['name'];
		return $city_name.'('.$district.')';
	}

    //师傅收到的评价总数
    public function get_pingjia_search_num($master_id, $post){
        @extract($post);
        $ptype = intval($ptype);

        $where = " WHERE a.master_id=$master_id ";
        $sql = '';
        if(!empty($ptype) && $ptype > 0){
            $where .= " AND b.oe_score=$ptype";
        }

        $sql = "SELECT COUNT(*) as num FROM order_evaluate b LEFT JOIN orders a ON a.id=b.oe_orderid {$where}";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    //师傅收到的评价
    public function get_pingjia_search_item($master_id, $post, $page, $num_per_page){
        @extract($post);
        $ptype = intval($ptype);
        $start = ($page-1)*$num_per_page;

        $where = " WHERE a.master_id=$master_id ";
        $sql = '';
        if(!empty($ptype) && $ptype > 0){
            $where .= " AND b.oe_score=$ptype";
        }

        $sql = "SELECT b.*,c.me_username FROM order_evaluate b LEFT JOIN orders a ON a.id=b.oe_orderid LEFT JOIN merchant c ON c.me_id=b.oe_meid {$where} ORDER BY b.oe_add_time DESC LIMIT $start, $num_per_page";
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

}