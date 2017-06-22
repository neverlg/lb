<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
		<a href="javascript:void(0);">报价订单管理</a>》
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="htnr-b">
        		<div class="htnr-b-1">
        			<a>报价订单列表</a>
        		</div>
        		<div class="htnr-b-2">
        			<a <?=($type==0)?"class='on'":""?> href="<?=site_url('order/baojia_index')?>">全部订单<span class="htnr-b-2-1 <?php if($type==0){echo 'on';} ?>" >(<?=$top_num['all']?>)</span></a>
        			<a <?=($type==1)?"class='on'":""?> href="<?=site_url('order/baojia_index/1')?>"> 待报价<span class=" htnr-b-2-1 <?php if($type==1){echo 'on';} ?>" >(<?=$top_num['wait_priced']?>)</span></a>
        			<a <?=($type==2)?"class='on'":""?> href="<?=site_url('order/baojia_index/2')?>"> 待雇佣<span class=" htnr-b-2-1 <?php if($type==2){echo 'on';} ?>" >(<?=$top_num['wait_hired']?>)</span></a>
        			<a <?=($type==3)?"class='on'":""?> href="<?=site_url('order/baojia_index/3')?>"> 待托管费用<span class=" htnr-b-2-1 <?php if($type==3){echo 'on';} ?>" >(<?=$top_num['wait_pay']?>)</span></a>
        			<a <?=($type==5)?"class='on'":""?> href="<?=site_url('order/baojia_index/5')?>"> 师傅服务中<span class=" htnr-b-2-1 <?php if($type==5){echo 'on';} ?>" >(<?=$top_num['under_service']?>)</span></a>
        			<a <?=($type==6)?"class='on'":""?> href="<?=site_url('order/baojia_index/6')?>"> 待确定验收<span class=" htnr-b-2-1 <?php if($type==6){echo 'on';} ?>" >(<?=$top_num['wait_accept']?>)</span></a>
        			<a <?=($type==7)?"class='on'":""?> href="<?=site_url('order/baojia_index/11')?>"> 待评价<span class=" htnr-b-2-1 <?php if($type==7){echo 'on';} ?>" >(<?=$top_num['wait_evaluate']?>)</span></a>
        		</div>
        		<div class="htnr-b-3">
        			<form class="form-search" action="<?=site_url('order/baojia_index/')?>" method="post">
        			客户信息:
        			<input type="text" placeholder="客户姓名/手机号码" name="kehu" value="<?=$kehu?>" />&nbsp;&nbsp;
        			订单编号:
        			<input type="text" name="order_sn" value="<?=$order_sn?>" />&nbsp;&nbsp;
        			物流单号:
        			<input type="text" name="logistics_no" value="<?=$logistics_no?>" />&nbsp;&nbsp;
        			订单状态:
        			<select name="ptype" value="<?=$type?>">
        				<option value="0" <?=($type==0)?"selected='selected'":""?>>全部订单状态</option>
        				<option value="1" <?=($type==1)?"selected='selected'":""?>>待报价</option>
        				<option value="2" <?=($type==2)?"selected='selected'":""?>>待雇佣</option>
        				<option value="3" <?=($type==3)?"selected='selected'":""?>>待托管费用</option>
<!--        				<option value="4" --><?//=($type==4)?"selected='selected'":""?><!-->已支付预付款</option>-->
        				<option value="5" <?=($type==5)?"selected='selected'":""?>>师傅服务中</option>
        				<option value="6" <?=($type==6)?"selected='selected'":""?>>待确认验收</option>
<!--        				<option value="7" --><?//=($type==7)?"selected='selected'":""?><!-->验收交易成功</option>-->
                        <option value="11" <?=($type==11)?"selected='selected'":""?>>待评价</option>
        				<option value="8" <?=($type==8)?"selected='selected'":""?>>退款中</option>
        				<option value="9" <?=($type==9)?"selected='selected'":""?>>仲裁中</option>
