<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">钱包密码</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

 		<div class="col-md-9">
 	    <div class="bjck">
        <div class="bjck-1">
          <span class="bjck-1-1"><a href="javascript:void(0);">设置钱包密码</a></span>
        </div>
              
        <div class="tjpj-13" style="margin-bottom:15px;" >
          <font><b>温馨提示：你还未设置钱包密码，请尽快设置，以保障付款安全</b></font>
        </div>

        <form id="setpaypass_fm" action="<?=site_url('ewallet/set_paypass_submit')?>" method="post">
          <div class="qbmm-1">
            已绑定手机：<?=$phone?><br/>
            手机验证码：<input name="code" type="text" required>
            <a href="javascript:void(0);" id="set-send-sms">发送</a><br/>
            &nbsp;&nbsp; 钱包密码：<input name="password" type="password" required><br/>
            &nbsp;&nbsp; 确认密码：<input name="passconf" type="password" required><br/>  
          </div>
          <div class="qbmm-1-1"><button type="sbumit">确定</button></div>
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
    var check_captcha_url = "<?=site_url('auth/send_sms/7')?>";
    var $tipBox = $("#tips-box");
    var $smsBox = $("#sms-box");
    var smsCount = 60;
    var $smsBtn = $("#set-send-sms");
    var smsFlag = true;

    $("#set-send-sms").click(function(){
      if(smsFlag){
        $smsBox.show();
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
        var code = $("#cap-code").val();
        if(code == ''){
            $("#yzm-talk").text('请输入验证码！');
        }else{
            if(smsFlag){
                smsFlag = false;
                curSmsCount = smsCount;
                $.ajax({
                    type:'post',
                    url:check_captcha_url,
                    data:{captcha:code},
                    success:function(msg){
                      if(msg.status == 0){
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

    $("#setpaypass_fm").submit(function(){
        $.ajax({
            type:'post',
            url:$("#setpaypass_fm").attr('action'),
            data:$("#setpaypass_fm").serialize(),
            success:function(msg){
                if(msg.status == 0){
                    window.location.reload();
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
            $smsBtn.removeAttr("disabled").html("重新获取").css({'background':'#06F','color':'#fff'}); 
        }else{
            $smsBtn.html(curSmsCount + "s");
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



