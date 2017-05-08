<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
		<a href="javascript:void(0);">报价订单详情</a>》
	</div>
</div>

<div class="ckfwjd">
    <div class="container ckfwjd-1">
        <div class="ckjd-1">
            <a href="<?=site_url('order/baojia_detail/'.$order_id)?>">报价订单详情</a>
            <a href="<?=site_url('order/baojia_offer/'.$order_id)?>">师傅报价<font color="#f00">(<?=$master_num?>)</font></a>
            <a class="on" href="<?=site_url('order/baojia_trace/'.$order_id)?>">查看服务节点</a>

            <?php if($trace['refund_status']==1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>">申请退款中 ></a>
                </span>
            </span>
            <?php }else if($trace['arbitrate_status']==1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>">申请仲裁中 ></a>
                </span>
            </span>
            <?php }else if($trace['except_status']>1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>" style="background-color:gray;">退款成功 ></a>
                </span>
            </span>
            <?php }else{ ?>

            <span class="ckjd-1-1">
                <?php if($trace['merchant_status']==6){ ?>
                <span id="confirm-count">
                    -天--时--分--秒将自动确认验收放款
                </span>

                <script type="text/javascript">
                    var timestamp = Date.parse(new Date()); 
                    var intDiff = <?=(config_item('auto_confirm_time')+$trace['finish_time'])?> - timestamp/1000;

                    $(function(){
                        timer(intDiff);
                    }); 
                </script>

                <span class="ckjd-1-2"> 
                    <a href="<?=site_url('order/baojia_detail/'.$order_id)?>">确认验收 ></a>
                </span>
                <?php } ?>

                <?php if($trace['merchant_status']<7){ ?>
                <span class="ckjd-1-3">
                    <a href="<?=site_url('refund/add/'.$order_id)?>">申请退款</a>
                </span>
                <?php }else if($trace['evaluate_status']==0){ ?>
                <span class="ckjd-1-2"> 
                    <a href="<?=site_url('evaluate/add/'.$order_id)?>">评价师傅 ></a>
                </span>
                <?php }else if($trace['evaluate_status']==1){ ?>
                <span class="ckjd-1-3">
                    <a>你已评价师傅</a>
                </span>
                <?php } ?>
            </span>
            <?php } ?>
        </div>

        <div class="ckjd-2">
            <?php if(empty($trace['appoint_time'])){ ?>
            <div class="ckjd-2-1">
                <font size="4">暂无服务记录。</font>
            </div>
            <?php }else{ ?>
            <div class="ckjd-2-1">
                <font size="4">预约客户:</font><br/>
                <?=$trace['appoint_time']?>&nbsp;&nbsp;师傅已预约客户&nbsp;&nbsp;上门服务时间：<?=$trace['door_time']?>
            </div>

            <?php if(!empty($trace['deliver_time'])){ ?>
            <div class="ckjd-2-1">
                <font size="4">物流提货:</font><br/>
                <?=$trace['deliver_time']?>&nbsp;&nbsp;师傅已到达物流点提货&nbsp;&nbsp;物流签收状态：<?php if($trace['master_status']==3){echo '正常签收';}else if($trace['master_status']==4){echo '提货异常';} ?><br/>
                <?php foreach($trace['deliver_imgs'] as $key){ ?>
                <img src="<?=$key?>" />  
                <?php } ?>
            </div>
            <?php } ?>

            <?php if(!empty($trace['finish_time'])){ ?>
            <div class="ckjd-2-1">
                <font size="4">完成服务:</font><br/>
                <?=$trace['finish_time_txt']?>&nbsp;&nbsp;师傅操作完成服务&nbsp;&nbsp;
                <?=empty($trace['finish_message'])?'':'留言：'.$trace['finish_message']?><br/>

                完成的家具照片:<br/>
                <?php foreach($trace['finish_imgs'] as $val){ ?>
                <img src="<?=$val?>" />  
                <?php } ?>

                <!--
                <br/>喵师傅成功核销截图:<br/>
                <img src="images/ck1.png" />
                -->

                <br/>客户签收单照片:<br/>
                <?php foreach($trace['finish_ticket_img'] as $val){ ?>
                <img src="<?=$val?>" />
                <?php } ?>
            </div>
            <?php } ?>

            <div class="ckjd-2-2">
                温馨提示:如果师傅提供了虚假的服务完成照片，你可以对师傅进行投诉！
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
    function timer(intDiff, type=0){
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

            $("#confirm-count").html(day + '天' + hour + '时' + minute + '分' + second + '秒');
            
            intDiff--;
          }
        }, 1000);
    }
</script>

