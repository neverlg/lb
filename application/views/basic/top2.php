<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">  
    <div class="top-2">
        <div class="col-md-4 top-2-1">
            <img src="<?=asset("images/logo.png")?>" />
            <span></span>
            <p style="font-size:20px; color:#000;  line-height:80px;">后台管理中心</p>
        </div>
        <div class="col-md-8">
            <div class="top-g-1">
                <span class="top-g-11">
                    <a href="<?=site_url('order/baojia')?>" class="top-g-1-1">发布订单获取多个师傅报价 ></a> 
                </span> 
                <span class="top-g-12">
                    <a href="<?=site_url('auth/priced_apply')?>" class="top-g-1-2">专属客服定价 快速批量下单 ></a>
                </span>
            </div>
        </div>
    </div>
</div>