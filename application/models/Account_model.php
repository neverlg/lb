<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 模型示例
 *
 * 这里继承了扩展后的核心模型基类
 */
class Account_model extends MY_Model {
	public function __construct(){
		$this->load->database();
	}

	//后台首页用户信息
	public function get_homepage_user($me_id){
		$where = array('me_id' => $me_id);
		$this->db->select('me_username, me_points, me_money, me_category, me_headimg')->from('merchant')->where($where);
		return $this->db->get()->row_array();
	}

	//后台首页用户上次登录时间
	public function get_last_login($me_id){
		$where = array('mll_me_id' => $me_id);
		$result = $this->db->select('mll_login_time')->where($where)->order_by('mll_id','DESC')->limit(2)->get('merchant_login_log')->result_array();
		if(count($result) == 2){
			return $result[1]['mll_login_time'];
		}
		return '';
	}

	public function get_user_info($me_id){
		$where = array('me_id' => $me_id);
		$this->db->select('me_username, me_category, me_truename, me_phone, me_local_area, me_local_address, me_phoneps, me_qq, me_headimg, me_jd_name, me_jd_url, me_tb_name, me_tb_url')->from('merchant')->where($where);
		return $this->db->get()->row_array();
	}

	public function update_info($me_id, $post){
		@extract($post);
		$where = array('me_id' => $me_id);
		$data = array(
			'me_truename' => $truename,
			'me_phoneps' => $phoneps,
			'me_qq' => $qq,
			'me_jd_name' => $jd_name,
			'me_jd_url' => $jd_url,
			'me_local_area' => $province .','. $city .','. $district,
			'me_local_address' => $detail_address,
			'me_tb_name' => $tb_name,
			'me_tb_url' => $tb_url,
			'me_update_time' => time()
			);
		$this->db->update('merchant',$data,$where);
		return $this->db->affected_rows();
	}

	public function update_avatar($me_id, $url){
		$where = array('me_id' => $me_id);
		$data = array(
			'me_headimg' => $url,
			'me_update_time' => time()
			);
		$this->db->update('merchant',$data,$where);
		return $this->db->affected_rows();
	}

	public function update_phone($me_id, $phone){
		$data = array(
			'me_phone' => $phone,
			'me_update_time' => time()
			);
		$where = array('me_id' => $me_id);
		$this->db->update('merchant',$data,$where);
		return $this->db->affected_rows();
	}

	public function check_password($me_id, $password){
		$this->db->select('me_pass')->from('merchant')->where(array('me_id'=>$me_id));
		$result = $this->db->get()->result_array();
		if(count($result)==1 && $result[0]['me_pass']==md5($password)){
			return true;
		}
		return false;
	}

	public function update_password($me_id, $password){
		$data = array(
			'me_pass' => md5($password),
			'me_update_time' => time()
			);
		$where = array('me_id' => $me_id);
		$this->db->update('merchant',$data,$where);
		return $this->db->affected_rows();
	}

	public function is_merchant_existed($phone, $name=''){
		$where = array('me_phone'=>$phone);
		if(!empty($name)){
			$or_where = array('me_username'=>$name);
			$num = $this->db->from('merchant')->where($where)->or_where($or_where)->count_all_results();
		}else{
			$num = $this->db->from('merchant')->where($where)->count_all_results();
		}
		return ($num>0) ? true : false;
	}
}