<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @todo : 用于crontab定时任务
*/

class Ontimer extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('order_model');
		$this->load->model('evaluate_model');
	}

	//查询过期未评论的订单，标记为自动评论
	public function auto_evaluate(){
		if (!is_cli()) {
			echo '非cli模式，不可访问！';
			return false;
		}
		$expire = config_item('auto_evaluate_time');
		$orders = $this->order_model->get_orders_without_evaluate($expire);
		foreach ($orders as $val) {
			$order_id = $val['id'];
			$me_id = $val['merchant_id'];
			$post = array(
				'score' => 1,
				'quality' => 5,
				'attitude' => 5,
				'ontime' => 5,
				'content' => '15天未评价系统默认好评！'
				);
			$this->evaluate_model->add_record($me_id, $post, $order_id, 1);
 		}
	}

}