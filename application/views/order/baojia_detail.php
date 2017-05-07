<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
		<a href="javascript:void(0);">报价订单详情</a>》
	</div>
</div>

<div class="ckfwjd">
    <div class="container ckfwjd-1">

        <div class="ckjd-1">
            <a class="on" href="<?=site_url('order/baojia_detail/'.$order_id)?>">报价订单详情</a>
            
            <?php if($detail['order']['merchant_status']>1){ ?>
            <a href="<?=site_url('order/baojia_offer/'.$order_id)?>">师傅报价<font color="#f00">(<?=$detail['master_num']?>)</font></a>
            <?php }else{ ?>
            <a href="#">师傅报价<font color="#f00">(0)</font></a>
            <?php } ?>

            <?php if($detail['order']['merchant_status']>4){ ?>
            <a href="<?=site_url('order/baojia_trace/'.$order_id)?>">查看服务节点</a>
            <?php } ?>

            <?php if($detail['order']['refund_status']==1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>">申请退款中 ></a>
                </span>
            </span>
            <?php }else if($detail['order']['arbitrate_status']==1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>">申请仲裁中 ></a>
                </span>
            </span>
            <?php }else if($detail['order']['except_status']>1){ ?>
            <span class="ckjd-1-1">
                <span class="ckjd-1-6">
                    <a href="<?=site_url('refund/detail/'.$order_id)?>" style="background-color:gray;">退款成功 ></a>
                </span>
            </span>
            <?php }else{ ?>

            <span class="ckjd-1-1">
                <?php if($detail['order']['merchant_status']==2){ ?>
                <span class="ckjd-1-2"> 
                    <a style="background:#b04b87;" href="<?=site_url('order/baojia_offer/'.$order_id)?>">雇佣师傅 ></a>
                </span>
                <?php }else if($detail['order']['merchant_status']==3){ ?>
                <span class="ckjd-1-2"> 
                    <a href="<?=site_url('order/order_pay/'.$order_id)?>">托管费用 ></a>
                </span>
                <?php }else if($detail['order']['merchant_status']==6){ ?>
                <span id="confirm-count">
                    -天--时--分--秒将自动确认验收放款
                </span>

                <script type="text/javascript">
                    var timestamp = Date.parse(new Date()); 
                    var intDiff = <?=(config_item('auto_confirm_time')+$detail['order']['finish_time'])?> - timestamp/1000;

                    $(function(){
                        timer(intDiff);
                    }); 
                </script>

                <span class="ckjd-1-2"> 
                    <a href="#" id="check-to-confirm" rel="<?=$detail['order']['merchant_price']?>">确认验收 ></a>
                </span>
                <?php } ?>

                <?php if($detail['order']['merchant_status']<4){ ?>
                    <?php 
                        $from='wait_priced'; 
                        if($detail['order']['merchant_status']==2){
                            $from='wait_hired'; 
                        }else if($detail['order']['merchant_status']==3){
                            $from='wait_pay'; 
                        }
                    ?>
                <span class="ckjd-1-3">
                    <a class="cancel-order" rel="<?=site_url('order/baojia_del/'.$order_id.'/'.$from)?>">取消订单</a>
                </span>
                <?php }else if($detail['order']['merchant_status']<7){ ?>
                <span class="ckjd-1-3">
                    <a href="<?=site_url('refund/add/'.$order_id)?>">申请退款</a>
                </span>
                <?php }else if($detail['order']['evaluate_status']==0){ ?>
                <span class="ckjd-1-2"> 
                    <a href="<?=site_url('evaluate/add/'.$order_id)?>">评价师傅 ></a>
                </span>
                <?php }else if($detail['order']['evaluate_status']==1){ ?>
                <span class="ckjd-1-3">
                    <a>你已评价师傅</a>
                </span>
                <?php } ?>
            </span>
            <?php } ?>

        </div>

        <div class="bjxq">
            <div class="bjxq-1">
                下单时间:<?=$detail['order']['xidan_time_txt']?> &nbsp;&nbsp;
                <?php if($detail['order']['merchant_status']<3){ ?>  
                截止报价时间:<font color="#FF0000" id="baojia-countdown">-天--时--分--秒</font>

                <script type="text/javascript">
                    var timestamp = Date.parse(new Date()); 
                    var intDiff = <?=(config_item('baojia_deadline')+$detail['order']['xiadan_time'])?> - timestamp/1000;

                    $(function(){
                        timer(intDiff, 1);
                    }); 
                </script>


                <?php }else{ ?>
                已雇佣师傅：<?=$detail['master']['master_name']?>（<?=$detail['master']['phone']?>）
                <?php } ?>
                <span style="float:right; padding-right:3%; color:#f00; font-size:15px;">
                    <?php if($detail['order']['refund_status']==3 || $detail['order']['arbitrate_status']==3){ ?>
                    交易关闭
                    <?php }else{ ?>
                    订单状态:<?=$detail['order']['merchant_status_txt']?>
                    <?php } ?>
                </span>
            </div>
            

            <div class="bjxq-2">
                <li class="bjxq-2-1"><a href="#">1</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-40px;" style="margin-top:10px;" color="#f00" size="3">发布订单</font></a></li></li>

                <?php if($detail['order']['merchant_status']>1){ ?>  
                <li class="bjxq-2-1"><a href="#">2</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#f00" size="3">多个师傅报价</font></a></li></li>
                <?php }else{ ?>
                <li class="bjxq-2-2"><a href="#">2</a><li class="bjxq-2-22"><br/><a href="#"><font style="margin-left:-50px;" color="#333" size="3">多个师傅报价</font></a></li></li>
                <?php } ?>

                <?php if($detail['order']['merchant_status']>2){ ?>
                <li class="bjxq-2-1"><a href="#">3</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#f00" size="3">挑选师傅雇佣</font></a></li></li>
                <?php }else{ ?>
                <li class="bjxq-2-2"><a href="#">3</a><li class="bjxq-2-22"><br/><a href="#"><font style="margin-left:-50px;" color="#333" size="3">挑选师傅雇佣</font></a></li></li>
                <?php } ?>

                <?php if($detail['order']['merchant_status']>3){ ?>
                <li class="bjxq-2-1"><a href="#">4</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#f00" size="3">托管服务费用</font></a></li></li>
                <?php }else{ ?>
                <li class="bjxq-2-2"><a href="#">4</a><li class="bjxq-2-22"><br/><a href="#"><font style="margin-left:-50px;" color="#333" size="3">托管服务费用</font></a></li></li>
                <?php } ?>

                <?php if($detail['order']['merchant_status']>4){ ?>
                <li class="bjxq-2-1"><a href="#">5</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#f00" size="3">师傅服务中</font></a></li></li>
                <?php }else{ ?>
                <li class="bjxq-2-2"><a href="#">5</a><li class="bjxq-2-22"><br/><a href="#"><font style="margin-left:-50px;" color="#333" size="3">师傅服务中</font></a></li></li>
                <?php } ?>

                <?php if($detail['order']['merchant_status']>5){ ?>
                <li class="bjxq-2-1"><a href="#">6</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#f00" size="3">师傅完成服务</font></a></li></li>
                <?php }else{ ?>
                <li class="bjxq-2-2"><a href="#">6</a><li class="bjxq-2-22"><br/><a href="#"><font style="margin-left:-50px;" color="#333" size="3">师傅完成服务</font></a></li></li>
                <?php } ?>

                <?php if($detail['order']['merchant_status']>6){ ?>
                <li class="bjxq-2-1" style="width:120px;" ><a href="#">7</a></li>
                <li style="margin-left:-155px; margin-top:28px; color:#f00; font-size:16px;" >验收交易成功</li>
                <?php }else{ ?>
                <li class="bjxq-2-2" style="width:120px;" ><a href="#">7</a></li>
                <li style="margin-left:-155px; margin-top:28px; color:#333; font-size:16px;" >验收交易成功</li>
                <?php } ?>
            </div>
        </div>

        <div class="bjxq1">
            <div class="bjxq-1">
                订单编号:<?=$detail['order']['order_number']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                服务类型:<?=$detail['order']['service_type_txt']?>
                <span style="float:right;padding-right:3%;cursor:pointer;" class="edit-order" >编辑此订单</span>
            </div>
    
            <div class="bjxq1-1">
                <b><font size="4">客户信息</font></b><br/>
                客户姓名：<?=$detail['order']['customer_name']?><br/>
                客户手机：<?=$detail['order']['customer_phone']?><br/>
                客户地址：<?=$detail['order']['customer_address']?><br/>
                电梯步梯：<?=$detail['order']['customer_elevator']?>&nbsp;&nbsp;<?=$detail['order']['customer_floor']?>楼<br/>
                是否核销：<?=$detail['order']['customer_tmall_number']?><br/>
                <?php if($detail['order']['service_type']==2){ ?>
                是否到货：<?=$detail['order']['logistics_status_txt']?><br/>
                <?php } ?>
            </div>

            <?php if(in_array($detail['order']['service_type'], array(1,4))){ ?>
            <div class="bjxq1-1">
                <b><font size="4">物流信息</font></b><br/>
                是否到货：<?=$detail['order']['logistics_status_txt']?><br/>
                物流单号：<?=$detail['order']['logistics_ticketnumber']?><br/>
                包装件数：<?=$detail['order']['logistics_packages']?>件<br/>
                物流公司：<?=$detail['order']['logistics_name']?><br/>
                物流电话：<?=$detail['order']['logistics_phone']?><br/>
                提货地址：<?=$detail['order']['logistics_address']?><br/>
                备注说明：<?=$detail['order']['logistics_mark']?><br/>
            </div>
            <?php } ?>

            <div class="bjxq1-1">
                <b><font size="4">下单用户</font></b><br/>
                下单联系人：<?=$detail['order']['merchant_name']?><br/>
                手机号码：<?=$detail['order']['merchant_phone']?><br/>
                服务要求：<?=$detail['order']['customer_memark']?><br/>
            </div>

            <div class="bjxq1-1">
                <b><font size="4">货品信息</font></b><br/>

                <?php foreach ($detail['goods'] as $val) { ?>
                <table width="1100" border="1">
                    <tr class="bjxq1-tr"> 
                        <td width="200">货品图片</td>
                        <td width="200">货品名称</td>
                        <td width="200">货品数量</td>
                        <td width="500">备注说明</td>
                    </tr>
                    <tr>
                        <td class="detail-td">
                        <?php if(is_array($val['goods_img'])){ ?>
                            <?php foreach($val['goods_img'] as $img){ ?>
                            <img src="<?=$img?>" />
                            <?php } ?>
                        <?php }else{ ?>
                        <img src="<?=$val['goods_img']?>" />
                        <?php } ?>
                        </td>
                        <td><b><?=$val['goods_name']?></b><br/><font color="#999">(<?=$val['goods_type']?>)</font></td>
                        <td><?=$val['goods_num']?></td>
                        <td><?=$val['goods_mark']?></td>
                    </tr>
                </table><br/>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<!--cancel order-->
<div class="cancel-order-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2">
        <div class="tt-2-1">取消订单 <img class="close-pop" src="<?=asset("images/02418.png")?>" style="cursor:pointer;"/></div>
        <div class="tt-2-2">你确定取消订单吗？</div>
        <div class="tt-2-3">
            <a href="#" class="cancel-order-confirm">确定</a>
            <a class="on cancel-order-cancel" href="#">再考虑一下</a>
        </div>
    </div>
</div>

<!--check to confirm-->
<div class="confirm-tg-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-7">
        <div class="tt-2-1">确定验收 <img class="close-checkconfirm" src="<?=asset("images/02418.png")?>" /></div>
        <div class="tt-2-22" >你确定给师傅放款吗？</div>
        <div class="tt-2-2y" style="padding-top:0;">
            <span class="tg-fee"></span><br>
            <font color="#333" size="2">(托管费用<span class="tg-fee"></span>元)</font>
        </div>
        <div class="tt-2-4" style="padding-left: 10px;">
            温馨提示：确认给师傅放款前请确保师傅已经完成任务，一旦放款即无法退款，如有服务异常请在付款前跟师傅沟通协商清楚。
        </div>
        <div class="tt-2-3">
            <a href="#" class="confirm-tgfee">确认放款</a>
            <a class="on close-checkconfirm" href="#">取消</a>
        </div>
    </div>
</div>

<!--confirm success-->
<div class="confirm-success-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2">
        <div class="tt-2-1">确认验收 <img class="close-confirm-success" src="<?=asset("images/02418.png")?>" /></div>
        <div class="tt-2-2y" style=" font-size:18px; padding-bottom:20px;">你已成功给师傅放款！</div>
        <div class="tt-2-3">
            <a href="<?=site_url('evaluate/add/'.$order_id)?>">去评价师傅</a>
            <a class="on close-confirm-success" href="#">暂不评价</a>
        </div>
    </div>
</div>

<!-- edit order -->
<div class="edit-order-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-8" <?=(!in_array($detail['order']['service_type'], array(1, 4))) ? "style='height:500px;'" : ""?>>
        <div class="tt-2-1">
            编辑订单 
            <img class="close-edit-order" style="cursor:pointer;" src="<?=asset("images/02418.png")?>" />
        </div>
        <form id="edit-fm" action="<?=site_url('order/edit/'.$order_id)?>" method="post">
        <div class="smza-3 goods-before">
            <img  src="<?=asset("images/1307.png")?>" />客户信息：  
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>客户姓名：
            <input name="customer_name" value="<?=$detail['order']['customer_name']?>" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>客户手机：
            <input name="customer_phone" value="<?=$detail['order']['customer_phone']?>" type="text" required pattern="^1[3,5,8]\d{9}$">
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>详情地址：
            <input name="address" value="<?=$detail['order']['customer_address']?>" type="text" required>
        </div>
        <?php if($detail['order']['service_type']==2){ ?>
        <div class="smza-3-1">
            <font color="#f00">*</font>是否到货：
            <select name="cargo_arrive" value="$detail['order']['logistics_status']">
                <option value="">请选择</option>
                <option value="0" <?=($detail['order']['logistics_status']==0 ? "selected='selected'" : '')?>>未发出</option>
                <option value="1" <?=($detail['order']['logistics_status']==1 ? "selected='selected'" : '')?>>已发出</option>
                <option value="2" <?=($detail['order']['logistics_status']==2 ? "selected='selected'" : '')?>>已到货</option>
            </select>
        </div>
        <?php } ?>

        <?php if(in_array($detail['order']['service_type'], array(1, 4))){ ?>
        <div class="smza-3">
            <img src="<?=asset("images/60403.png")?>" />物流信息：  
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>是否到货：
            <select name="cargo_arrive" value="$detail['order']['logistics_status']">
                <option value="">请选择</option>
                <option value="0" <?=($detail['order']['logistics_status']==0 ? "selected='selected'" : '')?>>未发出</option>
                <option value="1" <?=($detail['order']['logistics_status']==1 ? "selected='selected'" : '')?>>已发出</option>
                <option value="2" <?=($detail['order']['logistics_status']==2 ? "selected='selected'" : '')?>>已到货</option>
            </select>
        </div>
     
        <div class="smza-3-11">
            &nbsp;包装件数：  
            <input class="text_box" name="goodnum" type="number" value="<?=$detail['order']['logistics_packages']?>" style="width:70px;" />
        </div>
        <div class="smza-3-1">
            &nbsp;物流单号：
            <input name="logistics_no" value="<?=$detail['order']['logistics_ticketnumber']?>" type="text">
        </div>
        <div class="smza-3-1">
            &nbsp;物流公司：
            <input name="logistics_name" value="<?=$detail['order']['logistics_name']?>" type="text">
        </div>
        <div class="smza-3-1">
            &nbsp;物流电话：
            <input name="logistics_phone" value="<?=$detail['order']['logistics_phone']?>" type="text">
        </div>
        <div class="smza-3-1">
            &nbsp;提货地址：
            <input name="logistics_address" value="<?=$detail['order']['logistics_address']?>" type="text">
        </div>
        <div class="smza-2-4">
            <span style="float:left; font-size:15px; padding-left:2%;">&nbsp;备注说明：</span>
            <textarea name="logistics_remark" cols="42" rows="3">
                <?=$detail['order']['logistics_mark']?>
            </textarea>  
        </div>
        <?php } ?>  

        <div class="smza-3">
            <img src="<?=asset("images/41329.png")?>" />下单用户：  
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>用户姓名：
            <input name="me_name" value="<?=$detail['order']['merchant_name']?>" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>用户手机：
            <input name="me_phone" value="<?=$detail['order']['merchant_phone']?>" type="text" required>
        </div>

        <div class="tt-2-3">
            <button type="submit">确定</button>
            <a class="on close-edit-order" href="#">取消</a>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var $cancelUrl;
    var $cancelOrderBox = $(".cancel-order-pop");

    //edit dialog
    $(".edit-order").click(function(){
        $(".edit-order-pop").show();
    });

    $("#edit-fm").submit(function(){
        var status = <?=$detail['order']['merchant_status']?>;
        if(status > 4){
            $(".edit-order-pop").hide();
            alert('师傅服务中，不能修改订单');
        }else{
            $.ajax({
                type:'post',
                url:$("#edit-fm").attr('action'),
                data:$("#edit-fm").serialize(),
                success:function(msg){
                    if(msg.status == 0){
                        window.location.reload();
                    }else{
                        alert(msg.error);
                    }
                }
            });
        }
        return false;
    });

    $(".close-edit-order").click(function(){
        $(".edit-order-pop").hide();
    });

    //tuoguan fee
    $("#check-to-confirm").click(function(){
        var fee = $(this).attr('rel');
        $(".tg-fee").html(fee);
         $(".confirm-tg-pop").show();
    });

    $(".close-confirm-success").click(function(){
        $(".confirm-success-pop").hide();
    });

    $(".close-checkconfirm").click(function(){
        $(".confirm-tg-pop").hide();
    });

    $(".confirm-tgfee").click(function(){
        $.ajax({
            type:'get',
            url:"<?=site_url('order/check_to_confirm/'.$order_id)?>",
            success:function(msg){
                if(msg.status == 0){
                    $(".confirm-tg-pop").hide();
                    $(".confirm-success-pop").show();
                }else{
                    alert('系统繁忙，请稍后再试');
                }
            }
        });
    });

    //cancel order
    $(".cancel-order").click(function(){
        $cancelUrl = $(this).attr('rel');
        $cancelOrderBox.show();
    });

    $(".cancel-order-confirm").click(function(){
        $.ajax({
            type:"get",
            url:$cancelUrl,
            success:function(msg){
                if(msg.status==0){
                    window.location.reload();
                }else{
                    alert(msg.error);
                }
            }
        });
    });

    $(".cancel-order-cancel, .close-pop").click(function(){
        $cancelOrderBox.hide();
    });


    function timer(intDiff, type=0){
        window.setInterval(function(){
          var day = 0,
              hour = 0,
              minute = 0,
              second = 0;
          if(intDiff > 0){
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

            if(type==1){
                $("#baojia-countdown").html(day + '天' + hour + '时' + minute + '分' + second + '秒');
            }else{
                $("#confirm-count").html(day + '天' + hour + '时' + minute + '分' + second + '秒');
            }
            
            intDiff--;
          }
        }, 1000);
    }
</script>

