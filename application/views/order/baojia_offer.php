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
            <a class="on" href="<?=site_url('order/baojia_offer/'.$order_id)?>">师傅报价<font color="#f00">(<?=$master_num?>)</font></a>
            <a href="<?=site_url('order/baojia_trace/'.$order_id)?>">查看服务节点</a>

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

        <?php $hired_flag=0;foreach($master['base'] as $i => $val){ ?>
        <div class="ybj">
            <div class="ybj-1 col-md-4" rel="<?=$val['id']?>" style="cursor:pointer;">
                <div class="col-md-4 ybj-2">
                    <img src="<?=$val['head_img']?>" />
                </div>
                <div class="col-md-8 ybj-3 ">
                    <?=$val['real_name']?> <?=$val['phone']?><img width="25px" src="<?=asset("images/bj3.png")?>" /><br/>
                    保证金:<?=(empty($master['fund'][$i]['assure_fund'])) ? '<font color="#999">暂未缴纳</font>' : $master['fund'][$i]['assure_fund'] ?><br/>
                    信誉:<?=$master['statistic'][$i]['__score_icon']?><br/>
                    <a href="#">承诺6项服务</a>
                </div>
            </div>

            <div class="ybj-4 col-md-4">
                总单数：<span class="ybj-4-1"><?=$master['statistic'][$i]['order_count']?>单</span><br/>
                总评分：<span class="ybj-4-1"><?=$master['statistic'][$i]['score_sum']?>分</span><br/>
                好评率：<span class="ybj-4-1"><?=$master['statistic'][$i]['good_rat']?></span><br/>
                投诉记录：<span class="ybj-4-2"><?=$master['statistic'][$i]['complain_count']?>次</span><br/>
                <a href="#">累计评价(<?=$master['statistic'][$i]['evaluate_count']?>)</a>
            </div>

            <?php if($val['status']==0){ ?>
            <div class="ybj-5 col-md-4">
                报价：<font color="#f00"><?=$val['price']?>元</font><br/><br/>
                <a href="#" class="hired-master" rel="<?=$val['real_name']?>（<?=$val['phone']?>）" data="<?=$val['id']?>">雇佣他</a>
            </div>
            <?php }else if($val['status']==1){ $hired_flag=$val['id']; ?>
            <div class="ybj-55 col-md-4">
                报价：<font color="#f00"><?=$val['price']?>元</font><br/>
                <a >已雇佣</a>
            </div>
            <?php }else if($val['status']==2){ ?>
            <div class="ybj-55 col-md-4">
                报价：<font color="#f00"><?=$val['price']?>元</font><br/>
                <a>成功雇佣</a><br/>
                <a href="<?=site_url('complain/add/'.$order_id)?>">投诉师傅</a>
            </div>
            <?php }else if($val['status']==3){ ?>
            <div class="ybj-55 col-md-4">
                报价：<font color="#f00"><?=$val['price']?>元</font><br/>
                <a>未被雇佣</a>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<!--hired master-->
<div class="hire-master-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2-hire">
        <div class="tt-2-1">雇佣师傅 <img class="close-pop" src="<?=asset("images/02418.png")?>" style="cursor:pointer;" /></div>
        <div class="tt-2-22">你确定雇佣<font color="#FFCC66">  </font>为你提供服务吗？</div>
        <div class="tt-2-4">提示：雇佣师傅后3天未付款将自动关闭！</div>
        <div class="tt-2-3"><a href="#" class="hire-confirm">雇佣付款</a><a class="on cancel-pop" href="#">取消</a></div>
    </div>
</div>

<!--rehired master-->
<div class="rehire-master-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2-hire">
        <div class="tt-2-1">重新雇佣师傅 <img class="close-pop-re" src="<?=asset("images/02418.png")?>" style="cursor:pointer;" /></div>
        <div class="tt-2-22">你确定雇佣<font color="#FFCC66">  </font>为你提供服务吗？</div>
        <div class="tt-2-4">提示：雇佣师傅后3天未付款将自动关闭！</div>
        <div class="tt-2-3"><a href="#" class="hire-confirm">雇佣付款</a><a class="on cancel-pop-re" href="#">取消</a></div>
    </div>
</div>


<script type="text/javascript">
    var $hiredFlag = <?=$hired_flag?>; 
    var $masterId = 0;
    var $hiredBox = $(".hire-master-pop");
    var $rehiredBox = $(".rehire-master-pop");

    $(".hired-master").click(function(){
        var msg = $(this).attr('rel');
        $masterId = $(this).attr('data');
        if($hiredFlag == 0){
            $hiredBox.find('font').html(msg);
            $hiredBox.show();
        }else{
            $rehiredBox.find('font').html(msg);
            $rehiredBox.show();
        }
    });

    //submit
    $(".hire-confirm").click(function(){
        $.ajax({
            type:"get",
            url:"<?=site_url('order/hire_master/'.$order_id)?>" + "/" + $masterId + "/" + $hiredFlag,
            success:function(msg){
                if(msg.status == 0){
                    window.location.href = "<?=site_url('order/order_pay/'.$order_id)?>";
                }else{
                    alert(msg.error);
                }
            }
        });
    })

    $(".close-pop, .cancel-pop").click(function(){
        $hiredBox.hide();
    });

    $(".close-pop-re, .cancel-pop-re").click(function(){
        $rehiredBox.hide();
    });

    $(".ybj-1").click(function(){
        var master_id = $(this).attr('rel');
        window.location.href = "<?=site_url('order/master/introduce')?>" + "/" + master_id;
    });

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

