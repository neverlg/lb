<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top3.php'; ?>

<div class="ckfwjd" style="padding-top:2%;">
    <div class="container ckfwjd-1">
        <div class="zjtz-1">
            订单金额：<?=$order['merchant_price']?>元
        </div>

        <div class="zjtz-1">
            补款金额：<?=$replenish['replenish_amount']?>元<br/>
            补款原因：<?=$replenish['replenish_reason']?><br/>
        </div>

        <div class="bjxq1-1">
            <b><font size="4">订单信息</font></b><br/>
            客户姓名：<?=$order['customer_name']?><br/>
            订单编号：<?=$order['order_number']?><br/>
            客户手机：<?=$order['customer_phone']?><br/>
            客户地址：<?=$order['customer_address']?><br/>
        </div>
        
        <div class="bjxq1-1">
            <b><font size="4">师傅信息</font></b><br/>
            师傅姓名：<?=$master['real_name']?>（<?=$master['phone']?>）<br/>
            保证金：<?=$master['assure_fund']?> <br/>
        </div>

        <form action="<?=site_url('order/create_replenish')?>" method="post">
        <div class="bjxq1-1">
            <b><font size="4">支付方式</font></b><br/>
            <input style="margin-left:15px;" name="balance" type="checkbox">钱包余额&nbsp;<font color="#f1b06e"><?=$me_balance?>元</font><br/>
            <input name="order_id" type="hidden" value="<?=$order_id?>" />
            <input name="replenish_amount" type="hidden" value="<?=$replenish['replenish_amount']?>" />
            <input name="replenish_reason" type="hidden" value="<?=$replenish['replenish_reason']?>" />
        </div>
    
        <div class="zftz1">
            订单总金额：<?=$order['merchant_price']?>元&nbsp;&nbsp;&nbsp;
            余额：-<span id="auto-balance">0.00</span>元&nbsp;&nbsp;&nbsp;
            应付金额:<font color="#f1b06e">￥<span id="real-fee"><?=$replenish['replenish_amount']?></span>元</font><br/>
            <button type="submit">立即支付</button>
            <br/>
            <font color="#f00"> 
                温馨提示：确认价格无误后可进行付款，付款完成后平台托管费用，直接确认验收到你师傅。
            </font>
        </div>
        </form>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
    var $balance = <?=$me_balance?>;
    var $total_fee = <?=$replenish['replenish_amount']?>;
    var $coupon_fee = 0;
    var $balance_fee = 0;

    $("input[name='balance']").change(function(){
        if($(this).is(':checked') && $balance>0){
            $(this).val(1);
            if(($balance+$coupon_fee) >= $total_fee){
                $balance_fee = $total_fee-$coupon_fee;
            }else{
                $balance_fee = $balance;
            }
            $balance_fee = parseFloat($balance_fee);
            $("#auto-balance").html($balance_fee.toFixed(2));
            var fee = $total_fee-$coupon_fee-$balance_fee;
            fee = parseFloat(fee);
            $("#real-fee").html(fee.toFixed(2));
        }else{
            $(this).val(0);
            $balance_fee = 0.00;
            $("#auto-balance").html('0.00');
            var fee = $total_fee-$coupon_fee-$balance_fee;
            fee = parseFloat(fee);
            $("#real-fee").html(fee.toFixed(2));
        }
    });

</script>

