<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="banner banner_fuwu">
	<a href="#"><img src="<?=asset("images/banner_jd.jpg")?>" /></a>
</div>

<div class="container" style="margin:100px auto; ">
	<div class="fwfs-1">
    	<div class="col-md-6 fwfs-2">
        	<div class="fwfs-2-3">
            	<div class="fwfs-2-3-1 col-md-2">
            		<img src="<?=asset("images/142750.png")?>" />
            	</div>
                <div class="fwfs-2-3-2 col-md-10">
                	<span class="fwfs-2-3-22">协商定价批量出单</span>
                	<span class="fwfs-2-3-23">用户按照协商好的服务定价在线批量下单，出单效率大幅度提高。</span>
                </div>
            </div>
			<div class="fwfs-2-3">
            	<div class="fwfs-2-3-1 col-md-2">
            		<img src="<?=asset("images/142751.png")?>" />
            	</div>
                <div class="fwfs-2-3-2 col-md-10">
                	<span class="fwfs-2-3-22">提供全程管家式服务</span>
                	<span class="fwfs-2-3-23">由专属客服团队提供全程管家式服务，逐一回访客户，保证服务满意度，无需用户再专门聘请客服跟踪售后订单，省事省时省心。</span>
                </div>
            </div>
        </div>
    	<div class="col-md-6 fwfs-2">
            <div class="fwfs-2-3">
            	<div class="fwfs-2-3-1 col-md-2">
            		<img src="<?=asset("images/142752.png")?>" />
            	</div>
                <div class="fwfs-2-3-2 col-md-10">
                	<span class="fwfs-2-3-22">到货后48小时内完成服务</span>
                	<span class="fwfs-2-3-23">物流通知到货后，专属客服团队按排师傅在48小时内完成订单服务，用户可以在线随时追踪查询服务节点。</span>
                </div>
            </div>
            <div class="fwfs-2-3">
            	<div class="fwfs-2-3-1 col-md-2">
            		<img src="<?=asset("images/142753.png")?>" />
            	</div>
                <div class="fwfs-2-3-2 col-md-10">
                	<span class="fwfs-2-3-22">提供一年质保维修服务</span>
                	<span class="fwfs-2-3-23">提供在运输过程中产生的破损维修服务，以及售后一年的质保维修服务。</span>
                </div>
            </div>
        </div>
    </div>	
</div>

<div class="container_xdfw">
	<div class="container" >
		<div class="xdfw">
			<form id="priced-fm" action="<?=site_url('auth/priced_submit')?>" method="post">
			<h3>填写资料申请开通定价下单服务</h3>
			<p><em>*</em><span>申请姓名：</span><input type="text" name="name" required ></p>
			<p><em>*</em><span>联系手机：</span><input type="text" name="phone" required pattern="^1[3,5,8]\d{9}$" ></p>
			<p><em></em><span>邮箱地址：</span><input type="text" name="email" ></p>
			<p><em></em><span>店铺网址：</span><input type="text" name="shop_url" ></p>
			<button type="submit">确定</button>
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

	$("#priced-fm").submit(function(){
		$.ajax({
			type:"post",
			url:$("#priced-fm").attr('action'),
			data:$("#priced-fm").serialize(),
			success:function(msg){
				if(msg.status == 0){
					var url = "<?=site_url('main/index')?>";
					showTip('<h4>您的申请已收到，我们会尽快处理</h4>', url);
				}else{
					showTip('<h4>'+msg.error+'</h4');
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

	//关闭按钮
	$(".close-tips").click(function(){
		$(".tips-info").hide();
	});

	$("#confirm-tips").click(function(){
		$tipBox.hide();
	});

</script>