<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
		<a href="<?=site_url('order/baojia_index')?>">报价订单管理</a>》
        <a href="javascript:void(0);">货品仓库</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>货品仓库</a></span>
        			<span class="bjck-1-2">
        				<a href="<?=site_url('goods/add/'.$priced_type)?>">
        					<img src="<?=asset("images/s851.png")?>" />
        				</a>
        			</span>
        		</div>
	            <div class="bjck-22">
	        		<div class="col-md-2 bjck-2">
	        			<a <?=($go_type==0) ? "class='on'" : ""?> rel="0">全部(<?=$category_count[0]?>)</a>
	        		</div>
	        		<div class="col-md-2 bjck-2">
	        			<a <?=($go_type==1) ? "class='on'" : ""?> rel="1">柜类(<?=$category_count[1]?>)</a>
	        		</div>
	        		<div class="col-md-2 bjck-2">
	        			<a <?=($go_type==2) ? "class='on'" : ""?> rel="2">床类(<?=$category_count[2]?>)</a>
	        		</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==3) ? "class='on'" : ""?> rel="3">床垫类(<?=$category_count[3]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==4) ? "class='on'" : ""?> rel="4">桌类(<?=$category_count[4]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==5) ? "class='on'" : ""?> rel="5">茶几类(<?=$category_count[5]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==6) ? "class='on'" : ""?> rel="6">架类(<?=$category_count[6]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==7) ? "class='on'" : ""?> rel="7">沙发类(<?=$category_count[7]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==8) ? "class='on'" : ""?> rel="8">椅类(<?=$category_count[8]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==9) ? "class='on'" : ""?> rel="9">屏风隔断(<?=$category_count[9]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==10) ? "class='on'" : ""?> rel="10">办公类(<?=$category_count[10]?>)</a>
	            	</div>
	            	<div class="col-md-2 bjck-2">
	            		<a <?=($go_type==12) ? "class='on'" : ""?> rel="12">坐具类(<?=$category_count[12]?>)</a>
	            	</div>
	      		</div>
        
        		<div class="bjck-3">
        			<?php foreach($list as $val){ ?>
        			<li>
        				<img src="<?=$val['go_img']?>" /><br/>
            			<?=$val['go_name']?><br/>
            			<a href="<?=site_url('goods/edit/'.$val['go_id'])?>">编辑</a>&nbsp;&nbsp;
            			<a href="<?=site_url('goods/del/'.$priced_type.'/'.$go_type.'/'.$val['go_id'])?>">删除</a>
            		</li>
            		<?php } ?>

        		</div>

        		<div class="htfy" style="margin-top:25px;">
        			<?=$__pagination_url?>
        		</div>
        	</div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">

	$(".bjck-2 a").click(function(){
		$(".bjck-2 a").removeClass('on');
		$(this).addClass('on');
		var go_type = $(this).attr('rel');
		window.location.href = "<?=site_url('goods/index/'.$priced_type)?>" + "/" + go_type;
	})

</script>
