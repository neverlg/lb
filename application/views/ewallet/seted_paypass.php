<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">钱包密码</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

 		<div class="col-md-9">
 			<div class="bjck" >
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">钱包密码</a></span>
        		</div>
              
            <div class="qbmm-1" style="text-align:center; padding-left:0px;" >
            		<img src="<?=asset('images/dui18.png')?>" /><br/>
            		<font color="#f00">你已设置钱包密码</font><br/>
            </div>
            <div class="qbmm-1-1" style="text-align:center;">
              		<button style="margin:0px;" id="change_pass">修改密码</button>
            </div>
            <div class="qbmm-1-2" style="text-align:center; ">
              		<a style="margin:0px;"  href="<?=site_url('ewallet/forget_paypass')?>">忘记钱包密码？</a>
            </div>
      </div>
 		</div>  	
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
    $("#change_pass").click(function(){
        window.location.href = "<?=site_url('ewallet/edit_paypass')?>";
    });
</script>

