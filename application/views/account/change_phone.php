<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">安全设置</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
                <div class="bjck-1">
                    <span class="bjck-1-1"><a href="javascript:void(0);">手机修改</a></span>
                </div>
                
                <form id="changephone-fm" action="<?=site_url('account/new_phone_save')?>" method="post">
                <div class="qbmm-1">
                    原手机号：<?=$phone?><br/>
                    新手机号：<input name="phone" type="text" required pattern="^1[3,5,8]\d{9}$">
                    <a id="change-send-sms" href="javascript:void(0);">发送</a><br/>
                    &nbsp;&nbsp; 验证码：<input name="code" type="text" required><br/>  
                </div>
                <div class="qbmm-1-1">
                    <button type="submit">确定</button>
                </div>
                </form>

            </div>
		</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<!--消息提示-->
<div class="tips-info" id="tips-box" style="display:none;">
  <div class="lb_mask"></div>
  <div class="tips-msg">
        <div class="tt-2-1">温馨提示： <img src="<?=asset("images/02418.png")?>" class="close-tips" /></div>
        <div class="tt-2-2" id="tips-text"></div>
        <div class="tt-2-8"><button id="confirm-tips">确定</button></div>
    </div>
</div>

<!--验证码弹框-->
<div class="tips-info" id="sms-box" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tips-msg">
        <div class="tt-2-1">温馨提示： <img src="<?=asset("images/02418.png")?>" class="close-tips" /></div>
        <li class="yhzc-5-1" id="captcha-box"><?=$__captcha_img?></li>
        <li class="yhzc-5-1">
            验证码：<input type='text' id="cap-code" />
            <span id="yzm-talk"></span>
        </li>
        <div class="tt-2-8"><button id="confirm-sms">确定</button></div>
    </div>
</div>

<script type="text/javascript">
    var get_captcha_url = "<?=site_url('auth/user_captcha')?>";
    var check_captcha_url = "<?=site_url('auth/send_sms/2')?>";
    var $tipBox = $("#tips-box");
    var $smsBox = $("#sms-box");
    var smsCount = 60;
    var $smsBtn = $("#change-send-sms");
    var smsFlag = true;

    $("#change-send-sms").click(function(){
        if(!smsFlag){
            return;
        }
        if(check_phone()){
            $smsBox.show();
        }else{
            showTip('<h4>手机号码格式错误</h4>');
        }
    });

    //get captcha
    function get_captcha(){
        $.ajax({
        type:'get',
        url:get_captcha_url,
        success:function(msg){
          if(msg.status == 0){
              //点击更换验证码
              $("#captcha-box").html(msg.data);
          }else{
              $("#yzm-talk").text(msg.error);
          }
        }
      });
    }

    //change captcha
    $("#captcha-box").click(function(){
        get_captcha();
    });

    //check captcha
    $("#confirm-sms").click(function(){
        var phone = $("input[name='phone']").val();
        var code = $("#cap-code").val();
        if(code == ''){
            $("#yzm-talk").text('请输入验证码！');
        }else{
            if(smsFlag){
                curSmsCount = smsCount;
                $.ajax({
                    type:'post',
                    url:check_captcha_url,
                    data:{phone:phone, captcha:code},
                    success:function(msg){
                      if(msg.status == 0){
                        smsFlag = false;
                        $smsBox.hide();
                        //设置倒计时
                        setSmsCodeBtn();
                      }else{
                        $("#yzm-talk").text(msg.error);
                        get_captcha();
                      }
                    }
                });
            }
        }
    });

    $("#changephone-fm").submit(function(){
        $.ajax({
            type:'post',
            url:$("#changephone-fm").attr('action'),
            data:$("#changephone-fm").serialize(),
            success:function(msg){
                if(msg.status == 0){
                    var url = "<?=site_url('account/security')?>";
                    showTip("<h4>手机更改成功</h4>", url);
                }else{
                    var html = '<h4>'+msg.error+'</h4>';
                    showTip(html);
                }
            }
        });
        return false;
    });

    function setSmsCodeBtn(){
        $smsBtn.html(curSmsCount + "s");
        smsTimer = window.setInterval(smsCountdown, 1000); //启动计时器，1秒执行一次
        $smsBtn.removeAttr("onclick").css({'background':'#dadada'});
    }

    // 短信验证码倒计时
    function smsCountdown(){
        curSmsCount--;  
        if(curSmsCount == 0){  
            smsFlag = true;       
            window.clearInterval(smsTimer); // 停止计时器  
            $smsBtn.removeAttr("disabled").html("重新获取").css({'background':'#06F'}); 
        }else{
            $smsBtn.html(curSmsCount + "s");
        }  
    }

    function check_phone(){
        var partten = /^1[3,5,8]\d{9}$/;
        var phone = $("input[name='phone']").val();
        if(partten.test(phone)){
            return true;
        }else{
            return false;
        }
    }
    
    function showTip(msg, url){
        $("#tips-text").html(msg);
        if(url){
            $tipBox.show().delay(2000).hide(0);
            setTimeout(function(){
                window.location.href = url;
            },1000);
        }else{
            $tipBox.show().delay(2000).hide(0);
        }
    }

    //关闭按钮
    $(".close-tips").click(function(){
        $(".tips-info").hide();
    });

    $("#confirm-tips").click(function(){
        $tipBox.hide();
    });
</script>
