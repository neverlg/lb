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
        		</div>
            	
            	<?php if($total>0){ ?>
		    	<div class="wdxx-x">
		    		<input name="" type="checkbox" value="" class="del-check">
		    		<a href="javascript:void(0);" class="del-msg">删除所选</a> 
		    		<span class="wdxx-x-1">共<font color="#f00"><?=$total?>条</font>记录</span>
		    	</div>
		    	<?php }else{ ?>
		    	<div class="wdxx-x">
		    		您当前没有消息
		    	</div>
		    	<?php } ?>
		    	
		    	<?php foreach($list as $val){ ?>
		        <div class="bzzx-r-1"> 
		  			<input name="msg_id" type="checkbox" value="<?=$val['id']?>">
		  			<a href="<?=site_url('message/detail/'.$val['id'])?>">
		  				<?php if($val['status']==0){ ?>
		  				<img src="<?=asset("images/164047.png")?>" />
		  				<?php }else if($val['status']==1){ ?>
		  				<img src="<?=asset("images/4105.png")?>" />
		  				<?php } ?>
		  				乐帮到家平台全新上线
		  				<span class="zx-sj">2017-02-08 15:05</span>
		  			</a>
		    	</div>
				<?php } ?>
		        
		        <?php if($total>0){ ?>         
		        <div class="wdxx-x">
		    		<input name="" type="checkbox" value="" class="del-check">
		    		<a href="javascript:void(0);" class="del-msg">删除所选</a> 
		    		<span class="wdxx-x-1">共<font color="#f00"><?=$total?>条</font>记录</span>
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
	$("input[name='msg_id']").change(function(){
		var count = 0;
		$("input[name='msg_id']:checked").each(function(){
			count++;
		});
		if(count > 0){
			$(".del-check").prop('checked', true);
		}else{
			$(".del-check").prop('checked', false);
		}	
	});

	$(".del-msg").click(function(){
		var list = {};
		var i = 0;
		$("input[name='msg_id']:checked").each(function(){
			list["message_id["+i+"]"] = $(this).val();
			i++;
		});
		if(i==0){
			return false;
		}else{
			$.ajax({
				type:"post",
				url:"<?=site_url('message/batch_del')?>",
				data:list,
				success:function(msg){
					if(msg.status == 0){
						window.location.reload();
					}else{
						showTip('<h4>系统忙，请稍后再试</h4>');
					}
				}
			});
		}
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