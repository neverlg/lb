<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-md-3">
    <div class="htnr-1-1">
        <img src="<?=asset("images/fz.png")?>" />管理中心首页
    </div>
    <div class="htnr-t">
     	<div class="htnr-1-2">
     		<img src="<?=asset("images/ht4.png")?>" />报价订单管理
     	</div> 
		<div class="htnr-1-3">
			<a href="<?=site_url('order/baojia_index')?>">订单管理</a>
			<a href="<?=site_url('goods/index/1')?>">货品仓库</a><br/>
			<a href="<?=site_url('evaluate/index')?>">评价管理</a>
			<a href="<?=site_url('refund/index/1')?>">退款管理</a><br/>
			<a href="<?=site_url('complain/index')?>">投诉举报</a>
		</div>
    </div>
    <!--
    <div class="htnr-t">
     	<div class="htnr-1-2">
     		<img src="<?=asset("images/ht4.png")?>" />定价订单管理
     	</div> 
		<div class="htnr-1-3">
			<a href="#">订单管理</a>
			<a href="#">货品仓库</a></br>
			<a href="<?=site_url('refund/index/2')?>">退款管理</a>
		</div>
    </div>
    -->
    <div class="htnr-t">
		<div class="htnr-1-2">
			<img src="<?=asset("images/ht1.png")?>" />我的电子钱包
		</div> 
		<div class="htnr-1-3">
			<a href="<?=site_url('ewallet/index')?>">钱包余额</a>
			<a href="<?=site_url('ewallet/coupon')?>">优惠券</a><br/>
			<a href="<?=site_url('ewallet/set_paypass')?>">钱包密码</a>
		</div>
    </div>
    <div class="htnr-t">
		<div class="htnr-1-2">
			<img src="<?=asset("images/ht2.png")?>" />我的账户管理
		</div> 
		<div class="htnr-1-3">
			<a href="<?=site_url('account/index')?>">基本资料</a>
			<a href="<?=site_url('account/avatar')?>">个人头像</a><br/>
			<a href="<?=site_url('account/security')?>">安全设置</a>
		</div>
    </div>
	<div class="htnr-t">
	    <div class="htnr-1-2">
		    <img src="<?=asset("images/ht3.png")?>" />我的消息管理
	    </div> 
	    <div class="htnr-1-3">
		    <a href="<?=site_url('news/index')?>">新闻中心</a>
		    <a href="<?=site_url('message/index')?>">我的消息<font color="#f00">(<?=$this->_message_count?>)</font></a><br/>
				<a href="<?=site_url('message/feedback')?>">留言反馈</a>
		</div>
    </div> 
</div>