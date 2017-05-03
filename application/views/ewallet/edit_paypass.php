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
 			<div class="bjck" >
        	<div class="bjck-1">
            <span class="bjck-1-1">
              <a href="javascript:void(0);">修改密码</a>
            </span>
          </div>
          
          <form id="changepwd-fm" action="<?=site_url('ewallet/update_paypass_submit')?>" method="post" >    
          <div class="qbmm-1">
            &nbsp;&nbsp;  &nbsp;&nbsp;  旧密码：<input name="old_pass" type="password" required><br/>
            新钱包密码：<input name="password" type="password" required><br/>
            确认新密码：<input name="passconf" type="password" required><br/>
          </div>

          <div class="qbmm-1-1">
            <button type="submit">确定修改</button>
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

<script type="text/javascript">
  var $tipBox = $("#tips-box");

  $("#changepwd-fm").submit(function(){
      $.ajax({
        type:'post',
        url:$("#changepwd-fm").attr('action'),
        data:$("#changepwd-fm").serialize(),
        success:function(msg){
          if(msg.status == 0){
            var url = "<?=site_url('ewallet/set_paypass')?>";
            showTip('<h4>支付密码修改成功</h4>', url);
          }else{
            showTip('<h4>'+msg.error+'</h4>');
          }
        }
      });
      return false;
  });

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

