<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">投诉管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck" style="padding-bottom:0px;">
        		<div class="bjck-1">
        			<span class="bjck-1-1" >
        			<a>投诉处理</a></span>
        		</div>

              	<div class="tscl-1">
              		投诉状态：<font color="#f00"><?=$detail['oc_handle_status_txt']?></font>
              		<?php if($detail['oc_handle_status'] == 1){?>
              		<a style="float:right;" href="<?=site_url('complain/del/'.$order_id)?>">撤销投诉</a>
              		<?php } ?>
              	</div>
            	<div class="pjgl-2-1">
                	订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;
                	订单金额：<?=$order['merchant_price']?>元  &nbsp;&nbsp;
                	师傅名字：<?=$order['master_name']?>（<?=$order['phone']?>）
                </div>
                
               	<div class="tscl-2">
               		<div class="col-md-6 tscl-2-1" >
                	<br/>
                   		<font color="#FFCC33" size="4">	投诉信息</font><br/>
	                    投诉编号：<?=$detail['oc_number']?><br/>
	                    发起时间：<?=$detail['oc_add_time']?><br/>
	                    投诉类别：<?=$detail['oc_category_txt']?>-<?=$detail['oc_subcategory_txt']?><br/>
	                    投诉内容：<?=$detail['oc_content']?><br/>
                    	<div id="preview1">
                    		<?php foreach($detail['oc_img'] as $val){ ?>
							           <img src="<?=$val?>" width="70" height="70">&nbsp;&nbsp;&nbsp;&nbsp;
							           <?php } ?>
 						            </div>         
                	</div>
                	<div class="col-md-6 tscl-3-1" >
                	<br/>
                   		<font color="#FFCC33" size="4">	客户处理结果</font><br/>
                    	处理结果： <font color="#f00"><?=$detail['oc_handle_result']?></font><br/>
                    	处理时间：<?=$detail['oc_handle_time']?><br/>
                    	处理说明：<?=$detail['oc_handle_explain']?>
                	</div>
               	</div>
        	</div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

