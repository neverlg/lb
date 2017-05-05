<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_server {
	private $host = "http://admin.lebangdaojia.com/";

	//商家支付预付款雇佣师傅
	private $order_employed = "api/event/orderemployed/";
	//商家确认收款到账-
	private $order_success = "api/event/ordersuccess/";
	//商家给师傅评分-
	private $order_evaluate = "api/event/orderevaluated/";
	//商家发起退款申请-
	private $merchant_refund = "api/event/merchantorderrefund/";
	//商家发起仲裁申请-
	private $merchant_arbitrate = "api/event/merchantorderarbitrate/";
	//商家发起投诉-
	private $merchant_complain = "api/event/merchantordercomplain/";
	//商家充值
	private $merchant_charge = "api/event/merchantrecharge/";

	public function order_employed_call($order_id){
		$url = $this->host . $this->order_employed . $order_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function order_success_call($order_id){
		$url = $this->host . $this->order_success . $order_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function order_evaluate_call($evaluate_id){
		$url = $this->host . $this->order_evaluate . $evaluate_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function merchant_refund_call($refund_id){
		$url = $this->host . $this->merchant_refund . $refund_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function merchant_arbitrate_call($refund_id){
		$url = $this->host . $this->merchant_arbitrate . $refund_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function merchant_complain_call($complain_id){
		$url = $this->host . $this->merchant_complain . $complain_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	public function merchant_charge_call($trade_id){
		$url = $this->host . $this->merchant_charge . $trade_id;
		$ret = http_post_request($url);
		return $this->handle_response($ret);
	}

	private function handle_response($ret){
      	return json_decode($ret, true);
  	}
}