<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top3.php'; ?>

<div class="ckfwjd" style="padding-top:2%;">
    <div class="container ckfwjd-1">
        <div class="bjxq1-1">
            <font color="#f00"><b>子订单付款提交成功，请你尽快付款!订单号：<?=$order_number?></b></font><br/>
            <b> 应付金额： <font color="#f1b06e" size="4">￥<?=$real_price?>元</font>(在线支付) </b>   
        </div>

        <div class="bjxq1-1">
            <font color="#000" size="4"><b>支付方式:</b></font><br/><br/>
            <a href="#"><img src="<?=asset("images/zf10.png")?>" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#"><img src="<?=asset("images/zf11.png")?>" /></a>
        </div>
        <br/>

        <div class="bjxq1-zf">
            <a href="<?=site_url('order/do_replenish/'.$trade_id.'/'.$order_id)?>">立即支付</a>
        </div>

    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
    var $deadline = <?=$deadline?>;
    timer($deadline);

    function timer(intDiff){
        window.setInterval(function(){
          var day = 0,
              hour = 0,
              minute = 0,
              second = 0;
          if(intDiff > 0){
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
         
            $("#count-down").html(day + '天' + hour + '时' + minute + '分' + second + '秒');
            intDiff--;
          }
        }, 1000);
    }
</script>