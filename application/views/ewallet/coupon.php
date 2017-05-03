<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">优惠券</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">优惠券</a></span>
        		</div>
        		<div class="yhq-1">
        			<a <?=($status==0) ? "class='on'" : ""?> href="<?=site_url('ewallet/coupon')?>">未使用(<?=$count[0]['total_price']?>元)</a>
        			<a <?=($status==1) ? "class='on'" : ""?> href="<?=site_url('ewallet/coupon/1')?>">已使用(<?=$count[1]['total_price']?>元)</a>
        			<a <?=($status==2) ? "class='on'" : ""?> href="<?=site_url('ewallet/coupon/2')?>">已过期(<?=$count[2]['total_price']?>元)</a>
            		<span class="yhq-1-1">共
            			<font color="#f00"><?=$count[$status]['count']?>条</font>记录
            		</span>
        		</div>
        		<div class="yhq-2">
        			<center>
        				<table width="100%" border="1">
						    <tr>
							    <th scope="col">类型</th>
							    <th scope="col">优惠券名称</th>
							    <th scope="col">卷号</th>
							    <th scope="col">面值</th>
							    <th scope="col">有效期</th>
							    <th scope="col">使用状态</th>
						    </tr>

						    <?php foreach($list as $val){ ?>
						    <tr>
							    <td><?=$val['c_type']?></td>
							    <td><?=$val['c_name']?></td>
							    <td><?=$val['cg_sncode']?></td>
							    <td><font size="4"><?=$val['c_money']?>元</font><br/>(满<?=$val['c_fullmoney']?>元可以使用)</td>
							    <td class="yhq-2-1"><?=$val['cg_starttime']?>至<?=$val['cg_endtime']?></td>
							    <td>
							    	<?php 
							    		$last = array(
							    			0 => '未使用',
							    			1 => '已使用',
							    			2 => '已过期'
							    			); 
							    		echo $last[$status];
							    	?>
							    </td>
						  	</tr>
							<?php } ?>
						</table>
					</center>
				</div>
              
 				<div class="htfy">
 				<?=$__pagination_url?>
    			</div>

    			<div class="yhq-3">
		        	现金券规则<br/>当你在托管费用的时候，在订单确认页面可以选择你的现金券号，获得优惠。<br/>
		            每个订单只能使用一张优惠券，需要在订单费用支付使用。<br/>
		            现金券不兑换现金，不开发票<br/>
		            现金券需要在有效期使用<br/>
		            若你的订单退款后，该优惠券不能使用第二次。<br/><br/>
    			</div>      
    		</div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

