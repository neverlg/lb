<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<script src="<?=asset("kit/localresizeimg/lrz.bundle.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
    <a href="javascript:void(0);">投诉管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1">
        			<a>发起投诉</a></span>
        		</div>

              	<div class="tjpj-13" style="margin-bottom:15px;" >
              		<font><b>温馨提示：发起对师傅投诉需要充实的证据，平台客服将会根据您所提交的证据信息进行调查取证，属实则投诉成立。</b></font>
              	</div>
            
            	<div class="pjgl-2-1">
                	订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;
                	订单金额：<?=$order['merchant_price']?>元  &nbsp;&nbsp;
                	师傅名字：<?=$order['master_name']?>（<?=$order['phone']?>）
                </div>
            	
            	<form id="addcom-fm" action="<?=site_url('complain/add_submit/'.$order_id)?>" method="post">
             	<div class="tjpj-12">
              		<div class="tjpj-1">
            			<b style="float:left;"><font color="#f00">*</font>投诉类别：</b>
            			<select name="category" id="category" required>
		        			<option value="">请选择投诉类别</option>
		        			<option value="1">师傅服务不诚信</option>
		        			<option value="2">师傅服务不规范</option>
            			</select>
            			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            			<select name="subcategory" id="subcategory" required>
	            			<option>请选择投诉小类别</option>
            			</select>
            		</div>

            		<div class="tjpj-1">        
            			<b style="float:left;"><font color="#f00">*</font>投诉内容：</b>
            			<textarea name="content" cols="51" rows="4" required placeholder="说说你对师傅的评价！（5-100字内）"></textarea>
            		</div>

             		<div class="tjpj-1">
            			<b style="float:left;">
            			<font color="#f00">*</font>上传证据：</b>
            			&nbsp;<font color="#999">(最多5张，小于2M)</font>
            			<div id="preview1">
            				<div id="imgFile">
          						<!-- 图片区域 -->
        					</div>
					        <a href="javascript:void(0)" class="upload-file">
					            <input type="file" id="fileupload1" name="FileContent" />
					        </a>
        					<div class="clear"></div>
 						</div>         
            		</div>      
            	</div>

                <div class="tjpj-13"> 
                	<button type="submit" style="margin-left:20px;">提交评价</button>
                	&nbsp;&nbsp;&nbsp;&nbsp;温馨提示：确认提交前请仔细核查投诉的内容，一旦提交不可修改。
                </div>
                </form> 
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
	var $imgCount = 0;
	var $category_conf = <?=$__category?>;
  	var upImgageToken = "<?=$up_token?>";
  	var up_url = "<?=$upload_url?>";
  	var source_url = "<?=$source_url?>";

  	//option
  	$("#category").change(function(){
  		var cat = $("#category").val();
  		var html = "";
  		if(cat != ''){
  			$.each($category_conf[cat], function(i, n){
  				html += "<option value='"+i+"'>"+n+"</option>";
  			});
  		}else{
  			html += "<option value=''>请选择投诉小类别</option>";
  		}
  		$("#subcategory").html(html);
  	});

  	 //7niu
  	document.querySelector('#fileupload1').addEventListener('change',function(){
      lrz(this.files[0],
        {width:600}
        ).then(function(rst){
          //rst.formData.append('FileContent',rst.base64);
          putb64(rst.base64);
        });
  	});

  	function putb64(picBase){
      /*把字符串转换成json*/
      function strToJson(str) { 
          var json = eval('(' + str + ')');
          return json; 
      }
      //此处需要将base64的前缀干掉
      var cutTag = picBase.indexOf(';base64,') + 8;
      picBase=picBase.substring(cutTag);

      var url = up_url + "/putb64/-1" ; //非华东空间需要根据注意事项 1 修改上传域名
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange=function(){
        if (xhr.readyState==4){
            var keyText=xhr.responseText;
            /*返回的key是字符串，需要装换成json*/
            keyText=strToJson(keyText);
            /* http://image.haoqiure.com/ 是我的七牛云空间网址，keyText.key 是返回的图片文件名*/
            picUrl= source_url + keyText.key;
            $("#imgFile").append("<img src='"+picUrl+"'></img> <input type='hidden' name='img[]' value='"+keyText.key+"' />");
            $imgCount++;
            if($imgCount >= 5){
              $(".upload-file").hide();
            }
            console.log(picUrl);
        }
      }
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/octet-stream");
      xhr.setRequestHeader("Authorization", "UpToken "+upImgageToken+"");
      xhr.send(picBase);
  	}

  	//提交表单
  	$("#addcom-fm").submit(function(){
  		if($imgCount == 0){
  			showTip('<h4>请上传证据</h4>');
  		}else{
  			$.ajax({
	          type:"post",
	          url:$("#addcom-fm").attr('action'),
	          data:$("#addcom-fm").serialize(),
	          success:function(msg){
		            if(msg.status == 0){
		              var url = "<?=site_url('complain/index')?>";
		              showTip('<h4>感谢您的投诉，我们会尽快处理</h4>', url);
		            }else{
		              showTip('<h4>'+msg.error+'</h4>');
		            }
          		}
        	});
  		}
  		return false;
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