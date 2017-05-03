<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<link rel="stylesheet" href="<?=asset("kit/bootstrap/css/bootstrap-datetimepicker.min.css")?>" type="text/css">
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.min.js")?>" ></script>
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.zh-CN.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
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
              
            	<div class="tsgl-1">
            		&nbsp;&nbsp;<b>订单编号：</b>
            		<input id="order_sn" value="<?=$order_sn?>" type="text">&nbsp;&nbsp;
            		<b>处理状态：</b>
            		<select id="refund_status" value="<?=$refund_status?>">
            			<option value="0" <?=($refund_status==0) ? "selected='selected'" : "" ?> >全部状态</option>
            			<option value="1" <?=($refund_status==1) ? "selected='selected'" : "" ?> >待师傅确认中</option>
            			<option value="2" <?=($refund_status==2) ? "selected='selected'" : "" ?> >师傅拒绝退款</option>
            			<option value="3" <?=($refund_status==3) ? "selected='selected'" : "" ?> >退款成功</option>
            			<option value="5" <?=($refund_status==5) ? "selected='selected'" : "" ?> >介入仲裁中</option>
            			<option value="6" <?=($refund_status==6) ? "selected='selected'" : "" ?> >退款关闭</option>
            		</select>
            		&nbsp;&nbsp;<a id="reserch_refund" style="cursor:pointer;">搜索</a>
            	</div>
            
            	<div class="tsgl-2">
            		<table width="100%" border="1">
						<tr class="tsgl-2-1">
						    <td>申请时间</td>
						    <td>订单编号</td>
						    <td>师傅名字</td>
						    <td>交易金额</td>
						    <td>退款金额</td>
						    <td>退款状态</td>
						    <td>详情</td>
						</tr>

						<?php foreach ($list as $key => $val) { ?>
						<tr class="tsgl-2-2">
						    <td><?=$val['refund_time']?></td>
						    <td>
						    	<font color="#16b0f0"><?=$val['order_number']?></font><br/>
						    	<?=$val['service_type']?></td>
						    <td><?=$val['master_name']?></td>
						    <td><?=$val['merchant_price']?></td>
						    <td style="color:#f00"><?=$val['refund_amount']?></td>
						    <td class="tsgl-2-2-1"><?=$val['refund_result_type']?></td>
						    <td class="tsgl-2-2-2">
						    	<a href="<?=site_url("refund/detail").'/'.$val['order_id']?>">查看</a>
						    </td>
						</tr>
						<?php } ?>
					</table>
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
	$('#reserch_refund').click(function(){
		var order_type = <?=$order_type?>;
		var order_sn = $("#order_sn").val();
		if(order_sn == ''){
			order_sn = 0;
		}
		var refund_status = $('#refund_status').val();
		var url = "<?=site_url('refund/index')?>" + "/" + order_type + "/" + order_sn + "/" + refund_status;
		window.location.href = url;
	});

</script>

