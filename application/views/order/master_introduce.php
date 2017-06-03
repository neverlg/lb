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
      <a class="on" href="<?=site_url('order/master/introduce/'.$master_id)?>">师傅介绍</a>
      <a href="<?=site_url('order/master/service/'.$master_id)?>">服务承诺</a>
    </div>

    <div class="sfzs-3-1">
      所在地区：<?=$base['area_text']?><br/>
      服务类目：<?=$base['service_category']?><br/>
      服务类型：
      <?php foreach($base['service_type'] as $val){ ?>
      <img src="<?=asset("images/121.png")?>" /><?=$val?>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php } ?>
      <br />
      
      服务区域：<?=$base['service_area_txt']?><br/>
      提货地点：<?=$base['deliver_address']?><br/>
      团队人数：<?=$base['member_num']?>人<br/>
      货车数量：<?=$base['car_num']?>辆<br/>
      职业类型：<?=$base['job_type']?><br/>
      服务时间：<?=$base['service_time_txt']?>
    </div>
    
  </div>
</div>


<?php require 'application/views/basic/bottom.php'; ?>