<!--                        <option value="12" --><?//=($type==12)?"selected='selected'":""?><!-->投诉处理中</option>-->
        				<option value="10" <?=($type==10)?"selected='selected'":""?>>订单关闭</option>
        			</select>
        			<button type="submit">搜索</button>
        			</form>
        		</div>
        		<div class="htnr-b-4">	共<?=$local_num?>条记录</div>
        		
        		<?php foreach ($local_list as $val) { ?>
        		<div class="htnr-b-5">
        			<div class="htnr-5-1">
        				订单编号:<a href="<?=site_url('order/baojia_detail/'.$val['id'])?>"><?=$val['order_number']?></a>&nbsp;&nbsp;&nbsp;&nbsp;下单时间:<?=$val['add_time']?>&nbsp;&nbsp;&nbsp;&nbsp;
        				报价人数：
                        <?php if($val['master_num']>0){ ?>
                        <a href="<?=site_url('order/baojia_offer/'.$val['id'])?>"><?=$val['master_num']?>人</a>
                        <?php }else{ ?>
                        <font color=" #00a2ea"><?=$val['master_num']?>人</font>
                        <?php } ?>
        				<a href="#" rel="<?=$val['id']?>" mark-data="<?=$val['merchant_remark']?>" class="remark">
                            <?php if(empty($val['merchant_remark'])){ ?>
                            <img src="<?=asset("images/xg3.png")?>" />
                            <?php }else{ ?>
                            <img src="<?=asset("images/xg5.png")?>" />
                            <?php } ?>
                        </a>

                        <?php if($val['merchant_status'] > 3){ ?>
                        <a class="confirm-code" rel="<?=$val['confirm_code']?>" >获取确认码</a>
                        <?php } ?>
        			</div>
            		<div class="htnr-b-6">
            			<table width="845" border="1">
  							<tr>
    							<td class="tab-b-1" width="160"><?=$val['service_type']?></td>
    							<td width="320">
    								<?=$val['customer_name']?>&nbsp;&nbsp;
    								<?=$val['customer_phone']?><br/>
                                    <?=$val['customer_area']?><br/>
    								<?=$val['customer_address']?>
    							</td>

    							<?php if(empty($val['merchant_price'])){ ?>
    							<td width="100">- -</td>
    							<?php }else{ ?>
    							<td width="100">
    								雇佣价格<br/>
    								<font color="#f00">￥<?=$val['merchant_price']?></font>
                                    <?php if (in_array($val['merchant_status'],[5,6])):?>
                                    <br/>
                                    <a class="replenish" rel="<?=$val['id']?>" href="javascript:void(0)">增加费用 &gt;</a>
                                    <?php endif;?>
    							</td>
    							<?php } ?>

                                <?php if($val['except_status']==1){ ?>
                                <td width="150" class="tab-b-4">交易关闭</td>
                                <?php }else if(in_array($val['except_status'], array(2,3))){ ?>
                                <td width="150" class="tab-b-55555">
                                    交易关闭<br/><br/>
                                    <a href="<?=site_url('refund/detail/'.$val['id'])?>">退款成功 ></a>
                                </td>
    							<?php }else if($val['arbitrate_status']==1){ ?>
    							<td width="150" class="tab-b-5555">
    								<a href="<?=site_url('refund/detail/'.$val['id'])?>">申请仲裁中 ></a>
    							</td>
    							<?php }else if($val['refund_status']==1){ ?>
    							<td width="150" class="tab-b-5555">
    								<a href="<?=site_url('refund/detail/'.$val['id'])?>">申请退款中 ></a>
    							</td>
    							<?php }else if($val['merchant_status']==1){ ?>
    							<td width="150">待报价</td>
    							<?php }else if($val['merchant_status']==2){ ?>
    							<td width="150" class="tab-b-4">
    								待雇佣<br/><br/>
    								<a href="<?=site_url('order/baojia_offer/'.$val['id'])?>">雇佣师傅 ></a>
    							</td>
    							<?php }else if($val['merchant_status']==3){ ?>
    							<td width="150" class="tab-b-5">
    								待托管费用<br/><br/>
    								<a href="<?=site_url('order/order_pay/'.$val['id'])?>">托管费用 ></a>
    							</td>
    							<?php }else if($val['merchant_status']==5 || $val['merchant_status']==4){ ?>
    							<td width="150" class="tab-b-5">师傅服务中</td>
    							<?php }else if($val['merchant_status']==6){ ?>
    							<td width="150" class="tab-b-55">
    								师傅完成服务<br/><br/>
    								<a href="<?=site_url('order/baojia_detail/'.$val['id'])?>">确定验收 ></a>
    							</td>
    							<?php }else if($val['merchant_status']==7){ ?>
    							<td width="150" class="tab-b-555">
    								验收交易成功<br/><br/>
    								<?php if($val['evaluate_status']==0){ ?>
    								<a href="<?=site_url('evaluate/add/'.$val['id'])?>">评价师傅 ></a>
    								<?php }else{ ?>
    									<?php if($val['except_status']==1){ ?>
    									<a href="<?=site_url('refund/detail/'.$val['id'])?>">退款成功 ></a><br/><br/>
    									<?php } ?>
    									<font color="#999999">已评价</font>
    								<?php } ?>
    							</td>
    							<?php } ?>

    							<td width="150">
    								<span class="tab-b-2">
    									<a href="<?=site_url('order/baojia_detail/'.$val['id'])?>">订单详情 ></a>
    								</span>
    								<?php if(in_array($val['merchant_status'], array(1,2,3)) && $val['except_status']!=1){ ?>
    								<br/> 
                                        <?php 
                                            $from = 'wait_priced';
                                            if($val['merchant_status']==2){
                                                $from = 'wait_hired';
                                            }else if($val['merchant_status']==3){
                                                $from = 'wait_pay';
                                            }
                                        ?>
    								<span class="tab-b-3">
    									<a class="cancel-order" href="#" rel="<?=site_url('order/baojia_del/'.$val['id'].'/'.$from)?>">取消订单</a>
    								</span>
    								<?php }else if(in_array($val['merchant_status'], array(4,5,6)) && $val['refund_status']==0){ ?>
    								<br/>
    								<span class="tab-b-33">
    									<a href="<?=site_url('refund/add/'.$val['id'])?>">申请退款</a>
    								</span>
    								<?php } ?>
    							</td>
  							</tr>
						</table>
					</div>
        		</div>
        		<?php } ?>
        
        		<div class="htfy" style="margin-top:25px;">
        			<?=$__pagination_url?>
        		</div>  
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

