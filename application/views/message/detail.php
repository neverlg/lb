<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">我的消息</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

		<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">我的消息</a></span>
        			<span class="wdxx-1"><a href="javascript:history.back();">返回消息列表》</a></span>
        		</div>
            
            	<div class="wdxx-2">
            		<?=$detail['__content']?>
            	</div>
        	</div>
    	</div>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>