<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
        <a href="javascript:void(0);">安全设置</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck" style="clear:both; overflow:hidden;">
                <div class="bjck-1">
                    <span class="bjck-1-1"><a href="#">个人头像</a></span>
                </div>
              
                <div class="grtx-1 col-md-6 ">
                    <div id="preview">
                        <img id="imghead" border="0" src="<?=asset("images/327111644.png")?>" width="300" height="300"   >
                    </div>         
                <input type="file" style="display: none;" id="previewImg">
              
                <div class="qbmm-1-1">
                    <button type="submit">保存</button>
                </div>
            </div>

            <div class="grtx-2 col-md-6 ">
                <font size="4">效果预览图</font><br/>
                您上传的图片将会自动生成三种尺寸头像，请注意中小尺寸的头像是否清晰。<br/><br/>
                <div id="preview" class="avatar-preview">
                    <img id="imghead" border="0" src="<?=asset("images/2308.png")?>" width="120" height="120" >
                </div>         
                125*125<br/><br/>

                <div id="preview" class="avatar-preview">
                    <img id="imghead" border="0" src="<?=asset("images/2308.png")?>" width="100" height="100" >
                </div>         
                100*100<br/><br/>

                <div id="preview"  class="avatar-preview">
                    <img id="imghead" border="0" src="<?=asset("images/2308.png")?>" width="60" height="60">
                </div>         
                60*60<br/>
            </div>
		</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<!--消息提示-->
<div class="tips-info" id="tips-box" style="display:none;">
  <div class="lb_mask"></div>
  <div class="tips-msg">
        <div class="tt-2-1">温馨提示： <img src="<?=asset("images/02418.png")?>" class="close-tips" /></div>
        <div class="tt-2-2" id="tips-text"></div>
        <div class="tt-2-8"><button id="confirm-tips">确定</button></div>
    </div>
</div>

<script type="text/javascript">
    var $tipBox = $("#tips-box");

    

    function showTip(msg, url){
        $("#tips-text").html(msg);
        if(url){
            $tipBox.show().delay(2000).hide(0);
            setTimeout(function(){
                window.location.href = url;
            },1000);
        }else{
            $tipBox.show().delay(2000).hide(0);
        }
    }

    $("#confirm-tips").click(function(){
        $tipBox.hide();
    });
</script>