<!--merchant remark-->
<div class="remark-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2-mark">
        <form id="mark-fm" action="<?=site_url('order/add_baojia_mark')?>" method="post">
        <input type="hidden" name="order_id" />
        <div class="tt-2-1">订单标记 <img class="close-remark" src="<?=asset("images/02418.png")?>" /></div>
        <div class="tt-2-22"><textarea id="mark-content" name="mark" cols="30" rows="4"></textarea></div>
        <div class="tt-2-4">标记的内容自己可见</div>
        <div class="tt-2-3">
            <a class="submit-mark" href="#">确定</a>
            <a class="on close-remark" href="#">取消</a>
        </div>
        </form>
    </div>
</div>

<!--confirm code-->
<div class="confirmcode-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2-confirmcode">
        <input type="hidden" name="order_id" />
        <div class="tt-2-1">服务确认码 <img class="close-confirmcode" src="<?=asset("images/02418.png")?>" /></div>
        <div class="cc-2-2y"></div>
        <div class="cc-2-2">
            <p>1.如果由于特殊原因，师傅无法找客户索取到服务确认码，你可以把该服务码告知师傅，以让师傅确认服务完成。</p>
            <p>2.如果师傅没有为客户完成服务，请勿随意提供！</p>
        </div>
        <div class="cc-2-3">
            <a class="close-confirmcode">我知道了</a>
        </div>
    </div>
</div>

<!--merchant remark-->
<div class="replenish-pop" style="display:none;">
    <div class="lb_mask"></div>
    <div class="tt-2-mark" style="height:300px;">
        <form id="mark-fm" action="<?=site_url('order/order_replenish')?>" method="post">
            <input type="hidden" name="order_id" />
            <div class="tt-2-1">增加费用 <img class="close-replenish" src="<?=asset("images/02418.png")?>" /></div>
            <div class="tt-2-22">增加费用：<input tpye="text" name="replenish_amount"></div>
            <div class="tt-2-22"><textarea id="mark-content" name="replenish_reason" cols="30" rows="4"></textarea></div>
            <div class="tt-2-3">
                <button class="submit-mark" type="submit">确定</button>
                <a class="on close-replenish" href="#">取消</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var $cancelUrl;
    var $confirmCode;
    var $cancelOrderBox = $(".cancel-order-pop");
    var $merchant_mark = $(".remark-pop");
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

    //confirm code
    $(".confirm-code").click(function(){
        $confirmCode = $(this).attr('rel');
        $(".cc-2-2y").html($confirmCode);
        $(".confirmcode-pop").show();
    });

    $(".close-confirmcode").click(function(){
        $confirmCode = '';
        $(".confirmcode-pop").hide();
    });

    //merchant mark
    $(".remark").click(function(){
        var oid = $(this).attr('rel');
        var remark = $(this).attr('mark-data');
        $("input[name='order_id']").val(oid);
        $("#mark-content").val(remark);
        $merchant_mark.show();
    });

    $(".submit-mark").click(function(){
        $.ajax({
            type:'post',
            url:$("#mark-fm").attr('action'),
            data:$("#mark-fm").serialize(),
            success:function(msg){
                if(msg.status == 0){
                    window.location.reload();
                }else{
                    alert(msg.error);
                }
            }
        });
    });

    $(".close-remark").click(function(){
        $merchant_mark.hide();
    });

	//pagination post
	$(".htfy a").click(function(){
	var url = $(this).attr("href");
	page_data_post(url);
	return false;
	});

	function page_data_post(url){
	$(".form-search").attr("action",url).removeAttr("onsubmit").submit();
	return false;
	}

    $(".replenish").click(function(){
        var oid = $(this).attr('rel');
        $("input[name='order_id']").val(oid);
        $(".replenish-pop").show();
    });

    $(".close-replenish").click(function(){
        $(".replenish-pop").hide();
    });

</script>
