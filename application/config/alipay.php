<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 自定义配置
 * 注意：该配置为支付宝配置文件
 * 其它手动加载配置项尽量用 $this->config->load('配置文件名', TRUE); 加第二个参数加载，能避免数组键冲突
 * http://codeigniter.org.cn/user_guide/libraries/config.html#id5
 */

// --------------------------------------------------------------------
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$config['partner']		= '2088021962757810';

//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$config['seller_id']	= $config['partner'];

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$config['private_key']	= 'MIICXAIBAAKBgQCykznjnQ7Jud7hCnU6psxxevT7TVQH5xlBoZtyNZJm6gWbaRKrNSgnBHDzA6U0aD1PhG1ToQD/UFKc5KjDhO3J2NwrOD4VAu4bfPRjT4n74V3sgpTr+zRKhOwuK2ICLHQbfDgkDpi4xTZpUAwzNCFNdm0rT8dSd6kcNhRZ3d2hqwIDAQABAoGANjLvKAE8QseyONVGvVVwyaSLBFb1AS0IAl59Yo2V8LxolUGv09zfYfA8I9XgZ2aX7TGBSRedyN/lIw9XlXgb/1yRrGpq6Cahh3wND7oTLdY8wyBeLKsgranan4cH9E9SPBvmAbI60o+Vs1v42Z6RmcQWUEQ4k/zM60U9JMUV/okCQQDYG15u80vtaZT9D3I3vuvTqw34B8GAs+eLWCGaCCHQnrxQpxMMdKpDR9qzlUmQnL5DFqB7FODZ7zx3tO4+TMf/AkEA04o0etgusyR2DpQbda6e7rZqsgUxQde54VB9Im4UAMh4aCUaodb65q0MfEK+CsxBL42fOR/wt35IyaeOtFDGVQJAdpjehEkk/A+bYh2d8xXl2e3f5qRq/zS7927QUfXwiMr0Uda+z3EfF3lRfoiJLMG4cJz0SVe15iQyrQcwUCRXBQJBAJUInYieneggG/yRY/c5G0faxLi+58EXlyGib0a+fuE+W3YkDetPZlz2NgGlk/ZPiO1TvYWldxYPpoBLyEJJVjECQEXWvLcjDGNQp7ueEjfj0kUNc7rD0XnHM2U17G3zZmE9DSM16Vs9jhVQNYCclDY40/Y8DjXCtwc5ULVJ5Seajew=';

//支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm 
$config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';

$config['recharge_notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/payment_notify/alipay_recharge';
$config['recharge_return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/ewallet/pay_success';

$config['order_pay_notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/payment_notify/alipay_order';
$config['order_pay_return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/order/pay_success';




// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问 支付通知地址
$config['notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index/comm/paynotify';

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问 支付通知地址
$config['return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/merchant/order/payreturn';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问 支付通知地址
$config['notifylist_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index/comm/paynotifylist';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问 退款通知地址
$config['renotify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index/comm/refundnotify';

//签名方式
$config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$config['cacert']    =  APPPATH.'third_party/alipay/cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$config['transport']    = 'http';

// 支付类型 ，无需修改
$config['payment_type'] = "1";
		
// 产品类型，无需修改 支付
$config['service'] = "create_direct_pay_by_user";

// 产品类型，无需修改 退款
$config['servicerefund']='refund_fastpay_by_platform_pwd';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
	
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
$config['anti_phishing_key'] = "";
	
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
$config['exter_invoke_ip'] = "";
		
//↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