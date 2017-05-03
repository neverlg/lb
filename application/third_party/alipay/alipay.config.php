<?php
/* *
 * 配置文件
 * 版本：3.5
 * 日期：2016-06-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner']		= '2088021962757810';

//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$alipay_config['seller_id']	= $alipay_config['partner'];

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= 'MIICXAIBAAKBgQCykznjnQ7Jud7hCnU6psxxevT7TVQH5xlBoZtyNZJm6gWbaRKr
									NSgnBHDzA6U0aD1PhG1ToQD/UFKc5KjDhO3J2NwrOD4VAu4bfPRjT4n74V3sgpTr
									+zRKhOwuK2ICLHQbfDgkDpi4xTZpUAwzNCFNdm0rT8dSd6kcNhRZ3d2hqwIDAQAB
									AoGANjLvKAE8QseyONVGvVVwyaSLBFb1AS0IAl59Yo2V8LxolUGv09zfYfA8I9Xg
									Z2aX7TGBSRedyN/lIw9XlXgb/1yRrGpq6Cahh3wND7oTLdY8wyBeLKsgranan4cH
									9E9SPBvmAbI60o+Vs1v42Z6RmcQWUEQ4k/zM60U9JMUV/okCQQDYG15u80vtaZT9
									D3I3vuvTqw34B8GAs+eLWCGaCCHQnrxQpxMMdKpDR9qzlUmQnL5DFqB7FODZ7zx3
									tO4+TMf/AkEA04o0etgusyR2DpQbda6e7rZqsgUxQde54VB9Im4UAMh4aCUaodb6
									5q0MfEK+CsxBL42fOR/wt35IyaeOtFDGVQJAdpjehEkk/A+bYh2d8xXl2e3f5qRq
									/zS7927QUfXwiMr0Uda+z3EfF3lRfoiJLMG4cJz0SVe15iQyrQcwUCRXBQJBAJUI
									nYieneggG/yRY/c5G0faxLi+58EXlyGib0a+fuE+W3YkDetPZlz2NgGlk/ZPiO1T
									vYWldxYPpoBLyEJJVjECQEXWvLcjDGNQp7ueEjfj0kUNc7rD0XnHM2U17G3zZmE9
									DSM16Vs9jhVQNYCclDY40/Y8DjXCtwc5ULVJ5Seajew=';

//支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm 
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = "http://lebang.bhyyxx.cn/notify_url.php";

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://lebang.bhyyxx.cn/return_url.php";

//签名方式
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

// 支付类型 ，无需修改
$alipay_config['payment_type'] = "1";
		
// 产品类型，无需修改
$alipay_config['service'] = "create_direct_pay_by_user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
	
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
$alipay_config['anti_phishing_key'] = "";
	
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
$alipay_config['exter_invoke_ip'] = "";
		
//↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>