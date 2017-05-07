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
        <a href="javascript:void(0);">钱包余额</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">钱包余额</a></span>
        		</div>
            	<div class="qby-1">
            		可用余额：<font color="#fdd07b"><?=$balance?>元</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            		<a href="<?=site_url('ewallet/recharge')?>">充值</a>
            	</div> 
            	<div class="tsgl-1">
            		&nbsp;&nbsp;<b>交易时间：</b>
            		<input type="text" readonly class="form_datetime" value="<?=$start_time?>" id="begin_date" placeholder="选择起始时间">
            		&nbsp;&nbsp;至&nbsp;&nbsp;
            		<input type="text" readonly class="form_datetime" value="<?=$end_time?>" id="end_date" placeholder="选择结束时间">
            		<a href="javascript:void(0);" id="search_btn">搜索</a>
            	</div>
            	<div class="tsgl-2">
            		<table width="100%" border="1">
					    <tr class="tsgl-2-1">
						    <td>交易时间</td>
						    <td>订单编号</td>
						    <td>交易类型</td>
						    <td>流水号</td>
						    <td>备注</td>
						    <td>收支(元)</td>
						    <td>钱包余额</td>
					    </tr>
					    <?php foreach ($list as $val) { ?>
					    <tr class="tsgl-2-2">
						    <td><?=$val['add_time']?></td>
						    <td><?=$val['trade_number']?></td>
						    <td><?=$val['type']?></td>

						    <td>
						    <?php foreach ($val['order_sn'] as $value) { ?>
						    <?=$value?><br>
						    <?php } ?>
						    </td>

						    <td ><?=$val['remark']?></td>

						    <?php if($val['direction'] == 'in'){ ?>
						    <td class="qby-s-1"><?=$val['amount']?></td>
						    <?php }else{ ?>
						    <td class="qby-s-2"><?=$val['amount']?></td>
						    <?php } ?>

						    <td ><?=$val['balance']?></td>
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

	$("#begin_date").datetimepicker({
		format:'yyyy-mm-dd',
		language: 'zh-CN',
		minView: "month",
		todayBtn:true,
		autoclose:true,
		todayHighlight:true,
	}).on('changeDate', function(ev){
		var starttime = $("#begin_date").val();
		$("#end_date").datetimepicker('setStartDate', starttime);
	});

	$("#end_date").datetimepicker({
		format:'yyyy-mm-dd',
		language: 'zh-CN',
		minView: "month",
		todayBtn:true,
		autoclose:true,
		todayHighlight:true,
	}).on('changeDate', function(ev){
		var enddate = $("#end_date").val();
		$("#begin_date").datetimepicker('setEndDate', enddate);
	});	

	$("#search_btn").click(function(){
		var start_time = $("#begin_date").val();
		if (start_time == ''){
			start_time = 0;
		}
		var end_time = $("#end_date").val();
		if (end_time == ''){
			end_time = 0;
		}
		var url = "<?=site_url('ewallet/index')?>" + '/' + start_time + '/' + end_time;
		window.location.href = url;
	});
</script>
