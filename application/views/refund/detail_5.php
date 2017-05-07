<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

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
    		<div class="bjck" style="padding-bottom:0px;">
          <div class="bjck-1">
            <span class="bjck-1-1" ><a>退款管理</a></span>
          </div>

          <div class="tscl-1">
            退款状态：<font color="#f00">介入仲裁结果（平台客服调查取证中）</font>
          </div>
          <div class="pjgl-2-1">
            订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;
            订单金额：<?=$order['merchant_price']?>元  &nbsp;&nbsp;
            支付方式：<?=$order['pay_type']?>
          </div>
                
          <div class="tscl-2">
            <div class="col-md-6 tscl-2-1" >
            <br/>
              <font color="#FFCC33" size="4">  申请退款信息</font><br/>
              退款编号：<?=$refund['order_number']?><br/>
              退款时间：<?=$refund['refund_time_txt']?><br/>
              退款类型：<?=$refund['refund_type']?><br/>
              退款金额：<font color="#f00"><?=$refund['refund_amount']?>元</font><br/>
              退回方式：<?=$refund['refund_method']?><br/>
              退款说明：<?=$refund['refund_reason']?><br/><br/>                          
            </div>
                
            <div class="col-md-6 tscl-3-1" >
            <br/>
              <font color="#FFCC33" size="4">  师傅处理结果</font><br/>
              处理操作：<font color="#f00">拒绝退款</font><br/>
              处理时间：<?=$refund['refund_result_time']?><br/>
              处理金额：<font color="#f00"><?=$refund['refund_amount']?>元</font><br/>
              退款说明：<?=$refund['refund_refuse_reason']?>
            </div>
                
            <div style="border-top:2px solid #eee; clear:both; overflow:hidden;">
              <div class="col-md-6 tscl-2-1"  >
              <br/>
                <font color="#FFCC33" size="4">平台客服介入仲裁结果</font><br/>
                处理操作：- -<br/>
                处理时间：- -<br/>
                处理金额：- -<br/>
                退款说明：- -
              </div>
            </div>
          </div>
        </div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?> 

<script type="text/javascript">

</script>