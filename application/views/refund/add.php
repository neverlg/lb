<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<link rel="stylesheet" href="<?=asset("kit/bootstrap/css/bootstrap-datetimepicker.min.css")?>" type="text/css">
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.min.js")?>" ></script>
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.zh-CN.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
    <a href="javascript:void(0);">退款管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>退款管理</a></span>
        		</div>
              	<div class="tjpj-13" style="margin-bottom:15px;" >
              		<font >
              			<b> 温馨提示：退款钱请务必与师傅沟通协商好退款的金额，以免影响退款处理效率。</b>
              		</font>
              	</div>
            	<div class="pjgl-2-1">
                	&nbsp;&nbsp;订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;&nbsp;&nbsp;
                	订单金额：<?=$order['merchant_price']?>元  &nbsp;&nbsp;&nbsp;&nbsp;
                	支付方式：<?=$order['pay_type']?>
                </div>
            
             	<div class="tjpj-12">
             		<form id="refund-fm" action="<?=site_url('refund/add_submit/'.$order_id)?>" method="post">
              		<div class="tjpj-1">
            			<b style="float:left;"><font color="#f00">*</font>退款类型：</b>
            			<input id="refund-all" name="type" type="radio" value="1" required>&nbsp;
            			全额退款(服务终止)&nbsp;&nbsp;&nbsp;&nbsp;
            			<input id="refund-some" name="type" type="radio" value="2" required>&nbsp;部分退款
            		</div>
            		<div class="tjpj-1">
            			<b style="float:left;"><font color="#f00">*</font>
            			申请金额：</b><input name="fee" type="text" required>&nbsp;元
            		</div>
            		<div class="tjpj-1">
            			<b style="float:left;"><font color="#f00">*</font>退款方式：</b>
            			<input name="method" type="radio" value="1" required>&nbsp;
            			我的钱包&nbsp;&nbsp;&nbsp;&nbsp;
            			<input name="method" type="radio" value="2" required>&nbsp;原路返回
            		</div>
             		<div class="tjpj-1">
            			<b style="float:left;"><font color="#f00">*</font>退款原因：</b>
            			<textarea name="reason" cols="50" rows="4" placeholder="请填写申请退款原因（100字以内）" required></textarea>
            		</div>
               		<div class="tjpj-13" style=" padding-left:12%;"> 
               			<button type="submit">提交申请退款</button>
               		</div>
               		</form>
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
	var $full_fee = <?=$order['merchant_price']?>;

	$("#refund-all").click(function(){
		$("input[name='fee']").val($full_fee);
	});

	$("#refund-some").click(function(){
		$("input[name='fee']").val('');
	});

	$("#refund-fm").submit(function(){
		$.ajax({
			type:"post",
			url:$("#refund-fm").attr('action'),
			data:$("#refund-fm").serialize(),
			success:function(msg){
				if(msg.status == 0){
					var url = "<?=site_url('refund/detail/'.$order_id)?>";
					showTip('<h4>退款申请提交成功</h4>', url);
				}else{
					showTip('<h4>' + msg.error + '</h4>');
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