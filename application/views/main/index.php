<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>
<?php require 'application/views/basic/top1.php'; ?>

<div class="banner banner_1">
	<div class="index_baojia">
        <p class="p_1"><img src="<?=asset("images/banner_logo.png")?>"></p>
		<a href="<?=site_url('order/baojia')?>">发布订单获取多个师傅报价<img src="<?=asset("images/banner_jt.png")?>"></a>
        <?php foreach ($newest as $row):?>
            <div class="gundong"><?=mb_substr($row['me_username'],0,1)?>*发布订单(<?=$row['service_type']?>)<em><?=$row['customer_area']?></em><?=$row['before_time']?></div>
        <?php endforeach;?>
	</div>

</div>


<div class="container">
	<div class="col-md-4 sy-t-1">
        <img src="<?=asset("images/syt2.png")?>" /><br/>
        <span class="sy-jd">在线接单师傅</span><br/>
        <span class="sy-jd-1"><?=$total['master']?>个</span>
        
    </div>
    <div class="col-md-4 sy-t-1">
        <img src="<?=asset("images/syt1.png")?>" /><br/>
        <span class="sy-jd">在线下单用户</span><br/>
        <span class="sy-jd-1"><?=$total['merchant']?>个</span>
        
    </div>
    <div class="col-md-4 sy-t-1">
        <img src="<?=asset("images/syt3.png")?>" /><br/>
        <span class="sy-jd">服务全国市/区/县</span><br/>
        <span class="sy-jd-1"><?=$total['city']?>个</span>
        
    </div>

</div>

<div class="sy-xd">
	<div class="container">
    	<div class="sy-xd-1">用户下单流程</div>
        <div class="sy-s">
            <img src="<?=asset("images/58.png")?>" />
            <span class="sy-s-1">用户发布订单</span>
            <span class="sy-s-2">用户登录电脑端账号填写订单信息，一键发布订单获取多个师傅报价。</span>
        
        </div>
        <div class="sy-s1"><img src="<?=asset("images/syl-6.png")?>" /></div>
        <div class="sy-s">
           <img src="<?=asset("images/59.png")?>" />
           <span class="sy-s-1">多个师傅报价</span>
           <span class="sy-s-2">系统自动匹配师傅推送订单，多个师傅在手机端根据订单信息做服务报价。</span>
        
        </div>
         <div class="sy-s1"><img src="<?=asset("images/syl-6.png")?>" /></div>
        <div class="sy-s">
            <img src="<?=asset("images/60.png")?>" />
            <span class="sy-s-1">雇佣托管费用</span>
            <span class="sy-s-2">下单用户挑选其中一个师傅进行雇佣，并托管服务费用。</span>
        
        </div>
         <div class="sy-s1"><img src="<?=asset("images/syl-6.png")?>" /></div>
          <div class="sy-s">
            <img src="<?=asset("images/61.png")?>" />
            <span class="sy-s-1">师傅上门服务</span>
            <span class="sy-s-2">成功被雇佣的师傅根据订订单信息进行预约服务，完成服务后拍照上传系统。</span>
        
        </div>
          <div class="sy-s1"><img src="<?=asset("images/syl-6.png")?>" /></div>
         <div class="sy-s">
            <img src="<?=asset("images/62.png")?>" />
            <span class="sy-s-1">用户验收评价</span>
            <span class="sy-s-2">下单用户验收确认并放款给师傅，对师傅进行服务评价评分。</span>
        
        </div>
    
    </div>


</div>
<div class="sy-ly">
	<div class="container">
    	<div class="sy-xd-1">选择我们的理由</div>
      <div class="sy-ss">
            <img src="<?=asset("images/27.png")?>" />
            <span class="sy-s-1">找师傅更便捷</span>
            <span class="sy-s-2">一键发布订单，多个师傅即刻在线手机报价，用户不用再逐个问价才能确定服务，直接对接师傅沟通更便捷。</span>
        
        </div>
        <div class="sy-ss">
            <img src="<?=asset("images/28.png")?>" />
            <span class="sy-s-1">诚信服务看得见</span>
         <span class="sy-s-2">每个报价师傅的诚信质保金，服务评价评分，最近是否受到投诉都可以一目了然，用户选择雇佣师傅更放心。</span>
        
        </div>
        <div class="sy-ss">
           <img src="<?=asset("images/29.png")?>" />
           <span class="sy-s-1">提供交易支付担保</span>
           <span class="sy-s-2">下单用户雇佣师傅的服务费用，平台提供中间支付交易担保，让双方的权益都有保障。</span>
        
        </div>
        <div class="sy-ss">
            <img src="<?=asset("images/30.png")?>" />
           <span class="sy-s-1">货品损失先赔付</span>
          <span class="sy-s-2">用户在平台下单付款后，师傅在服务过程中由于师傅个人的原因导致货品损失不能维修或货品需要返货的，平台实行先行赔付。</span>
        
        </div>
        <div class="sy-ss">
            <img src="<?=asset("images/31.png")?>" />
            <span class="sy-s-1">服务已覆盖全国</span>
            <span class="sy-s-2">入驻平台的师傅可以服务到的区域，目前已全部覆盖全国长途物流能够到达的区域，实现服务覆盖全国各市/区/县。</span>
        
        </div>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<?php if($show_login){ ?>
<!-- 登陆弹框等 -->
<div class="tips-info">
    <div class="lb_mask"></div>
    <div class="tcdl">
        <form id="login-fm" action="<?=site_url('auth/login_submit')?>" method="post">
        <div class="tcdl-1">
            <img id="close-fm" style="cursor:pointer;" src="<?=asset("images/02418.png")?>" />
        </div>   
        <div class="tcdl-2">
            <img src="<?=asset("images/51.png")?>" /><br/>
            下单用户登录
        </div>
        <div class="tcdl-3">
            <input type="text" name="username" placeholder="用户名/手机号" required><br/>
            <input type="password" name="password" placeholder="密码登录" required>
            <input type="text" name="captcha" placeholder="图形验证码" required>
            <label id="login-code"><?=$__captcha?></label>
        </div>
        <div class="tcdl-4">
          <span id="login-tips"></span>
          <a href="<?=site_url('auth/forget_password')?>">忘记密码？</a></div>
        <div class="tcdl-5"><button type="submit">登录</button></div>
        <div class="tcdl-6">你还没有乐帮账号？<a href="<?=site_url('auth/register')?>">立即注册></a></div>
        </form>
    </div>
</div>

<script type="text/javascript">
  $("#close-fm").click(function(){
    $(".tips-info").hide();
  });

  $("#login-code").on('click', function(){
    $.ajax({
      type:'get',
      url:"<?=site_url('auth/user_captcha')?>",
      success:function(msg){
        if(msg.status == 0){
          $("input[name='captcha']").val();
          $("#login-code").html(msg.data);
        }
      }
    });
  });

  $("#login-fm").submit(function(){
    $.ajax({
      type:"post",
      url:$("#login-fm").attr('action'),
      data:$("#login-fm").serialize(),
      success:function(msg){
        if(msg.status == 0){
          window.location.href = "<?=site_url('order/index')?>";
        }else{
          $("#login-tips").text(msg.error);
          $("#login-code").trigger("click"); 
        }
      }
    });
    return false;
  });
</script>
<?php } ?>
