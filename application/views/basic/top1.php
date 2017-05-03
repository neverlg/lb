<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">  
    <div class="top-2">
    	<div class="col-md-4 top-2-1">
            <img src="<?=asset("images/logo.png")?>" />
			<span></span>
			<p><img src="<?=asset("images/top-1.png")?>" /><em>让家具售后服务更便捷</em></p>
        </div>
        <div class="col-md-8">
        	<div class="top-2-2">
            	<a <?php if(empty($this->_current_method) || ($this->_current_controller=='main' && $this->_current_method=='index')){echo "class='on'";} ?> href="<?=site_url('main/index')?>">首页</a>
                <a <?php if($this->_current_method=='service'){echo "class='on'";} ?> href="<?=site_url('main/service')?>">服务方式</a>
                <a href="#">发现师傅</a>
                <a <?php if($this->_current_method=='guarantee'){echo "class='on'";} ?> href="<?=site_url('main/guarantee')?>">服务保障</a>
                <a <?php if($this->_current_method=='about_us'){echo "class='on'";} ?> href="<?=site_url('main/about_us')?>">关于我们</a>
            </div>
        </div>
    </div>
</div>