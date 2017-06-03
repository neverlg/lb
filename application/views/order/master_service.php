<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
  <div class="container">
    <a href="<?=site_url('main/index')?>">首页</a>》<a>师傅信息</a>
  </div>
</div>

<div class="sfzs">
  <div class="container">
    <div class="sfzs-1">
      <img style="width:125px;height:126px;" src="<?=$base['head_img']?>" /><br/><br/>
      <?=$base['real_name']?>
    </div>
    
    <div class="sfzs-2">
        <li>
          <img src="<?=asset("images/138.png")?>" /><br/>
          保证金<br/>
          <?php if($statistic['assure_fund']==0){ ?>
          <font color="#999">暂未缴纳</font>
          <?php }else{ ?>
          <img class="fund-img" src="<?=asset("images/fund_img.jpg")?>"><span class="fund-txt"><?=$statistic['assure_fund']?>元</span></br>
          <?php } ?>
        </li>
        <li><img src="<?=asset("images/139.png")?>" /><br/>信誉<br/><?=$statistic['__score_icon']?></li>
        <li><img src="<?=asset("images/140.png")?>" /><br/>总接单<br/><font color="#FF9933"><?=$statistic['order_count']?>单</font></li>
        <li><img src="<?=asset("images/141.png")?>" /><br/>总评分<br/><font color="#FF9933"><?=$statistic['score_sum']?>分</font></li>
        <li><img src="<?=asset("images/142.png")?>" /><br/>好评率<br/><font color="#FF9933"><?=$statistic['good_rat']?></font></li>
        <li><img src="<?=asset("images/143.png")?>" /><br/>投诉次数<br/><font color="#FF9933"><?=$statistic['complain_count']?>次</font></li>
        <li><img src="<?=asset("images/144.png")?>" /><br/>实名认证<br/><img src="<?=asset("images/145.png")?>" /></li>
    </div>

    <div class="sfzs-3">
      <a href="<?=site_url('order/master/introduce/'.$master_id)?>">师傅介绍</a>
      <a class="on" href="<?=site_url('order/master/service/'.$master_id)?>">服务承诺</a>
    </div>

    <div class="sfzs-wf">
      <?php if(!empty($base['extra_tmall_examine'])){ ?>
      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />提供喵师傅核销</span>
      <?php } ?>

      <?php if(!empty($base['extra_storage'])){ ?>
      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />提供货品仓储服务</span>
      <?php } ?>

      <?php if(!empty($base['extra_move_free'])){ ?>
      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />提供免费平移服务</span>
      <?php } ?>

      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        货到后<?=$base['extra_finish_in']?>小时内完成任务
      </span>

      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        空跑费<?=$base['extra_nothing_fee']?>元/次
      </span>

      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        服务<?=$base['extra_repair_free']?>个月内免费维修
      </span>

      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        步梯在<?=$base['extra_floor_free']?>楼及以下免费搬楼
      </span>

      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        搬楼费<?=$base['extra_carry_fee']?>元每件(25公斤以上)
      </span>
      
      <span class="sfzs-wf-1"> <img src="<?=asset("images/121.png")?>" />
        无物流地址提货，超过30公里以外的按<?=$base['extra_far_fee']?>元/公里加收
      </span>
    </div>
    
  </div>
</div>


<?php require 'application/views/basic/bottom.php'; ?>