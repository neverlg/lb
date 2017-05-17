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
			$access_token = $token_arr['access_token'];
			Lb_redis::set('qiye_token', $access_token, 5000);
		}

		$result = $this->master_model->get_suitable_userid($area_id, $service_type);
		foreach ($result as $key => $user) {
			//组装消息，是否图文，然后发送   $user['weixin_userid']
			$data = array("touser"=>$user['weixin_userid'],
			          "toparty"=>"",
			          "totag"=>"",
			          "msgtype"=>"text",
			          "agentid"=>config_item('agentid'),
			          "text"=>array("content"=>'【乐帮到家】您所在区域有新订单，请尽快去报价！'),
			          "safe"=>0
			          );      
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);      
			$post_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$access_token;
			$result = http_post_request($post_url, $data);
			$ret = json_decode($result,true);
			//日志 ？
			if(empty($ret) || $ret['errcode']!=0){
				$str = var_export($ret, true);
				log_message('error', '【推送师傅消息】order_id='.$order_id.", username=".$user['weixin_userid']."\r\n返回值为：".$str);
			}
		}
		exit;
	}


	public function push_master_test($data=''){
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
			$access_token = $token_arr['access_token'];
			Lb_redis::set('qiye_token', $access_token, 5000);
		}

		//组装消息，是否图文，然后发送   $user['weixin_userid']
		$data = array("touser"=>'WuXiao',
		          "toparty"=>"",
		          "totag"=>"",
		          "msgtype"=>"text",
		          "agentid"=>config_item('agentid'),
		          "text"=>array("content"=>'【乐帮到家】您所在区域有新订单，请尽快去报价！'),
		          "safe"=>0
		          );      
		$data = json_encode($data, JSON_UNESCAPED_UNICODE);      
		$post_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$access_token;
		$result = http_post_request($post_url, $data);
		$ret = json_decode($result,true);
		//日志 ？
		if(empty($ret) || $ret['errcode']!=0){
			$str = var_export($ret, true);
			log_message('error', '【推送师傅消息】order_id='.'123456'.", username=".'WuXiao'."\r\n返回值为：".$str);
		}
		exit;
	}
}