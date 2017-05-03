<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="czcg">
  <div class="container">
    <div class="czcg-1">
      <img src="<?=asset("images/dui18.png")?>" />
      <font color="#82da4e" size="5">充值成功！</font><br/><br/>
      充值金额：<font color="#f00" size="3"><?=$fee?>元</font><br/><br/><br/><br/>
      <a href="<?=site_url('ewallet/index')?>">查看钱包余额</a>
    </div>
  </div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>