<?php
class Lb_redis {

	private static $_redis;

	public static function instance() {

		$ci = &get_instance();
		$config = $ci->config->item('lb_redis');
		self::$_redis = new Redis();
		self::$_redis->pconnect($config['ip'],$config['port']);
		if(!empty($config['password'])) {
			self::$_redis->auth($config['password']);
		}
	}

	public static function set($key, $value, $exp = 0) {

		if (!isset(self::$_redis)) {
			self::instance();
		}
		$res =  self::$_redis->set($key, $value);
		if ($exp != 0) {
			$res = self::$_redis->expire($key,$exp);
		}
		
		return $res;
	}


	public static function hmset($key, $field, $exp = 0) {
		if (!isset(self::$_redis)) {
			self::instance();
		}
		$res =  self::$_redis->hmset($key,$field);
		if ($exp != 0) {
			$res = self::$_redis->expire($key,$exp);
		}
		
		return $res;
	}


	public static function hset($key, $field, $value) {
		if (!isset(self::$_redis)) {
			self::instance();
		}

		return self::$_redis->hset($key, $field, $value);
	}

	public static function get($key) {
		if (!isset(self::$_redis)) {
			self::instance();
		}
		return self::$_redis->get($key);
	}

	public static function hmget($key,$field) {
		if (!isset(self::$_redis)) {
			self::instance();
		}
		return self::$_redis->hmget($key,$field);
	}

	public static function hget($key) {
		if (!isset(self::$_redis)) {
			self::instance();
		}
		return self::$_redis->hget($key);
	}


	public static function delete($key) {
		if (!isset(self::$_redis)) {
			self::instance();
		}
		return self::$_redis->delete($key);
	}

}
