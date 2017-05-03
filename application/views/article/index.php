<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="nr-1">
	<div class="container">
	   <a href="#">首页</a>》<a href="#">帮助中心</a>
  </div>
</div>

<div class="container">
	<div class="col-md-3">
    	<div class="htnr-1-1">
          帮助中心
      </div>
      <div class="htnr-tt">
      <div class="htnr-1-2">
       		常见问题
      </div> 
      <li class="bzzx-1">
        <a <?php if($category==0){echo "class='on'";} ?> href="<?=site_url('article/index/0')?>">账户相关<span class="bzzx-1-1">></span></a>
      </li>
      <li class="bzzx-1">
        <a <?php if($category==1){echo "class='on'";} ?> href="<?=site_url('article/index/1')?>">订单相关<span class="bzzx-1-1">></span></a>
      </li>
      <li class="bzzx-1">
        <a <?php if($category==2){echo "class='on'";} ?> href="<?=site_url('article/index/2')?>">付款相关<span class="bzzx-1-1">></span></a>
      </li>
      <li class="bzzx-1">
        <a <?php if($category==3){echo "class='on'";} ?> href="<?=site_url('article/index/3')?>">退款相关<span class="bzzx-1-1">></span></a>
      </li>
      <li class="bzzx-1">
        <a <?php if($category==4){echo "class='on'";} ?> href="<?=site_url('article/index/4')?>">投诉相关<span class="bzzx-1-1">></span></a>
      </li>
  </div>
  <div class="htnr-tt">
    <div class="htnr-1-2">
      用户反馈
    </div> 
    <li class="bzzx-1">
      <a href="<?=site_url('message/feedback')?>">我要反馈<span class="bzzx-1-1">></span></a>
    </li>
  </div>
    
  </div>
    <div class="col-md-9">
      <div class="bjck-1">
        <span class="bjck-1-1"><a href="javascript:void(0);"><?=$category_name?></a></span>
      </div>
      <?php foreach ($info as $key => $val) {  ?>
      <div class="bzzx-r-1">
        <a href="<?php echo site_url('article/detail/'.$category.'-'.$val['id']); ?>"><?=$key?>、<?=$val['title']?></a>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>