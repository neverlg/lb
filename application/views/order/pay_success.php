<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top3.php'; ?>

<div class="ckfwjd" style="padding-top:2%;">
    <div class="container ckfwjd-1">
        <div class="zftz-d">
            <img src="<?=asset("images/dui18.png")?>" />订单支付成功！
        </div>

        <div class="zftz-d-1">
            订单编号：<?=$order_number?><br/>
            服务类型：<?=$service_type?><br/>
            付款金额：<font color="#f00"><?=$fee?>元</font><br/>
            师傅姓名：<?=$master_name?>
            <?php if(!empty($master_phone)){ ?>
            （<?=$master_phone?>）
            <?php } ?>
        </div>
        <br/>

        <div class="bjxq1-zf" style="text-align:center;">
            <a href="<?=site_url('order/baojia_detail/'.$order_id)?>">查看订单</a>
            <a style="background:#f08519;" href="<?=site_url('order/baojia')?>">继续下单</a>
        </div>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>


