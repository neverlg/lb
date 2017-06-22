<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//辅助工具类，生成支付流水号等
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class Util {

    /**
    * 返回随机字符串，数字/大写字母/小写字母
    * @param int $len 长度
    * @param enum $format 格式，ALL：英文字符+数字，CHAR：仅英文字符，UCNUMBER：大写英文字符+数字，LCNUMBER：小写英文字符+数字，NUMBER：仅数字，PNUMBER仅正数数字
    * @return string
    */
    public static function random($len = 6, $format = 'ALL') {
       switch (strtoupper($format)) {
           case 'ALL' :
               $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               break;
           case 'CHAR' :
               $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
               break;
           case 'UCNUMBER' :
               $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
               break;
           case 'LCNUMBER' :
               $chars = 'abcdefghijklmnopqrstuvwxyz123456789';
               break;
           case 'NUMBER' :
               $chars = '0123456789';
               break;
           case 'PNUMBER' :
               $chars = '123456789';
               break;
           default :
               $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               break;
       }
       $string = "";
       while ( strlen ( $string ) < $len )
           $string .= substr ( $chars, (mt_rand () % strlen ( $chars )), 1 );
       return $string;
    }

    public static function genOrderNumber(){
        return 'LB'.date('ymdHis').self::random(6,'UCNUMBER');
    }

    public static function genTradeNumber(){
        return date('ymdHis').sprintf('%u',crc32(microtime(true))).self::random(8,'UCNUMBER');
    }

    public static function getRefundNumber(){
        return 'TK'.date('ymdHis').self::random(3,'UCNUMBER');
    }

    public static function getComplainNumber(){
        return 'TS'.date('ymdHis').self::random(3,'UCNUMBER');
    }

    public static function getReplenishNumber(){
        return 'BK'.date('ymdHis').self::random(3,'UCNUMBER');
    }

    public static function get_qiniu_token($access_key, $secret_key, $bucket){
        $auth = new Auth($access_key, $secret_key);
        $token = $auth->uploadToken($bucket);
        return $token;
    } 

    /*
    public static function generateId($len = 20, $format = 'ALL') {
        $is_abc = $is_numer = 0;
        $password = $tmp ='';
        switch($format){
            case 'ALL':
                $chars='abcdefghijklmnopqrstuvwxyz0123456789';
                break;
            case 'CHAR':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'NUMBER':
                $chars='0123456789';
                break;
            default :
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        mt_srand((double)microtime()*1000000*getmypid());
        while(strlen($password)<$len){
            $tmp =substr($chars,(mt_rand()%strlen($chars)),1);
            if(($is_numer <> 1 && is_numeric($tmp) && $tmp > 0 )|| $format == 'CHAR'){
                $is_numer = 1;
            }
            if(($is_abc <> 1 && preg_match('/[a-zA-Z]/',$tmp)) || $format == 'NUMBER'){
                $is_abc = 1;
            }
            $password.= $tmp;
        }
        if($is_numer <> 1 || $is_abc <> 1 || empty($password) ){
            $password = self::generateId($len,$format);
        }
        return $password;

    }

    public static function generateTid($len = 20, $format = 'ALL') {
        $id = Util::generateId($len, $format);
        $tid = substr($id, 0, 10).time();
        return $tid;
    }
    */

}