<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<link rel="stylesheet" href="<?=asset("kit/cropper/css/cropper.css")?>">
<script src="<?=asset("kit/cropper/js/cropper.js")?>"></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">个人头像</a>
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

                <div class="bjck-1">
                    <span style="font-size:18px;font-weight:bold;padding-left:8px;">选择图片</span>
                    <input id="upload_file" type="file" style="display:inline;" />
                </div>

                <div class="col-md-8">
                    <div id="preview">
                        <img id="imghead" class="cropper-hidden" border="0" src="<?=asset("images/327111644.png")?>">
                        <div id="at-beginning" class="cropper-container cropper-bg" style="width: 567px; height: 500px;"><div class="cropper-wrap-box"><div class="cropper-canvas" style="width: 567px; height: 273.442px; transform: translateY(113.279px);"><img src="" style="width: 567px; height: 273.442px; transform: none;"></div></div><div class="cropper-drag-box cropper-modal cropper-crop"></div><div class="cropper-crop-box" style="width: 218.754px; height: 218.754px; transform: translateX(174.123px) translateY(140.623px);"><span class="cropper-view-box"><img src="" style="width: 567px; height: 273.442px; transform: translateX(-174.123px) translateY(-27.3442px);"></span><span class="cropper-dashed dashed-h"></span><span class="cropper-dashed dashed-v"></span><span class="cropper-center"></span><span class="cropper-face cropper-move"></span><span class="cropper-line line-e" data-action="e"></span><span class="cropper-line line-n" data-action="n"></span><span class="cropper-line line-w" data-action="w"></span><span class="cropper-line line-s" data-action="s"></span><span class="cropper-point point-e" data-action="e"></span><span class="cropper-point point-n" data-action="n"></span><span class="cropper-point point-w" data-action="w"></span><span class="cropper-point point-s" data-action="s"></span><span class="cropper-point point-ne" data-action="ne"></span><span class="cropper-point point-nw" data-action="nw"></span><span class="cropper-point point-sw" data-action="sw"></span><span class="cropper-point point-se" data-action="se"></span></div></div>
                    </div>

                    <input type="hidden" id="img_url">
                    <div class="qbmm-1-6">
                        <button class="xz">旋转</button>
                        <button class="qd">确定</button>
                    </div>
                </div>

                <div class="grtx-2 col-md-4 ">
                    <font size="4">效果预览图</font><br/>
                    您上传的图片将会自动生成三种尺寸头像，请注意中小尺寸的头像是否清晰。<br/><br/>
                    <div class="preview">
                        <img class="pre-view" border="0" src="<?=asset("images/2308.png")?>" width="120" height="120" >
                    </div>         
                    125*125<br/><br/>

                    <div class="preview">
                        <img class="pre-view" border="0" src="<?=asset("images/2308.png")?>" width="100" height="100" >
                    </div>         
                    100*100<br/><br/>

                    <div class="preview">
                        <img class="pre-view" border="0" src="<?=asset("images/2308.png")?>" width="60" height="60">
                    </div>         
                    60*60<br/>
                </div>
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
    var upImgageToken = "<?=$up_token?>";
    var up_url = "<?=$upload_url?>";
    var source_url = "<?=$source_url?>";
    
    $("body").on("change","#upload_file",function(){
        var $file = $(this);
        var fileObj = $file[0];
        var windowURL = window.URL || window.webkitURL;
        var dataURL;
        var $img = $("#imghead");
        if(fileObj && fileObj.files && fileObj.files[0]){
            dataURL = windowURL.createObjectURL(fileObj.files[0]);
            $img.attr('src',dataURL);
        }else{
            dataURL = $file.val();
            var imgObj = document.getElementById("imghead");
            imgObj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
            imgObj.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = dataURL;      
        }
        //隐藏初始的格子背景
        $("#at-beginning").hide();
        $img.cropper({
            aspectRatio: 1/1,         //1 / 1,  //图片比例,1:1
            crop: function(data){
                var $imgData=$img.cropper('getCroppedCanvas');
                var dataurl = $imgData.toDataURL('image/png');
                $(".pre-view").attr("src",dataurl);
            },
            built: function(e){
            }
        });
        console.log(dataURL);
        $img.cropper('replace',dataURL);

        $(".xz").on("click",function(){
            $img.cropper('rotate', 90);
        })

        $("body").unbind("click").on("click",".qd",function(){ 
            var $imgData=$img.cropper('getCroppedCanvas');
            var dataurl = $imgData.toDataURL('image/png');  //dataurl便是base64图片
            console.log(dataurl);
            putb64(dataurl);
        })
    });

    //七牛云官方文档方法
    function putb64(picBase){   
        /*picUrl用来存储返回来的url*/
        var picUrl;
        /*把头部的data:image/png;base64,去掉。（注意：base64后面的逗号也去掉）*/
        picBase=picBase.substring(22);
        /*通过base64编码字符流计算文件流大小函数*/
        function fileSize(str) {
            var fileSize;
            if(str.indexOf('=')>0)  {
                var indexOf=str.indexOf('=');
                str=str.substring(0,indexOf);//把末尾的’=‘号去掉
            }
            fileSize=parseInt(str.length-(str.length/8)*2);
            return fileSize;
        }
        /*把字符串转换成json*/
        function strToJson(str) { 
            var json = eval('(' + str + ')');
            return json; 
        } 
        //注意不同区域的七牛地址不一致
        var url = up_url + "/putb64/" + fileSize(picBase);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function(){
            if (xhr.readyState==4){
                var keyText=xhr.responseText;
                /*返回的key是字符串，需要装换成json*/
                keyText=strToJson(keyText);
                /* http://image.haoqiure.com/ 是我的七牛云空间网址，keyText.key 是返回的图片文件名*/
                picUrl= source_url + keyText.key;
                console.log(picUrl);
                $("#img_url").val(keyText.key);   //去掉域名
                //提交表单
                submit_avatar(keyText.key);
            }
        }
        xhr.open("POST", url, true); 
        xhr.setRequestHeader("Content-Type", "application/octet-stream"); 
        xhr.setRequestHeader("Authorization", "UpToken "+upImgageToken+""); 
        xhr.send(picBase);
    }

    //提交表单
    function submit_avatar(url){
        if(url != ''){
            $.ajax({
                type:"post",
                url:"<?=site_url('account/avatar_submit')?>",
                data:{url:url},
                success:function(msg){
                    if(msg.status == 0){
                        window.location.href = "<?=site_url('account/index')?>";
                    }else{
                        showTip("<h4>"+msg.error+"</h4>");
                    }
                }
            });
        }
    }

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
