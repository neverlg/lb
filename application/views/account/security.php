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
                    <span class="bjck-1-1"><a href="javascript:void(0);">安全设置</a></span>
                </div>
              
                <div class="grtx-3">
                    <div class="col-md-3" style=" text-align:right;">
                        <img src="<?=asset("images/819.png")?>" />
                    </div>
                    <div class="col-md-6">手机绑定：<?=$phone?><br/>
                        <font size="2">绑定后，可用于快速找回密码，介绍余额提醒！</font>
                    </div>
                    <div class="col-md-3 grtx-2-2">
                        <a href="<?=site_url('account/change_phone')?>">修改</a>
                    </div>
                </div>

                <div class="grtx-3">
                    <div class="col-md-3" style=" text-align:right;">
                        <img src="<?=asset("images/2840.png")?>" />
                    </div>
                    <div class="col-md-6">登录密码<br/>
                        <font size="2">登录网址的密码，建议定期修改以保护账户的安全！</font>
                    </div>
                    <div class="col-md-3 grtx-2-2">
                        <a href="<?=site_url('account/change_password')?>">修改</a>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>
