<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="yhzc">
	<div class="container">
    	<div class="yhzc-1">
    		<img src="<?=asset("images/51334.png")?>" />下单用户注册中心
    		<span class="yhzc-1-1"><a href="#">我是师傅，点击这里注册 ></a></span>
    	</div>
        
        <div class="yhzc-2">
        <form id="register-fm" action="<?=site_url('auth/register_submit')?>" method="post">
        	<li class="yhzc-2-1">手机号码：
        		<input name="phone" type="text" placeholder="请输入手机号码" required pattern="^1[3,5,8]\d{9}$">
        		<a id="reg-send-sms" href="javascript:void(0);">发送验证码</a>
        	</li>
            <li class="yhzc-2-1">&nbsp;&nbsp;&nbsp;&nbsp;验证码：
            	<input name="code" type="text"  placeholder="请输入6位验证码" required>
            </li>
            <li class="yhzc-2-1">设置密码：
            	<input name="password" type="password"  placeholder="请设置登录密码" required>
            </li>
            <li class="yhzc-2-1">确认密码：
            	<input name="passconf" type="password"  placeholder="请再次确认密码" required>
            </li>	
            <li class="yhzc-2-1">用户名字：
            	<input name="name" type="text"  placeholder="请输入公司简称" required>
            </li>
            <li class="yhzc-2-1">注册类型：
            	<select name="type" required>
            		<option value="">请选择你注册的类型</option>
            		<option value="1">家具电商</option>
            		<option value="2">物流公司</option>
            		<option value="3">个人用户</option>
            	</select>
            </li>
        	<li class="yhzc-2-2">
        		<input name="agree_" type="checkbox" checked="checked">
        			请我以阅读并同意
        			<a href="#">《乐帮到家用户协议》</a>
        	</li>
            <li class="yhzc-2-3">
            	<button type="submit">注册</button>
            </li>
        </form> 
        </div>
        <div class="yhzc-3">
        	<img src="<?=asset("images/3704.png")?>" />
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
	var check_captcha_url = "<?=site_url('auth/send_sms')?>";
	var $tipBox = $("#tips-box");
	var $smsBox = $("#sms-box");
	var curSmsCount;
	var smsCount = 60;
	var $smsBtn = $("#reg-send-sms");
	var smsFlag = true;

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

	function check_phone(){
		var partten = /^1[3,5,8]\d{9}$/;
		var phone = $("input[name='phone']").val();
		if(partten.test(phone)){
			return true;
		}else{
			return false;
		}
	}

	$("#reg-send-sms").click(function(){
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
        		smsFlag = false;
		        curSmsCount = smsCount;
		        $.ajax({
		            type:'post',
		            url:check_captcha_url,
		            data:{phone:phone, captcha:code},
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

	//register form submit
	$("#register-fm").submit(function(){
		var password = $("input[name='password']").val();
		var passconf = $("input[name='passconf']").val();
		var url = "<?=site_url('main/index')?>" + '/login';
		if(password == passconf){
			$.ajax({
				type:"post",
				url:$("#register-fm").attr("action"),
				data:$("#register-fm").serialize(),
				success:function(msg){
					if(msg.status == 0){
						showTip('<h4>注册成功！</h4>', url);
					}else{
						showTip('<h4>'+msg.error+'</h4>');
					}
				}
			});
		}else{
			showTip('<h4>两次密码不一致！</h4>');
		}
		return false;
	})

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

	//关闭按钮
	$(".close-tips").click(function(){
		$(".tips-info").hide();
	});

	$("#confirm-tips").click(function(){
		$tipBox.hide();
	});

</script>