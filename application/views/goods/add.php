<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<link rel="stylesheet" href="<?=asset("kit/uploadify/uploadify.css")?>" type="text/css">
<script src="<?=asset("kit/uploadify/jquery.uploadify.min.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
		<a href="<?=site_url('order/baojia_index')?>">报价订单管理</a>》
        <a href="javascript:void(0);">货品仓库</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
            <form id="addgoods-fm" action="<?=site_url('goods/add_submit/'.$priced_type)?>" method="post" >
    		<div class="bjck-eg">
        		<div class="bjck-1">
                    <span class="bjck-1-1"><a>货品仓库</a></span>
                    <span class="bjck-1-2"><a href="javascript:history.go(-1);">返回货品列表》</a></span>
                </div>
        
                <div class="sctp-1">
                    <!--
                    <a href="#"><img src="<?=asset("images/sc15.png")?>" /></a> 
                    -->
                    <input type="file" name="uploadify" id="uploadify" />
                    提示：按着"Ctrl"一次可以选择多张相片。 
                    <span style="float:right;">已添加<font color="#f00" id="number_img">0</font>张</span>
                </div>
        	</div>
          	<div class="sctp-1-1"> 
          		<span class="sctp-1-2" ><button type="submit">确定</button></span>
          		<span class="sctp-1-3" ><button>取消</button></span>
            </div>
            </form>
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
    var $imgCount = 0;
    var upImgageToken = "<?=$up_token?>";
    var up_url = "<?=$upload_url?>";
    var source_url = "<?=$source_url?>";

	//upload
    //$(".sctp-1").before('<h1>99999999999</h1>');
    $("#uploadify").uploadify({
        'buttonText': '上传图片',
        'swf': "<?=asset('kit/uploadify/uploadify.swf')?>",
        'method': 'POST',
        'uploader': up_url,
        'formData': {'token':upImgageToken},
        'fileObjName': 'file',
        'fileSizeLimit': '2MB',
        'fileTypeExts': '*.jpg;*.png;*.bmp;*.jpeg;',
        'onUploadStart': function(file){

        },
        'onUploadError':function(event,queueId,fileObj,errorObj){
            console.log(errorObj);  
            showTip("<h4>上传失败！请稍后再试！</h4>");  
        },
        'onUploadSuccess' : function(file, data, response) {  
            if (response == true) {   
                var t =  jQuery.parseJSON(data);  
                var key = t.key; 
                var img = source_url+key;
                $imgCount++;
                //console.log(source_url+key);

                var html = '<div class="bjck-t"><div class="goods-cancel" ><img src="<?=asset("images/02418.png")?>" /></div><div class="col-md-4 bjck-t1"><img src="'+img+'" /><input name="img[]" type="hidden" value="'+key+'"></div><div class="col-md-8 bjck-t2"><font color="#f00">*</font>货品类目：<select name="type[]" required><option value="">请选择货品类目</option><option value="1">柜类</option><option value="2">床类</option><option value="3">床垫类</option><option value="4">桌类</option><option value="5">茶几类</option><option value="6">架类</option><option value="7">沙发类</option><option value="8">椅类</option><option value="9">屏风隔断</option><option value="10">办公类</option><option value="12">坐具类</option></select><br/><font color="#f00">*</font>货品名称：<input name="name[]" type="text" required /></div></div>';
                $(".sctp-1").before(html);
                $("#number_img").text($imgCount);
            }
        } 
    });

	//submit
    $("#addgoods-fm").submit(function(){
        if($imgCount == 0){
            showTip('<h4>请上传货品图片</h4>');
        }else{
            $.ajax({
                type:'post',
                url:$("#addgoods-fm").attr('action'),
                data:$("#addgoods-fm").serialize(),
                success:function(msg){
                    if(msg.status == 0){
                        var url = "<?=site_url('goods/index/'.$priced_type)?>";
                        showTip('<h4>您已成功上传'+$imgCount+'张货品图片</h4>', url);
                    }else{
                        showTip('<h4>'+msg.error+'</h4>');
                    }
                }
            });
        }
        return false;
    });

    //close goods
    $(".bjck-eg").on('click', '.goods-cancel', function(){
        $imgCount--;
        $(this).parent('.bjck-t').html('').fadeOut();
        $("#number_img").text($imgCount);
    });

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