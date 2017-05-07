<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="nr-1">
	<div class="container">
	   <a href="<?=site_url('main/index')?>">首页</a>》<a href="javascript:void(0);">新闻中心</a>
  </div>
</div>

<div class="container">
  <div class="col-md-3" style="height:500px;">
    <div class="htnr-1-1">
      管理中心首页
    </div>
    <div class="htnr-tt">
      <div class="htnr-1-2 <?php if($category==5){echo 'on';}?>">
        <a href="<?=site_url('news/index')?>">公司新闻</a> 
      </div> 
    </div>
    <div class="htnr-tt">
      <div class="htnr-1-2 <?php if($category==6){echo 'on';}?>">
        <a href="<?=site_url('news/index/1')?>">行业新闻</a>
      </div> 
    </div>
  </div>

  <div class="col-md-9" style="border:1px solid #eee; height:600px;">
    <div class="bjck-1">
      <span class="bjck-1-1"><a href="#">公司新闻</a></span>
    </div>
    <?php foreach($info as $key => $val){ ?>
    <div class="bzzx-r-1">
      <a href="<?php echo site_url('news/detail/'.$category.'-'.$val['id']); ?>">
        <img src="<?=asset("images/64240.png")?>" /><?=$val['title']?>
        <span class="zx-sj"><?=date('Y-m-d H:i', $val['add_time'])?></span>
      </a>
    </div>
    <?php } ?>
  </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>