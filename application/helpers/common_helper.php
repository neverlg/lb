<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 公共函数
 */

// ------------------------------------------------------------------------

if( ! function_exists("redirect_back"))
{
	/**
	 * 返回上页
	 */
	function redirect_back() {
		echo '<script>window.history.back()</script>';
		exit;
	}
}

// ------------------------------------------------------------------------

if( ! function_exists("upload_url"))
{
	/**
	 * 上传文件完整的链接地址
	 * 如果是空则返回空字符串，如果是完整网址直接返回，如果是相对地址返回拼接后的完整地址
	 * 
	 * @param  string $url 上传文件相对路径
	 * 
	 * @return string
	 */
	function upload_url($url) {
		if (empty($url)) {
			return '';
		} elseif (preg_match("#^http(s?)://#i", $url)) {
			return $url;
		} else {
			return config_item('upload_url') . $url;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('input_get')) 
{	
	/**
	 * 获取$_GET数据，参数参考input_base函数
	 */
	function input_get($index = NULL, $value_type = 0, $xss_clean = NULL) {
		return input_base('get', $index, $value_type, $xss_clean);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('input_post')) 
{
	/**
	 * 获取$_POST数据，参数参考input_base函数
	 */
	function input_post($index = NULL, $value_type = 0, $xss_clean = NULL) {
		return input_base('post', $index, $value_type, $xss_clean);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('input_base')) 
{	
	/**
	 * 获取$_GET、$_POST数据
	 *
	 * @param  string $method 输入类型：get|post
	 * @param  mixed $index 键名，可输入字符串或数组，留空获取全部
	 * @param  int $value_type 数据类型，0：字符串，1：整型
	 * @param  bool $xss_clean 是否使用CI的XSS过滤（一般不建议使用，XSS过滤应该在输出做）
	 *
	 * @return mixed
	 */
	function input_base($method, $index = NULL, $value_type = 0, $xss_clean = NULL) {
		if ( ! in_array($method, array('get', 'post'))) exit('error_input_method');
		$CI =& get_instance();
		$data = $CI->input->$method($index, $xss_clean);
		if ($value_type == 1) {
			return my_intval($data);
		}
		return $data;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ajax_response'))
{
	/**
	 * ajax请求响应
	 *
	 * @param  int $status 状态：0失败，1成功
	 * @param  string|array $error 错误消息，建议用英文短语，下划线分隔每个单词，便于前端用来做判断，例如：error_name_length。没有错误留空。单个错误用字符串，多个用数组。
	 * @param  string|array $data 返回数据体，字符串 或 数组
	 * @param  bool	$html_escape 是否转义数据，防止XSS
	 * @param  bool $exit 是否输出后中断，默认true
	 */
	function ajax_response($status, $error = null, $data = null, $html_escape = true, $exit = true)
	{
		if ( ! in_array($status, array(0, 1)) ) exit('error_response_status');
		$CI =& get_instance();
		$fields = $CI->config->item('ajax_response_field');
		$response = array(
			$fields['status'] => $status, 
			$fields['error']  => $error,
			$fields['data']   => $data,
		);
    	if ($html_escape) {
    		$response = my_html_escape($response);
    	}
		$ouput = $CI->output
			->set_content_type('application/json', $CI->config->item('charset'))
			->set_output(json_encode($response));
		if ($exit) {
			$ouput->_display();
			exit;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('view'))
{
	/**
	 * 加载模板
	 *
	 * 配置项目在 my_config.php 的 $config['view_assembly']
	 *
	 * @param  string $path 模板路径
	 * @param  array $data 模板数据
	 * @param  string $type 模板类型（参考$config['view_assembly']二维数据的键名）
	 */
	function view($path, $data, $type = 'default') {
		$CI =& get_instance();
		$views = $CI->config->item('view_assembly');
		if ( ! isset($views[$type])) exit('error_view_assembly_type');
		$views = $views[$type];
		$i = 0;
		foreach ($views as $view) {
			if (empty($view)) $view = $path;
			if ($i == 0) {
				$CI->load->view($view, $data);
			} else {
				$CI->load->view($view);
			}
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('asset'))
{
	/**
	 * 加载静态资源
	 *
	 * @param  string 静态资源路径
	 * @param  int 静态资源类型（0：私有静态资源，1：公有静态资源）
	 *
	 * @return string 静态资源URL
	 */
	function asset($path, $type = 0)
	{
		if ( ! in_array($type, array(0, 1))) exit('error_asset_type');
		if (empty($type)) {
			$asset_url = config_item('private_asset_url');
		} else {
			$asset_url = config_item('public_asset_url');
		}
		return base_url($asset_url . $path);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('head_title'))
{
	/**
	 * 页头标题
	 *
	 * @param  string|array $title 标题字符串或数组
	 *
	 * @return string 拼接好的标题字符串，用 - 分隔
	 *
	 * @global 设置全局配置项$config['head_title']
	 */
	function head_title($title = null)
	{	
		$CI =& get_instance();
		$site_name = $CI->config->item('site_name');
		if (empty($title)) {
			$title = $site_name;
		} else {
			$title = implode(' - ', (array)$title) . ' - ' . $site_name;
		}
		$CI->config->set_item('head_title', $title);
		return $title;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('my_html_escape'))
{
	/**
	 * Returns HTML escaped variable.
	 *
	 * 注意：
	 * 如果传入的是数组，只要键名是__开头的，都不会转义，用在一些需要解释html的地方
	 * 但内容要使用strip_tags()传入第二个参数仅保留合法标签。例如：
	 * $data = array('__html' => strip_tags('<b style="color:red">这是合法的</b> <script>alert("不合法")</script>', '<b>'))
	 *
	 * @param	mixed	$var		The input string or array of strings to be escaped.
	 * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
	 * @return	mixed			The escaped string or array of strings as a result.
	 */
	function my_html_escape($var, $double_encode = TRUE)
	{
		if (empty($var))
		{
			return $var;
		}
		
		if (is_array($var))
		{
			$array = array();
			foreach ($var as $k => $v) 
			{
				// 
				if ($k[0] == '_' && $k[1] == '_') 
				{ 
					$array[$k] = $v;
				} else {
					$array[$k] = my_html_escape($v);
				}
			}
			return $array;
		}

		return htmlspecialchars($var, ENT_QUOTES, config_item('charset'), $double_encode);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('my_intval'))
{
	/**
	 * 获取变量的整数值
	 *
	 * @param  mixed $var 字符串或数组
	 *
	 * @return mixed
	 */
	function my_intval($var) {
		if (is_array($var)) {
			foreach ($var as $k => $v) {
				$var[$k] = my_intval($v);
			}
		} else {
			$var = intval($var);
		}
		return $var;
	}
}


if ( ! function_exists('http_post_request'))
{
	//post请求
	function http_post_request($uri, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$rt = curl_exec($ch);
		curl_close($ch);
		return $rt;
	}
}


if ( ! function_exists('http_get_request'))
{
	//post请求
	function http_get_request($url){
		$curl = curl_init();
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($curl, CURLOPT_URL, $url);
    	$res = curl_exec($curl);
    	curl_close($curl);
    	return $res;
	}
}


if( !function_exists('get_ip_location')){
	/**
	 * 获取ip位置
	 * @param  $ip ip地址
	 * @return 
	 */
	function get_ip_location($ip){
        $url = 'http://beihai365.com/baseapi/index.php?c=info&m=ip&ac=getipinfo&ip='. $ip .'&key=i843kjlwesl29l2';
        $result = $this->http_get($url);
        $result = json_decode($result, true);
        $location = "";
        if(isset($result['result']) && $result['result'] == 'success'){
            $location = implode("", $result['data']);
        }

        return empty($location) ? "归属地未知" : $location;

    }

}

//get http or https
if( !function_exists('http_type')){
	/**
	 * @todo get http or https
	 * @return 
	 */
	function http_type() {
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 1){  //Apache  
        	return "https://";
    	}elseif(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){ //IIS  
        	return "https://";
    	}elseif ($_SERVER['SERVER_PORT'] == 443){	//other
    		return "https://";
    	}
    	return "http://";
 	}

}


//global memcached 
if(!function_exists('memory')){
	/**
	 * @todo 全局memcached的便携操作
	 * @param $cmd = get/set/rm
	 *        string $key   mix $value  int $expire
	 */
	function memory($cmd, $key, $value=null, $expire=600){
		static $enable = null;
		$CI = &get_instance();
		if(is_null($enable)){
			$mem_config = $CI->config->item('memcache');
			$enable = $mem_config['enable'];
		}
		if($enable){
			$CI->load->driver('cache');
			switch($cmd){
				case 'get':
					return $CI->cache->memcached->get($key);
					break;
				case 'set':
					return $CI->cache->memcached->save($key, $value, $expire);
					break;
				case 'rm':
					return $CI->cache->memcached->delete($key);
					break;
			}
		}else{
			show_error('Can not connect to memory server', 500);
		}
	}
}

// ------------------------------------------------------------------------

if(!function_exists('send_sms')){
	/**
	 * 发送短信信息
	 * @param  
	 * @return 
	 */
	function send_sms($Content,$to,$type,$code=''){
        $CI = &get_instance();
		$CI->load->model('sms_model');
		$sl_id = $CI->sms_model->add_sms_log($Content,$to,$type,$code);
		if ($sl_id>0){
			$url="http://service.winic.org:8009/sys_port/gateway/index.asp?";
	        $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
	        $id = iconv("UTF-8","GB2312","乐帮到家");
	        $pwd = 'lb4008004703';
	        $content = iconv("UTF-8","GB2312",$Content);
	        $rdata = sprintf($data, $id, $pwd, $to, $content);
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_POST,1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	        $result = curl_exec($ch);
	        curl_close($ch);
			$smslist = explode('/',$result);
			if ($smslist['0'] !='000'){
				$CI->sms_model->upd_sms_log($sl_id,$result);
				return 0;
			}
			return 1;
		}
		return 0;
	}
}

if(!function_exists('generate_sms_code')){
	/**
	 * 短信验证码生成
	 * @param  
	 * @return 
	 */
	function generate_sms_code($length){
        return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
	}
}

if(!function_exists('check_mobile')){
	/**
	 * 验证手机号是否合法
	 * @param  
	 * @return 
	 */
	function check_mobile($phone){
        if(preg_match("/^1[34578]{1}\d{9}$/",$phone)){
        	return true;
        }
        return false;
	}
}

if(!function_exists('get_province')){
	/**
	 * 获取省市区三级联动，存储在redis里
	 * @return 
	 */
	function get_province(){
        $CI = &get_instance();
        $CI->load->library('lb_redis');
        $result = Lb_redis::get('lg_province');
        if($result){
        	return $result;
        }
		$CI->load->model('province_model');
		$result = $CI->province_model->get_all_items();
		$result = json_encode($result);
		Lb_redis::set('lg_province', $result, 7200);
		return $result;
	}
}