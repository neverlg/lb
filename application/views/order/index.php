<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》<a href="javascript:void(0);">后台管理中心</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
      <?php require 'application/views/basic/left_nav.php'; ?>
    	<div class="col-md-9">
    		<div class="htnr-r">
        		<div class="htnr-h1">
        			<div class="col-md-6 htnr-r-1">
                		<div class="col-md-3">
                            <?php if(empty($user['me_headimg'])){ ?>
                			<img src="<?=asset("images/ht7.png")?>" />
                            <?php }else{ ?>
                            <img src="<?=$user['me_headimg']?>" />
                            <?php } ?>
                		</div>
                    	<div class="col-md-9">
                    		<span class="htnr-r-2">
                    			你好，<?=$user['me_username']?><br/>
                    			账户类型:<?=$user['me_category']?><br/>
                    			上次登录:<?=$last_login_time?>
                    		</span>
                    	</div>
                	</div>
                	<div class="col-md-6 htnr-r-3">
                		<div class="col-md-4 htnr-r-3-1">
                    		钱包余额<br/>
                       		<a href="#"> <font size="5" color="#f00">￥<?=$user['me_money']?></font></a>元<br/>
                       		<span class="htnr-3-cz"> <a href="<?=site_url('ewallet/recharge')?>">充值</a></span>
                    	</div>
                    	<div class="col-md-4 htnr-r-3-1">
                    		优惠券<br/>
                         	<a href="#"><font size="5" color="#f00"><?=$coupon_num?></font></a>张<br/>
                    	</div>
                    	<div class="col-md-4 htnr-r-3-1" style="border:0px;">
                    		积分<br/>
                      		<a href="#"> <font size="5" color="#f00"><?=$user['me_points']?></font></a>分<br/>
                    	</div>
                	</div>
        		</div>
        		<div class="htnr-h2">
        			<select class="sel">
        				<option>报价订单</option>
                        <!--
        				<option>订单查询</option>
                        -->
        			</select>
        			<input class="in-1" type="text" placeholder="请输入客户姓名/手机号码"></input>
        			<input class="in-2 search-jump" type="submit" value="搜索"></input>
        		</div>
        		<div class="htnr-h3">
        			<div class="htnr-h3-1">
        				报价订单概括
        				<a href="<?=site_url('order/baojia_index')?>">更多>></a>
        			</div>
            		<div class="htnr-h3-2">
            			<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/1')?>"><span><?php echo isset($order_num[1])?$order_num[1]['wait_priced']:0 ?></span><br/>待报价</a>
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/2')?>"><span><?php echo isset($order_num[1])?$order_num[1]['wait_hired']:0 ?></span><br/>待雇佣</a>
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/3')?>"><span><?php echo isset($order_num[1])?$order_num[1]['wait_pay']:0 ?></span><br/>待托管费用</a>
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/5')?>"><span><?php echo isset($order_num[1])?$order_num[1]['under_service']:0 ?></span><br/>师傅服务中</a>
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/6')?>"><span><?php echo isset($order_num[1])?$order_num[1]['wait_accept']:0 ?></span><br/>待确认验收</a>
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="<?=site_url('order/baojia_index/11')?>"><span><?php echo isset($order_num[1])?$order_num[1]['wait_evaluate']:0 ?></span><br/>待评价</a>
                		</div>
                		<div class="htnr-h3-2-2 col-md-4">
                			<a href="<?=site_url('order/baojia_index/8')?>"><span><?php echo isset($order_num[1])?$order_num[1]['under_refund']:0 ?></span><br/>申请退款中</a>
                		</div>
                		<div class="htnr-h3-2-2 col-md-4">
                			<a href="<?=site_url('order/baojia_index/9')?>"><span><?php echo isset($order_num[1])?$order_num[1]['under_arbitrate']:0 ?></span><br/>介入仲裁中</a>
                		</div>
                		<div class="htnr-h3-2-2 col-md-4">
                			<a href="<?=site_url('order/baojia_index/12')?>"><span><?php echo isset($order_num[1])?$order_num[1]['under_complain']:0 ?></span><br/>投诉处理中</a>
                		</div>
            		</div>
        		</div>
                <!--
        		<div class="htnr-h3"  >
        			<div class="htnr-h3-1">
        				定价订单概括
        				<a href="#">更多》</a>
        			</div>
            		<div class="htnr-h3-2">
            			<div class="htnr-h3-2-1 col-md-2">
            				<a href="#"><?php echo isset($order_num[2])?$order_num[2]['wait_pay']:0 ?></a><br/>待付款
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="#"><?php echo isset($order_num[2])?$order_num[2]['wait_cargo_arrive']:0 ?></a><br/>未到货
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="#"><?php echo isset($order_num[2])?$order_num[2]['under_service']:0 ?></a><br/>已到货服务中
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="#"><?php echo isset($order_num[2])?$order_num[2]['wait_accept']:0 ?></a><br/>待确认验收
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="#"><?php echo isset($order_num[2])?$order_num[2]['under_refund']:0 ?></a><br/>退款中
                		</div>
                		<div class="htnr-h3-2-1 col-md-2">
                			<a href="#"><?php echo isset($order_num[2])?$order_num[2]['under_fixed']:0 ?></a><br/>待补款
                		</div>
            		</div>
        		</div>
                -->
        		<div class="htnr-h4">
        			<div class="htnr-h4-1 col-md-6">
            			<div class="htnr-h4-1-1">
            				新闻中心
            			</div>
            			<?php foreach ($news as $value) { ?>
                		<div class="htnr-h4-1-2">
                			<a href="<?=site_url("news/detail/{$value['id']}")?>"> 
                				<img src="<?=asset("images/d12.png")?>" /><?=$value['title']?>
                				<span class="htnr-h4-1-3"><?=$value['create_time']?></span>
                			</a>
                		</div>
                 		<?php } ?>
                   		<div class="htnr-h4-1-4">
                   			<a href="<?=site_url('news/index')?>"> 更多>></a>
                   		</div>
            		</div>
            		<div class="htnr-h4-1 left-border col-md-6">
            			<div class="htnr-h4-1-1">
            				常见问题
            			</div>
            			<?php foreach($article as $key => $value){ ?>
                		<div class="htnr-h4-1-2">
                			<a href="<?=site_url("article/detail/{$value['id']}")?>"> <?=$key+1?>.<?=$value['title']?></a>
                		</div>
      					<?php } ?>
                   		<div class="htnr-h4-1-4">
                   			<a href="<?=site_url('article/index')?>"> 更多>></a>
                   		</div>
            		</div>
        		</div>
        	</div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
    $(".search-jump").click(function(){
        window.location.href = "<?=site_url('order/baojia_index')?>";
    })
</script>
