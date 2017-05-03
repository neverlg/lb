<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 自定义配置
 * 注意：
 * 该配置是全局自动加载的，数组键名要考虑清楚，否则可能会覆盖掉另外配置项，或者被其它配置项覆盖。
 * 其它手动加载配置项尽量用 $this->config->load('配置文件名', TRUE); 加第二个参数加载，能避免数组键冲突
 * http://codeigniter.org.cn/user_guide/libraries/config.html#id5
 */

// --------------------------------------------------------------------

// 私有静态资源（只用于本项目）
$config['private_asset_url'] = 'assets/';

// 公有静态资源（多项目共用，放在独立的地方，绑定特定域名）
$config['public_asset_url'] = '';

// --------------------------------------------------------------------

// upload目录存放上传文件（可考虑绑定单独域名）
$config['upload_url'] = 'upload/';

// 上传目录物理路径(可用相对)
$config['upload_path'] = '/data/wwwroot/www.lebangdaojia.com/upload/';

// --------------------------------------------------------------------
// ajax响应字段，用在ajax_response函数
$config['ajax_response_field']['status'] = 'status';  // 状态字段
$config['ajax_response_field']['error']  = 'error';   // 错误消息字段
$config['ajax_response_field']['data']   = 'data';    // 返回数据体字段

//manager_grade
$config['manager_grade'] = array('0'=>'客服', '1'=>'管理员');

//pro_state
$config['pro_state'] = array('1'=>'待接受', '2'=>'执行中', '3'=>'已拒绝', '4'=>'已完成', '5'=>'已撤回');

//pay_state
$config['pay_state'] = array('1'=>'未结算', '2'=>'已结算');

//master_state
$config['ma_state'] = array('1'=>'正常', '2'=>'停单');

//master servicetype
$config['ma_servicetype'] = array('1'=>'配送安装','2'=>'上门安装','3'=>'上门维修','4'=>'配送上门');

//order servicetype
$config['o_servicetype'] = array('1'=>'配送安装','2'=>'上门安装','3'=>'上门维修','4'=>'配送上门');

//elevator
$config['elevator'] = array('1'=>'电梯','2'=>'步梯');

//list num
$config['num_per_page'] = 100;

//weixin 
$config['corpid'] = 'wx4151e8d2b426ba03';
$config['corpsecret'] = 'andeuuNoFXXcnCZiICoPnb3zvyhXUHn67nd_hl7mBxoLIN0lBE8ADM3RCnxsiOYd';
$config['agentid'] = 12;

//------------------admin和master的华丽分割线-----------------------
//cookie salt
$config['salt'] = 'lehelp_2016';

//price per floor
$config['floor_price'] = 10;

//paging
$config['mobile_paging'] = 5;

//trace
$config['trace'] = array('1'=>'货物已到，标记物流通知时间为：',
						 '2'=>'。物流电话：',
						 '3'=>'预约客户：今天安排。',
						 '4'=>'预约客户：已预约其他明确时间为：',
						 '5'=>'预约客户：客户无法给出明确时间，等客户通知。',
						 '6'=>'改期原因：客户原因。',
						 '7'=>'改期原因：师傅本人原因。',
						 '8'=>'改期原因：',
						 '9'=>'到达提货点。',
						 '10'=>'货物外包装有明显破损，能维修，维修费用为：',
						 '11'=>'货物外包装有明显破损，不能维修',
						 '12'=>'货物丢失/少件。',
						 '13'=>'货物有明显浸泡痕迹',
						 '14'=>'产生额外垫付费用，具体为：',
						 '15'=>array('运费','中转费','落地费/卸装费','仓储费','超出配送距离运费'),
						 '16'=>'搬楼费：',
						 '17'=>'费用：',
						 '18'=>'货物破损，能维修，维修费用为：',
						 '19'=>'货物破损，不能维修。',
						 '20'=>'增加破损处数量：',
						 '21'=>'处。维修费用：',
						 '22'=>'完成服务。'
						);