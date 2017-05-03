<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">安全设置</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
                <div class="bjck-1">
                    <span class="bjck-1-1"><a href="javascript:void(0);">登录密码</a></span>
                </div>
                
                <form id="changepwd-fm" action="<?=site_url('account/new_password_save')?>" method="post">
                <div class="qbmm-1" style="padding-left:5%;">
                    当前密码：<input name="origin_password" type="password" required><br/>&nbsp;&nbsp;    
                    新密码：<input name="password" type="password" required><br/>
                    确认密码：<input name="passconf" type="password" required><br/> 
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

<script type="text/javascript">
    var $tipBox = $("#tips-box");

    $("#changepwd-fm").submit(function(){
        var password = $("input[name='password']").val();
        var passconf = $("input[name='passconf']").val();
        if(password != passconf){
            showTip("<h4>两次密码不一致</h4>");
        }else{
            $.ajax({
                type:"post",
                url:$("#changepwd-fm").attr('action'),
                data:$("#changepwd-fm").serialize(),
                success:function(msg){
                    if(msg.status == 0){
                        var url = "<?=site_url('main/index/login')?>";
                        showTip("<h4>密码修改成功</h4>", url);
                    }else{
                        var html = '<h4>'+msg.error+'</h4>';
                        showTip(html);
                    }
                }
            });
        }
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

    $("#confirm-tips").click(function(){
        $tipBox.hide();
    });
</script>
