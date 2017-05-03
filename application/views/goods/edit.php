<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
		<a href="javascript:void(0);">报价订单管理</a>》
        <a href="javascript:void(0);">货品仓库</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<form id="editgoods-fm" action="<?=site_url('goods/edit_submit/'.$go_id)?>" method="post">
    		<div class="bjck-eg">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>货品仓库</a></span>
        			<span class="bjck-1-2"><a href="javascript:history.go(-1);">返回货品列表》</a></span>
        		</div>
        		
        		<div class="bjck-t">
        			<div class="col-md-4 bjck-t1">
        				<img src="<?=$goods['go_img_full']?>" />
        				<input name='img' type='hidden' value="<?=$goods['go_img']?>">
        			</div>
        
        			<div class="col-md-8 bjck-t2">
        				<font color="#f00">*</font>货品类目：
        				<select value="<?=$goods['go_type']?>" name="type">
        					<option value="1" <?=($goods['go_type']==1)?"selected='selected'":""?> >柜类</option>
        					<option value="2" <?=($goods['go_type']==2)?"selected='selected'":""?> >床类</option>
        					<option value="3" <?=($goods['go_type']==3)?"selected='selected'":""?> >床垫类</option>
        					<option value="4" <?=($goods['go_type']==4)?"selected='selected'":""?> >桌类</option>
        					<option value="5" <?=($goods['go_type']==5)?"selected='selected'":""?> >茶几类</option>
        					<option value="6" <?=($goods['go_type']==6)?"selected='selected'":""?> >架类</option>
        					<option value="7" <?=($goods['go_type']==7)?"selected='selected'":""?> >沙发类</option>
        					<option value="8" <?=($goods['go_type']==8)?"selected='selected'":""?> >椅类</option>
        					<option value="9" <?=($goods['go_type']==9)?"selected='selected'":""?> >屏风隔断</option>
        					<option value="10" <?=($goods['go_type']==10)?"selected='selected'":""?> >办公类</option>
        					<option value="12" <?=($goods['go_type']==12)?"selected='selected'":""?> >坐具类</option>
        				</select><br/>
            			<font color="#f00">*</font>货品名称：
            			<input name="name" type="text" value="<?=$goods['go_name']?>" required>
        			</div>
        		</div>
        	</div>
          	<div class="sctp-1-1"> 
          		<span class="sctp-1-2" ><button type="submit">确定</button></span>
          		<span class="sctp-1-3" ><button href="javascript:history.go(-1);">取消</button></span>
            </div>
            </form>
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

	//upload no

	//submit
	$("#editgoods-fm").submit(function(){
		$.ajax({
			type:'post',
			url:$("#editgoods-fm").attr('action'),
			data:$("#editgoods-fm").serialize(),
			success:function(msg){
				if(msg.status == 0){
					var url = "<?=site_url('goods/index/'.$goods['go_priced_type'].'/'.$goods['go_type'])?>";
					showTip('<h4>修改成功</h4>', url);
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

  	$("#confirm-tips").click(function(){
    	$tipBox.hide();
  	});

</script>
