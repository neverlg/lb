<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<link rel="stylesheet" href="<?=asset("kit/bootstrap/css/star-rating.min.css")?>" type="text/css">
<script src="<?=asset("kit/bootstrap/js/star-rating.min.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">评价管理</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a>评价管理</a></span>
        		</div>

            	<div class="pjgl-2-1">
                    &nbsp;&nbsp;
                	订单编号：<font color="#2bb0eb"><?=$order['order_number']?></font>  &nbsp;&nbsp;
                	服务类型：<?=$order['service_type']?>  &nbsp;&nbsp;
                	师傅名字：<?=$order['master_name']?>（<?=$order['phone']?>）&nbsp;&nbsp;&nbsp;&nbsp;
                </div>

                <form id="addeva-fm" action="<?=site_url('evaluate/add_submit/'.$order_id)?>" method="post">
            	<div class="pjgl-1" style="padding-left:30px; font-size:15px;">
            		<b><font color="#f00" >*</font>服务评价：</b>
            		<input name="score" type="radio" value="1" required><img src="<?=asset("images/4159.png")?>" width='20' />好评
            		<input name="score" type="radio" value="2" required><img src="<?=asset("images/33.png")?>"  width='20' />中评
            		<input name="score" type="radio" value="3" required><img src="<?=asset("images/250.png")?>" width='20'  />差评
            	</div>

            	<table class="tjpj-11"> 
            		<tr class="tjpj-1">
            			<td><b><font color="#f00">*</font>服务质量：</b></td>
						<td><input id="quality" name="quality" value="0" class="rating-loading" data-size="xs"></td>
            		</tr>

                    <tr class="tjpj-1">
                        <td><b><font color="#f00">*</font>服务态度：</b></td>
                        <td><input id="attitude" name="attitude" value="0" class="rating-loading" data-size="xs"></td>
                    </tr>

                    <tr class="tjpj-1">
                        <td><b><font color="#f00">*</font>服务时效：</b></td>
                        <td><input id="ontime" name="ontime" value="0" class="rating-loading" data-size="xs"></td>
                    </tr>
            	</table>

             	<div class="tjpj-12"> 
            		<div class="tjpj-1">	
            			<b style="float:left;"><font color="#f00">*</font>匿名评价：</b>
            			<textarea name="content" cols="40" rows="4" placeholder="说说你对师傅的评价！（5-100字内）" required></textarea>
            		</div>

               		<div class="tjpj-13"> 
               			<button type="submit">提交评价</button>&nbsp;&nbsp;&nbsp;&nbsp;温馨提示：您对师傅的评价一旦提交成功，就不可再修改，请如实评价。
               		</div>
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

    $(document).on('ready', function(){
        var $tipBox = $("#tips-box");

        $('#quality, #attitude, #ontime').rating({
            displayOnly: true, 
            step: 1, 
            showClear: false, 
            showCaption:false
        });

        //submit
        $("#addeva-fm").submit(function(){
            var quality = $("#quality").val();
            var attitude = $("#attitude").val();
            var ontime = $("#ontime").val();

            if(quality==0 || attitude==0 || ontime==0){
                showTip('<h4>请进行星级评价！</h4>');
            }else{
                $.ajax({
                    type:"post",
                    url:$("#addeva-fm").attr('action'),
                    data:$("#addeva-fm").serialize(),
                    success:function(msg){
                        if(msg.status == 0){
                            var url = "<?=site_url('evaluate/index')?>";
                            showTip('<h4>感谢您的评价！</h4>', url);
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
    });
</script>
