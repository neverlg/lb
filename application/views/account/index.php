<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">基本资料</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">基本资料</a></span>
        		</div>
            	<div class="jbzl-1">
            		<div class="jbzl-lef col-md-8">
                		用户名：<?=$info['me_username']?> <br/>
                		注册类型：<?=$info['me_category']?> <br/>

                        <?php if(!empty($info['me_truename'])){ ?>
                		真实姓名：<?=$info['me_truename']?> <br/>
                        <?php } ?>

                		手机号码：<?=$info['me_phone']?> &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=site_url('account/change_phone')?>">修改</a><br/>

                        <?php if(!empty($info['me_local_area'])){ ?>
                		所在地区：<?=$info['me_local_area']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_local_address'])){ ?>
                		详细地址：<?=$info['me_local_address']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_phoneps'])){ ?>
                		备用号码：<?=$info['me_phoneps']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_qq'])){ ?>
                		QQ号码：<?=$info['me_qq']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_tb_name'])){ ?>
                		淘宝旺旺ID：<?=$info['me_tb_name']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_tb_url'])){ ?>
                		淘宝店铺网址：<?=$info['me_tb_url']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_jd_name'])){ ?>
                        京东店铺ID：<?=$info['me_jd_name']?> <br/>
                        <?php } ?>

                        <?php if(!empty($info['me_jd_url'])){ ?>
                        京东店铺网址：<?=$info['me_jd_url']?> <br/>
                        <?php } ?>

                        <br/>
                		<div class="jbzl-lef-1">
                			<a href="<?=site_url('account/edit')?>">编辑</a>
                		</div>
                	</div>
                	<div class="jbzl-r col-md-4">
                  		<div id="avatar-index">
							<img id="imghead" border="0" src="<?=empty($info['me_headimg']) ? asset("images/ht7.png") : $info['me_headimg'] ?>" width="100" height="100" >
 						</div>         
						&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=site_url('account/avatar')?>">修改头像</a>
                	</div>
            	</div>
            </div>
		</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>
