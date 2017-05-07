<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>
<script src="<?=asset("kit/localresizeimg/lrz.bundle.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="<?=site_url('order/index')?>">后台管理中心</a>》
    <a href="javascript:void(0);">退款管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		  <div class="bjck" style="padding-bottom:0px;">
              <div class="bjck-1">
                  <span class="bjck-1-1" ><a>退款管理</a></span>
              </div>

              <div class="tscl-1">
                退款状态：<font color="#f00">师傅拒绝退款</font>
                <a style="float:right; " href="<?=site_url('refund/edit/'.$order_id)?>">重新申请退款</a>  &nbsp;&nbsp;
                <a style="float:right;margin-right:15px;cursor:pointer;" id="apply-zc">申请介入仲裁</a>
              </div>

              <div class="pjgl-2-1">
                  订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;
                  订单金额：<?=$order['merchant_price']?>元  &nbsp;&nbsp;
                  支付方式：<?=$order['pay_type']?>
              </div>
                
              <div class="tscl-2">
                  <div class="col-md-6 tscl-2-1" >
                  <br/>
                      <font color="#FFCC33" size="4">  申请退款信息</font><br/>
                      退款编号：<?=$refund['order_number']?><br/>
                      退款时间：<?=$refund['refund_time_txt']?><br/>
                      退款类型：<?=$refund['refund_type']?><br/>
                      退款金额：<font color="#f00"><?=$refund['refund_amount']?>元</font><br/>
                      退回方式：<?=$refund['refund_method']?><br/>
                      退款说明：<?=$refund['refund_reason']?><br/>                      
                  </div>
                  <div class="col-md-6 tscl-3-1" >
                  <br/>
                      <font color="#FFCC33" size="4">  师傅处理结果</font><br/>
                      处理操作：<font color="#f00">拒绝退款</font><br/>
                      处理时间：<?=$refund['refund_result_time']?><br/>
                      处理金额：<font color="#f00"><?=$refund['refund_amount']?>元</font><br/>
                      退款说明：<?=$refund['refund_refuse_reason']?>
                  </div>
              </div>
          </div>
    	</div>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<!--申请仲裁弹框-->
<div class="tips-info" id="zc-box" style="display:none;">
  <div class="lb_mask"></div>
  <div class="sqzc-1">
    <div class="sqzc-1-1">
      申请介入仲裁
      <img id="close-zc" src="<?=asset("images/02418.png")?>" width="30" style="cursor:pointer;"/>
    </div>
    <div class="sqzc-1-2">
      仲裁说明：提交申请平台客服接入仲裁，即表示你同意平台客服的最终仲裁金额处理。<br/>平台客服申请仲裁后将在3个工作日内对双方纠纷进行取证核实。
    </div>
    <form id="addzc-fm" action="<?=site_url('refund/add_arbitrate/'.$order_id)?>" method="post">
    <div class="qbmm-1">
      <font color="#f00">*</font>申请人姓名：
      <input name="name" type="text" required><br/>

      <font color="#f00">*</font>申请人手机：
      <input name="phone" type="text" required pattern="^1[3,5,8]\d{9}$"><br/>&nbsp; &nbsp;

      <font color="#f00">*</font>纠纷说明：
      <textarea name="explain" cols="40" rows="4" style="color:#999; font-weight:500;" placeholder="请写双方纠纷的详情...(100字以内)" required></textarea><br/><br/>

      <font color="#f00">*</font>上传证据：<span style="color:#999">(最多3张，小于2M)</span><br/>
      <div id="preview1" style="margin-left:70px;">
        <div id="imgFile">
          <!-- 图片区域 -->
        </div>
        <a href="javascript:void(0)" class="upload-file">
          <input type="file" id="fileupload1" name="FileContent" />
        </a>
        <div class="clear"></div>
      </div>
      <!--         
      <input type="file" style="display: none;" id="previewImg">
      -->
    </div>
                
    <div class="sqzc-1-3">
      <button type="submit">确认提交</button>  
      <button class="on" id="think-more">再考虑一下</button>
    </div>
    </form>
    <div class="sqzc-1-4">温馨提示：建议双方先协商沟通下，一旦申请仲裁则不可撤销。</div>
  </div>
</div>

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
  var $zcBox = $("#zc-box");
  var $imgCount = 0;
  var upImgageToken = "<?=$up_token?>";
  var up_url = "<?=$upload_url?>";
  var source_url = "<?=$source_url?>";

  $("#apply-zc").click(function(){
      $zcBox.show();
  });

  $("#close-zc").click(function(){
      $zcBox.hide();
  });

  $("#think-more").click(function(){
      $zcBox.hide();
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
            if($imgCount >= 3){
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

  //表单提交
  $("#addzc-fm").submit(function(){
      if($imgCount == 0){
        showTip('<h4>请上传证据</h4>');
      }else{
        $.ajax({
          type:"post",
          url:$("#addzc-fm").attr('action'),
          data:$("#addzc-fm").serialize(),
          success:function(msg){
            if(msg.status == 0){
              window.location.href = "<?=site_url('refund/detail/'.$order_id)?>";
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