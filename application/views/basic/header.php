<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="<?=asset("images/51.png")?>" media="screen" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<title>乐帮到家</title>
<meta content="乐帮到家,专注,家具,电商,最后一公里,配送,安装,维修,服务" name="keywords">
<meta content="乐帮到家是一家专注于家具电商最后一公里配送安装维修的服务平台，提供在线下单预约家具同城配送、安装、维修服务，截止目前服务区域已覆盖全国超过260个城市1500区/县，通过招募全国各城市的专业师傅入驻平台，同时建立严格的考核标准体系，用系统技术来管控师傅的服务质量和时效，把服务做到专业标准化、价格透明化以及服务去中间化，严格执行到货后48小时内完成订单服务，并且提供一年的质保服务，从而可以解决线上商家的痛点和需求。我们的愿景让家具电商最后一公里服务不再是难点！" name="description">

<link rel="stylesheet" href="<?=asset("kit/bootstrap/css/bootstrap.min.css")?>" type="text/css">
<link rel="stylesheet" href="<?=asset("css/style.css")?>" />
<!--
<link href="<?=asset("css/dialog.css")?>" rel="stylesheet"/>
<script src="<?=asset("js/dialog.js")?>"></script>
<script src="<?=asset("js/common.js")?>"></script>
-->
<script src="<?=asset("kit/jquery/jquery.min.js")?>"></script>
<script src="<?=asset("kit/bootstrap/js/bootstrap.min.js")?>" ></script>

</head>

<body>

<div class="top">
    <div class="container">
	   <div class="top-1">
    	   <div class="col-md-6">
                <span class="top-1-1">欢迎你的到来！</span>
                <?php if(empty($this->session->userdata('me_username'))){ ?>
                <span class="top-1-2"><a href="<?=site_url('main/index/login')?>">请登录</a></span> 
                <span class="top-1-2"><a href="<?=site_url('auth/register')?>">免费注册&or;</a></span>
                <?php }else{ ?>
                <span>
                    <?=$this->session->userdata('me_username')?>&nbsp;&nbsp;&nbsp;
                    <?php if($this->_message_count > 0){ ?>
                        <a href="<?=site_url('message/index')?>">消息<?=$this->_message_count?></a>
                        &nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <a href="<?=site_url('auth/log_out')?>">退出</a>
                    
                </span>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <span class="top-1-3"><a href="<?=site_url('article/index')?>">帮助中心</a></span>
                <span class="top-1-3"><a href="<?=site_url('main/shortcut')?>">生成桌面图标</a></span> 
                <span class="top-1-3"><a href="<?=site_url('activity/index')?>">优惠活动</a></span>
                <span class="top-1-3"><a href="<?=site_url('main/master_settle')?>">师傅入驻</a></span>      
                <span class="top-1-3"><a href="<?=site_url('order/index')?>">我的订单</a></span>  	
            </div>
        </div>
    </div>
</div>
