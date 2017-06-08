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

//发送短信验证码的时间间隔及次数限制，默认10分钟只能发送3次
$config['sms_expire'] = 600;
$config['sms_count'] = 3;

//生成的短信验证码长度，默认为6
$config['sms_length'] = 6;

//短信验证码在验证表单时的过期时间，默认5分钟
$config['sms_submit_expire'] = 300; 

//商家类型
$config['merchant_category'] = array(
	1 => '家具电商',
	2 => '物流公司',
	3 => '个人用户'
	);

//货品仓库品类
$config['goods'] = array(
	1 => '柜类',
	2 => '床类',
	3 => '床垫类',
	4 => '桌类',
	5 => '茶几类',
	6 => '架类',
	7 => '沙发类',
	8 => '椅类',
	9 => '屏风隔断',
	10 => '办公类',     #此项目前无用
	11 => '其他',
	12 => '坐具类'
	);

//每页显示的数量，用于分页
$config['num_per_page'] = array(
	'goods_index' => 25,      #货品仓库首页时
	'goods_order' => 25,      #货品仓库下单时
	'coupon_index' => 6,      #优惠券列表
	'ewallet_index' => 6,     #交易列表（电子钱包）
	'evaluate_index' => 6,    #评论列表
	'complain_index' => 6,    #投诉列表
	'message_index' => 10,    #个人消息列表
	'refund_index' => 10,     #退款管理首页
	'order_index' => 12,      #报价/定价订单首页
    'master_evaluate' => 20,      #师傅评价
	);

//充值送余额
$config['recharge_award'] = array(
	'0.01' => 2,   #测试用，上线删掉
	'500' => 5,
	'2000' => 25,
	'5000' => 75,
	'10000' => 180
	);

//帮助中心
$config['article'] = array(
	0 => '账户相关',
	1 => '订单相关',
	2 => '付款相关',
	3 => '退款相关',
	4 => '投诉相关',
	);

//新闻中心
$config['news'] = array(
	0 => '公司新闻',
	1 => '行业新闻',
	);

//电子钱包
$config['trade_type'] = array(
	1 => '充值',
	2 => '下单',
	3 => '退单',
	4 => '补款',
	5 => '退款',
	6 => '批量付款'
	);

//优惠券c_type
$config['coupon'] = array(
	1 => '电子券',
	);

//服务类型
$config['service_type'] = array(
	1 => '提货配送上门+安装',
	2 => '上门安装',
	3 => '上门维修',
	4 => '提货配送上门',
	5 => '打包返货',
	);

//退款状态
$config['refund_status'] = array(
	1 => '待师傅确认中',
	2 => '师傅拒绝退款',
	3 => '退款成功',
	4 => '退款成功',
	5 => '介入仲裁中',
	6 => '退款关闭',
	);

//退款类型
$config['refund_type'] = array(
	1 => '全额退款',
	2 => '部分退款'
	);

//退换方式
$config['refund_method'] = array(
	1 => '我的钱包',
	2 => '原路退回'
	);

//投诉结果
$config['complain_result'] = array(
	1 => '等待核实处理',
	2 => '已撤回投诉',
	3 => '投诉成功',
	4 => '投诉失败',
	);

//投诉类别
$config['complain_category'] = array(
	//师傅服务不诚信
	1 => array(
		1 => '师傅引导用户线下交易',
		2 => '师傅被雇佣后（托管费用后）拒绝服务',
		3 => '师傅没有按预约时间上门服务',
		4 => '师傅服务中途恶意加价',
		5 => '师傅向客户收取额外费用',
		6 => '师傅未在48小时内完成服务',
		7 => '师傅向客户泄露服务费用',
		8 => '师傅服务未完成，向客户索取服务确认码',
		9 => '师傅不遵守自己填写的附加服务',
		10 => '师傅上传虚假完工照',
		),

	//师傅服务不规范
	2 => array(
		11 => '师傅没有在雇佣付款后两小时内及时预约客户',
		12 => '师傅超过48小时联系不上',
		13 => '师傅服务态度恶劣（如威胁）',
		14 => '师傅物流提货时未仔细检查',
		15 => '师傅在安装或拆包装发现破损未及时反映',
		16 => '师傅在服务中让客户帮忙',
		17 => '师傅安装过程中造成货物损失',
		18 => '师傅服务问题导致客户差评',
		19 => '师傅向客户诋毁家具质量',
		20 => '师傅服务完成后，没有让客户填写服务签收单',
		21 => '师傅未及时更新订单服务进度',
		22 => '需要喵师傅核销订单，师傅未进行核销',
		)
	);

//报价订单首页，商家端订单状态
$config['baojia_merchant_order_status'] = array(
	1 => '待师傅报价',
	2 => '待雇佣师傅',
	3 => '待托管费用',
	4 => '已支付预付款',
	5 => '师傅服务中',
	6 => '师傅完成服务',
	7 => '验收交易成功',
	);

//下单后截止报价时间，默认48小时
$config['baojia_deadline'] = 48*3600;

//师傅无操作多长时间后，系统自动退款，默认7天
$config['auto_refund_time'] = 7*24*3600;

//商家无评论多长时间之后，系统自动评价，默认15天
$config['auto_evaluate_time'] = 15*24*3600;

//师傅服务完成之后，商家无操作多久之后，自动放款
$config['auto_confirm_time'] = 5*24*3600;

//订单发起支付，多久未支付，就关闭订单
$config['auto_close_order'] = 3*24*3600;

//支付方式
$config['pay_type'] = array(
	1 => '钱包付款',
	2 => '在线付款',  #never use
	3 => '微信付款',
	4 => '支付宝付款',
	5 => '银联付款',
	);

//redis配置
$config['lb_redis'] = array(
	'ip' => '119.23.147.164',
	'port' => '6379',
	'password' => 'lrTWm82u'
	);

//weixin 
$config['corpid'] = 'wx4151e8d2b426ba03';
$config['corpsecret'] = 'biIWkTykh5LK0jch6mNlBCU-af0YG9ecGqED46ri316tFjjyAvoVjbq4uNyW75Uo';
$config['agentid'] = 12;
//是否开启消息推送调试，开启后，仅在push_debug_userid里的师傅可以收到推送
$config['push_debug'] = true;
$config['push_debug_userid'] = array('huangweidong', 'WuXiao', 'luogan');

//七牛
$config['qiniu'] = array(
	'access_key' => 'DgPyfeeI97Y48b2BRYK1NyQ74e2PgBizlEQbTNR4',
	'secret_key' => 'aks6WQKgYH2ivpvqlG_su1DDMrj6KYZEqKdZnUej',
	'upload_url' => 'http://upload-z2.qiniu.com',  #华南
	'source_url' => 'http://on7uwttp2.bkt.clouddn.com/'
	);

// ajax响应字段，用在ajax_response函数
$config['ajax_response_field']['status'] = 'status';  // 状态字段
$config['ajax_response_field']['error']  = 'error';   // 错误消息字段
$config['ajax_response_field']['data']   = 'data';    // 返回数据体字段

$config['base_url'] = 'http://shangjia.lebangdaojia.local/';