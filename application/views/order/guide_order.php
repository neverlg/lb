<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="#">报价下单</a>
	</div>
</div>

<div class="container">
    <div class="smaz">
        <div class="smza-1">
            你选择的是<font color="#f00">报价订单</font>服务方式(<font color="#f00">发布订单获取多个师傅报价</font>)
        </div>
        <div class="smza-1-1">
            <img src="<?=asset("images/134404.png")?>" />服务流程:
        </div>
        <div class="bjxq-2" style="border-bottom:1px solid #ccc; padding-bottom:0px; clear:both; overflow:hidden;">
            <li class="bjxq-2-1"><a href="#">1</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-40px;" style="margin-top:10px;" color="#000" size="3">发布订单</font></a></li></li>  
            <li class="bjxq-2-1"><a href="#">2</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">多个师傅报价</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">3</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">挑选师傅雇佣</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">4</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">托管服务费用</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">5</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">师傅服务中</b></font></a></li></li>
            <li class="bjxq-2-1"><a href="#">6</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">验收确定放款</font></a></li></li>
            <li class="bjxq-2-1" style="width:120px;" ><a href="#">7</a></li>
            <li style="margin-left:-143px; margin-top:28px; color:#000; font-size:16px;" >评价师傅</li>
        </div>
        
        <div class="smza-2">
            <img src="<?=asset("images/141227.png")?>" />
            <b>服务类型:</b>
            <a href="<?=site_url('order/baojia/4')?>">提货配送上门</a>
            <a href="<?=site_url('order/baojia/1')?>">提货配送上门+安装</a>
            <a href="<?=site_url('order/baojia/2')?>">上门安装</a>
            <a href="<?=site_url('order/baojia/3')?>">上门维修</a>
            <a href="<?=site_url('order/baojia/5')?>">打包返货</a>
        </div>
    </div>
</div> 

<?php require 'application/views/basic/bottom.php'; ?>


