<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>
<?php require 'application/views/basic/top1.php'; ?>

    <script src="<?=asset("js/vue.js")?>"></script>
    <script src="<?=asset("dist/common.js")?>"></script>
    <script src="<?=asset("dist/master/discover.js")?>"></script>

    <div class="container">
        <div class="fxsf-1">
            <a href="#">乐帮到家</a>> <a href="#">发现师傅</a>
        </div>

        <div class="fxsf-2" id="div">
            <div class="fxsf-3 col-md-9">

                <form action="" method="get">
                <div class="fxsf-3-1">服务区域：
                    <area-selector name="areaId" selectd-province="<?=@$provinceId?>" selectd-city="<?=@$cityId?>" selectd-district="<?=@$districtId?>"></area-selector>
                    <button type="submit" style="background: none;border:none;"><a>搜索</a></button>
                    <?php if (!empty($count)):?>
                    <span>该地区有<font color="#f00"><?=$count?></font>个师傅为你提供服务</span>
                    <?php endif;?>
                </div>
                </form>
                <div class="fxsf-3-2">服务类型：
                    <a <?=empty($service_type)?'class="on"':''?> href="?areaId=<?=$area_id?>">不限</a>
                    <a <?=$service_type==1?'class="on"':''?> href="?areaId=<?=$area_id?>&service_type=1">配送</a>
                    <a <?=$service_type=='1,2'?'class="on"':''?> href="?areaId=<?=$area_id?>&service_type=1,2">配送+安装</a>
                    <a <?=$service_type==2?'class="on"':''?> href="?areaId=<?=$area_id?>&service_type=2">安装</a>
                    <a <?=$service_type==3?'class="on"':''?> href="?areaId=<?=$area_id?>&service_type=3">维修</a></div>

                <?php if (empty($list)):?>
                    <div style="text-align:center;font-size:20px;padding-top:50px;">请选择服务区域搜索发现师傅......</div>
                <?php else:?>
                    <?php foreach ($list as $row):?>
                <div class="fxsf-4">
                    <div class="col-md-2 fx-1"><img src="<?=$row['head_img']?>" /></div>
                    <div class="col-md-3 fx-2"><span class="fx-2-1"><?=$row['real_name']?></span>
                        <span class="fx-2-1">保证金：<img src="<?=asset('images/fund_img.jpg')?>"  /><?=$row['assure_fund']?>元</span>
                        <span class="fx-2-1">信誉：<?=htmlspecialchars_decode($row['stars'])?></span>
                        <span class="fx-2-1" style="color:#0fb7db">承诺6项服务</span></div>
                    <div class="col-md-2 fx-3">
                        <span class="fx-3-1">总接单： <span class="fx-3-11"><?=$row['order_count']?>单</span></span>
                        <span class="fx-3-1">总评分： <span class="fx-3-11"><?=$row['avg_score']?>分</span></span>
                        <span class="fx-3-1">好评率： <span class="fx-3-11"><?=$row['praise_rate']?>%</span></span>
                        <span class="fx-3-1">投诉记录： <span class="fx-3-12"><?=$row['complain_count']?>次</span></span>
                        <span class="fx-3-1"><A href="#"><u>累计评价(<?=$row['evaluate_count']?>)</u></A></span>
                    </div>
                    <div class="col-md-5 fx-4">
                        <span class="fx-4-1">所在位置：<?=$row['area_text']?></span>
                        <span class="fx-4-1">服务类型：家具类(<?=$row['service_type_text']?>)</span>
                        <span class="fx-4-1">服务区域：<?=$row['service_area_text']?></span>
                    </div>

                </div>
                        <?php endforeach ?>
                <?php endif;?>



                <div class="htfy" style="margin-top:25px;">
                    <?=@$__pagination_url?>
                </div>


            </div>
            <div class="fxsf-5 col-md-3">
                <div class="fx-r-1"><a href="<?=site_url('order/baojia')?>">发布订单获取师傅报价</a></div>
                <div class="fx-r-2">
                    <div class="fx-r-2-1">常见问题</div>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                    <li class="fx-r-2-2"><a href="#">办公转椅轮子怎么拆卸更换？</a></li>
                </div>
            </div>

        </div>



    </div>


<?php require 'application/views/basic/bottom.php'; ?>

