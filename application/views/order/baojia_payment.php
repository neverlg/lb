<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top3.php'; ?>

<div class="ckfwjd" style="padding-top:2%;">
    <div class="container ckfwjd-1">
        <div class="zjtz-1">
            订单金额：<?=$order['merchant_price']?>元
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

        <form action="<?=site_url('order/create_trade')?>" method="post">
        <div class="bjxq1-1">
            <b><font size="4">支付方式</font></b><br/>
            <?php if(!empty($coupons)){ ?>
            <a style="font-size:15px; font-weight:bold; color:#39F; padding-right:10px;" href="#">+使用优惠券</a>(共有<font color="#f00"><?=count($coupons)?>张</font>优惠券可用) 
            <?php } ?>
            <input style="margin-left:15px;" name="balance" type="checkbox">钱包余额&nbsp;<font color="#f1b06e"><?=$me_balance?>元</font><br/>
            <input name="order_id" type="hidden" value="<?=$order_id?>" />
            
            <?php if(!empty($coupons)){ ?>
            <select name="coupon_id">
                <option value="0">请选择优惠券</option>
                <?php foreach($coupons as $val){ ?>
                <option value="<?=$val['cg_id']?>" rel="<?=$val['c_money']?>"><?=$val['c_name']?>：满<?=$val['c_fullmoney']?>减<?=$val['c_money']?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </div>
    
        <div class="zftz1">
            订单总金额：<?=$order['merchant_price']?>元&nbsp;&nbsp;&nbsp;
            余额：-<span id="auto-balance">0.00</span>元&nbsp;&nbsp;&nbsp;
            <font color="#f00">优惠券（为你节省）：-<span id="auto-coupon">0.00</span>元</font><br/>
            应付金额:<font color="#f1b06e">￥<span id="real-fee"><?=$order['merchant_price']?></span>元</font><br/>
            <button type="submit">订单提交</button>
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
    var $total_fee = <?=$order['merchant_price']?>;
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
            $("#auto-balance").html($balance_fee);
            $("#real-fee").html($total_fee-$coupon_fee-$balance_fee);
        }else{
            $(this).val(0);
            $balance_fee = 0.00;
            $("#auto-balance").html($balance_fee);
            $("#real-fee").html($total_fee-$coupon_fee-$balance_fee);
        }
    });

    $("select[name='coupon_id']").change(function(){
        $coupon_fee = $(this).val();
        var real_fee = 0;
        if(($coupon_fee + $balance_fee)>=$total_fee){
            real_fee = 0.00;
        }else{
            real_fee = $total_fee-$coupon_fee-$balance_fee;
        }
        $("#auto-coupon").html($coupon_fee);
        $("#real-fee").html(real_fee);
    });

</script>

