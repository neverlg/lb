<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 命令行任务处理（先不用消息队列）
*/

class Task extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('master_model');
	}

	//搜索符合条件的师傅，并发送消息(前期暂不按照service_type来推送)
	public function push_master($data){
		if (!is_cli()) {
			echo '非cli模式，不可访问！';
			return false;
		}
		//解析数据
		$data = unserialize(urldecode($data));
		$order_id = $data['order_id'];
		$area_id = $data['area_id'];
		$service_type = $data['service_type'];
		//获取access_token
		$this->load->library('lb_redis');
		$access_token = Lb_redis::get('qiye_token');
		if(!$access_token){
			$accesstoken_url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".config_item('corpid')."&corpsecret=".config_item('corpsecret');
			$result = http_get_request($accesstoken_url);
			$token_arr = json_decode($result,true);
			if(isset($token_arr['errcode'])){
				return false;
			}
			//accesstoken 7200s
			$accesstoken = $token_arr['access_token'];
			Lb_redis::setex('qiye_token', $accesstoken, 5000);
		}

		$result = $this->master_model->get_suitable_userid($area_id, $service_type);
		foreach ($result as $key => $user) {
			//组装消息，是否图文，然后发送   $user['weixin_userid']
			$data = array("touser"=>$user['weixin_userid'],
			          "toparty"=>"",
			          "totag"=>"",
			          "msgtype"=>"text",
			          // 12 还是 60 ？
			          "agentid"=>12,
			          "text"=>array("content"=>'【乐帮到家】您有新的订单，请尽快登录后台报价吧！'),
			          "safe"=>0
			          );      
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);      
			$post_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$accesstoken;
			$result = http_post_request($post_url, $data);
			$ret = json_decode($result,true);
			//日志 ？
		}
		exit;
	}

}