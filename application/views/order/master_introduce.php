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

      <div class="sfzs-3"><a class="on" href="#">用户评价(<?=$local_num?>)</a></div>
      <div class="pjgl-1">
          <form method="get" action="" id="form">
          <input name="ptype" type="radio" value="-1" checked="checked" onclick="$('#form').submit()">全部
          <input name="ptype" type="radio" value="1" <?=@$_GET['ptype'] == 1 ? 'checked="checked"' : ''?> onclick="$('#form').submit()"><img src="<?=asset('images/4159.png')?>" width='25'/>好评
          <input name="ptype" type="radio" value="2" <?=@$_GET['ptype'] == 2 ? 'checked="checked"' : ''?> onclick="$('#form').submit()"><img src="<?=asset('images/33.png')?>" width='25'/>中评
          <input name="ptype" type="radio" value="3" <?=@$_GET['ptype'] == 3 ? 'checked="checked"' : ''?> onclick="$('#form').submit()"><img src="<?=asset('images/250.png')?>" width='25'/>差评
          </form>
      </div>
      <?php foreach ($local_list as $val): ?>
          <div class="sjzs-1">
              <div class="pjgl-2-2"><?=$val['me_username']?>(下单用户)&nbsp;&nbsp;&nbsp;
              <?php if ($val['oe_score']==1):?>
                      <img src="<?=asset('images/4159.png')?>" width='20'/>好评
              <?php elseif ($val['oe_score']==2):?>
                  <img src="<?=asset('images/33.png')?>" width='20'/>中评
              <?php elseif ($val['oe_score']==3):?>
                      <img src="<?=asset('images/250.png')?>" width='20'/>差评
              <?php endif;?>
                  | 服务质量<font color="#f00"> <?=$val['oe_quality']?>分</font>  服务态度 <font color="#f00"> <?=$val['oe_attitude']?>分</font>  服务时效 <font color="#f00"> <?=$val['oe_ontime']?>分</font><span class="sfsj" style=" padding-left:20px;"><?=date('Y-m-d H:i:s',$val['oe_add_time'])?></span> </div>
              <?php if ($val['oe_type']==1):?>
                  <div class="pjgl-2-2" style="color:#999;">系统自动默认好评！(超过15天)
<!--                      <br/><img src="images/10650.png" width="140" style="padding:10px;" />-->
                  </div>
              <?php else:?>
                  <div class="pjgl-2-2">我的评价：<?=$val['oe_content']?>
<!--                      <br/><img src="images/10650.png" width="140" style="padding:10px;" />-->
                  </div>
              <?php endif;?>
            <?php if (!empty($val['oe_response'])):?>
                <div class="pjgl-2-3">师傅解释：<?=$val['oe_response']?> </div>
            <?php endif;?>
          </div>
      <?php endforeach;?>
      <div class="htfy" style="margin-top:25px;">
          <?=$__pagination_url?>
      </div>
  </div>


<?php require 'application/views/basic/bottom.php'; ?>