<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">投诉管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>投诉管理</a></span>
        		</div>
              
            	<div class="tsgl-1">
            		&nbsp;&nbsp;<b>投诉编号：</b>
            		<input name="co_number" type="text" value="<?=empty($co_number)?'':$co_number?>">&nbsp;&nbsp;&nbsp;&nbsp;
            		<b>订单编号：</b>
            		<input name="or_number" type="text" value="<?=empty($or_number)?'':$or_number?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            		<b>处理状态：</b>
            		<select name="handle_status" value="<?=$handle_status?>">
            			<option <?=($handle_status==0)?"selected='selected'":""?> value="0">全部状态</option>
            			<option <?=($handle_status==1)?"selected='selected'":""?> value="1">等待核实处理</option>
            			<option <?=($handle_status==2)?"selected='selected'":""?> value="2">已撤回投诉</option>
            			<option <?=($handle_status==3)?"selected='selected'":""?> value="3">投诉成功</option>
            			<option <?=($handle_status==4)?"selected='selected'":""?> value="4">投诉失败</option>
            		</select>
            		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="com-search" style="cursor:pointer;">搜&nbsp;索</a>
            	</div>
            
            	<div class="tsgl-2">
            		<table width="865" border="1">
						  <tr class="tsgl-2-1">
						    <td>发起时间</td>
						    <td>投诉编号</td>
						    <td>涉及订单</td>
						    <td>师傅名字</td>
						    <td>交易金额</td>
						    <td>投诉状态</td>
						    <td>详情</td>
						  </tr>
						  <?php foreach ($list as $val) { ?>
						  <tr class="tsgl-2-2">
						    <td><?=$val['oc_add_time']?></td>
						    <td><?=$val['oc_number']?></td>
						    <td>
						    	<font color="#16b0f0"><?=$val['order_number']?></font><br/>
						    	<?=$val['service_type']?>
						    </td>
						    <td><?=$val['master_name']?></td>
						    <td><?=$val['merchant_price']?></td>
						    <td class="tsgl-2-2-1">
						    	<?=$val['oc_handle_status_txt']?><br/>
						    	<?php if($val['oc_handle_status']==1){ ?>
						    	<br/>
						    	<a href="<?=site_url('complain/del/'.$val['oc_orderid'])?>">撤销投诉></a>
						    	<?php } ?>
						    </td>
						    <td class="tsgl-2-2-2"><a href="<?=site_url('complain/detail/'.$val['oc_orderid'])?>">查看</a></td>
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
	$("#com-search").click(function(){
		var co_number = $("input[name='co_number']").val();
		var or_number = $("input[name='or_number']").val();
		var handle_status = $("select[name='handle_status']").val();
		if(co_number == ''){
			co_number = 0;
		}
		if(or_number == ''){
			or_number = 0;
		}
		window.location.href = "<?=site_url('complain/index')?>" + "/" + co_number + "/" + or_number + "/" + handle_status;
	});

</script>