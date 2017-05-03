<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">评价管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>评价管理</a></span>
        		</div>

            	<div class="pjgl-1">
            		<b>筛选：</b>
            		<input name="score" type="radio" value="0" <?=($score==0) ? "checked='checked'" : "" ?> >全部
            		<input name="score" type="radio" value="1" <?=($score==1) ? "checked='checked'" : "" ?> ><img src="<?=asset("images/4159.png")?>" width='20'/>好评
            		<input name="score" type="radio" value="2" <?=($score==2) ? "checked='checked'" : "" ?> ><img src="<?=asset("images/33.png")?>" width='20'/>中评
            		<input name="score" type="radio" value="3" <?=($score==3) ? "checked='checked'" : "" ?> ><img src="<?=asset("images/250.png")?>" width='20'/>差评 
            		<span class="pjgl-1-1">共<font color="#f00"><?=$total?>条</font>记录</span>
            	</div>

            	<?php foreach($list as $val){ ?>
            	<div class="pjgl-2">
            		<div class="pjgl-2-1">
	                	订单编号：<font color="#2bb0eb"><?=$val['order_number']?></font>  &nbsp;&nbsp;
	                	服务类型：<?=$val['service_type']?>  &nbsp;&nbsp;
	                	师傅名字：<?=$val['real_name']?>（<?=$val['phone']?>）&nbsp;&nbsp;&nbsp;&nbsp;   
	                	<?=$val['oe_add_time']?>
                	</div>
	                <div class="pjgl-2-2">
	                	<img src="<?=$val['icon']?>" width='20'/><?=$val['oe_score_text']?>&nbsp;&nbsp; | &nbsp;&nbsp;
	                	服务质量<font color="#f00"> <?=$val['oe_quality']?>分</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	                	服务态度 <font color="#f00"> <?=$val['oe_attitude']?>分</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	                	服务时效 <font color="#f00"> <?=$val['oe_ontime']?>分</font> 
	                </div>
	                <?php if(!empty($val['oe_content']) && $val['oe_type']==0){ ?>
	                <div class="pjgl-2-2">
	                	我的评价：<?=$val['oe_content']?>
	                </div>
	                <?php }else if($val['oe_type']==1){ ?>
	                <div class="pjgl-2-2">
                 		我的评价：<font color="#999"><?=$val['oe_content']?></font> 
                 	</div> 
	                <?php } ?>

	                <?php if(!empty($val['oe_response']) && $val['oe_type']==0){ ?>
	                <div class="pjgl-2-3">
	                	师傅解释：<?=$val['oe_response']?> 
	                </div>
	                <?php } ?>
            	</div>
            	<?php } ?>
  	
            	<div class="htfy" style="margin-top:25px;">
        			<?=$__pagination_url?>
        		</div>
        	</div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
	$("input[name='score']").change(function(){
		var score = $(this).val();
		url = "<?=site_url('evaluate/index')?>" + "/" + score;
		window.location.href = url;
	});
</script>
