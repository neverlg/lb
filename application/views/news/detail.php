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
        <a href="<?=site_url('news/index/5')?>">公司新闻</a>
      </div> 
    </div>
    <div class="htnr-tt">
      <div class="htnr-1-2 <?php if($category==6){echo 'on';}?>">
        <a href="<?=site_url('news/index/6')?>">行业新闻</a>
      </div> 
    </div>
  </div>

  <div class="col-md-9">
    <div class="bjck">
      <div class="bjck-1">
        <span class="bjck-1-1"><a href="javascript:void(0)"><?=$category_name?></a></span>
        <span class="wdxx-1"><a href="javascript:history.back();">返回消息列表》</a></span>
      </div>
            
      <div class="wdxx-2" style="text-align:center;">
        <?=$detail['title']?><br/>
        <font class="wdxx-222" >来源：乐帮到家&nbsp;&nbsp;&nbsp;<?=$val['create_time']?></font>
      </div>
      <div class="wdxx-2">
        <?=$detail['__content']?>
      </div>
    </div>
  </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>