<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>
<?php require 'application/views/basic/top1.php'; ?>

    <div class="container">
        <div class="fxsf-1">
            <a href="#">乐帮到家</a>> <a href="#">发现师傅</a>
        </div>

        <div class="fxsf-2">
            <div class="fxsf-3 col-md-9">

                <div class="fxsf-3-1">服务区域：<select><option>选择省份</option><option>北京</option><option>上海</option></select>
                    <select><option>选择城市</option><option>北京市</option><option>上海市</option></select>
                    <select><option>选择地区</option><option>北京区</option><option>上海区</option></select><a href="#">搜索</a> <span>该地区有<font color="#f00">100</font>个师傅为你提供服务</span></div>
                <div class="fxsf-3-2">服务类型： <a class="on" href="#">不限</a><a href="#">配送</a><a href="#">配送+安装</a><a href="#">安装</a><a href="#">维修</a></div>

                <div class="fxsf-4">
                    <div class="col-md-2 fx-1"><img src="<?=asset('images/bj6.png')?>" /></div>
                    <div class="col-md-3 fx-2"><span class="fx-2-1">高阳</span>
                        <span class="fx-2-1">保证金：<img src="<?=asset('images/146.png')?>" /></span>
                        <span class="fx-2-1">信誉：<img src="<?=asset('images/bj2.png')?>"  /><img src="<?=asset('images/bj2.png')?>"  /><img src="<?=asset('images/bj2.png')?>"  /></span>
                        <span class="fx-2-1"><img src="<?=asset('images/43.png')?>"  /></span></div>
                    <div class="col-md-2 fx-3">
                        <span class="fx-3-1">总接单： <span class="fx-3-11">100单</span></span>
                        <span class="fx-3-1">总评分： <span class="fx-3-11">5.00分</span></span>
                        <span class="fx-3-1">好评率： <span class="fx-3-11">99.88%</span></span>
                        <span class="fx-3-1">投诉记录： <span class="fx-3-12">0次</span></span>
                        <span class="fx-3-1"><A href="#"><u>累计评价(88)</u></A></span>
                    </div>
                    <div class="col-md-5 fx-4">
                        <span class="fx-4-1">所在位置：九江-修水县-宁传镇</span>
                        <span class="fx-4-1">服务类型：家具类(配送，搬运，安装，维修)</span>
                        <span class="fx-4-1">服务区域：修水县,武宁县</span>
                    </div>

                </div>



                <div class="htfy" style="padding-top:10%; padding-bottom:3%;">
                    <a href="#">上一页</a> <a class="on" href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a>


                    <a href="#">下一页</a>
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