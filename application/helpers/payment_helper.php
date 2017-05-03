<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 支付相关方法
 */

// ------------------------------------------------------------------------
//支付宝
function alipay_build($out_trade_no,$subject,$total_fee,$body,$prefix){
	$CI = &get_instance();
	// 加载支付宝配置
	$CI->config->load('alipay', TRUE);
	// 加载支付宝支付请求类库
	require_once(APPPATH."third_party/alipay/lib/alipay_submit.class.php");
	
	//构造要请求的参数数组，无需改动
	$parameter = array(
			"service"       => $CI->config->item('service', 'alipay'),
			"partner"       => $CI->config->item('partner', 'alipay'),
			"seller_id"  	=> $CI->config->item('seller_id', 'alipay'),
			"payment_type"	=> $CI->config->item('payment_type', 'alipay'),
			"notify_url"	=> $CI->config->item($prefix.'_notify_url', 'alipay'),
			"return_url"	=> $CI->config->item($prefix.'_return_url', 'alipay'),
	
			"out_trade_no"		=> $out_trade_no,
			"subject"			=> $subject,
			"total_fee"			=> $total_fee,
			"body"				=> $body,
			"_input_charset"	=> trim(strtolower($CI->config->item('input_charset', 'alipay')))
	);
	//建立请求
	$alipaySubmit = new AlipaySubmit($CI->config->item('alipay'));
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	
	return  $html_text;
}