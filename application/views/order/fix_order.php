<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<script src="<?=asset("kit/localresizeimg/lrz.bundle.js")?>" ></script>
<link rel="stylesheet" href="<?=asset("kit/bootstrap/css/bootstrap-datetimepicker.min.css")?>" type="text/css">
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.min.js")?>" ></script>
<script src="<?=asset("kit/bootstrap/js/bootstrap-datetimepicker.zh-CN.js")?>" ></script>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="#">报价下单</a>
	</div>
</div>

<div class="container">
    <div class="smaz">
        <div class="smza-1">
            你选择的是<font color="#f00">报价订单</font>服务方式(<font color="#f00">发布订单获取多个师傅报价</font>)
        </div>
        <div class="smza-1-1">
            <img src="<?=asset("images/134404.png")?>" />服务流程:
        </div>
        <div class="bjxq-2" style="border-bottom:1px solid #ccc; padding-bottom:0px; clear:both; overflow:hidden;">
            <li class="bjxq-2-1"><a href="#">1</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-40px;" style="margin-top:10px;" color="#000" size="3">发布订单</font></a></li></li>  
            <li class="bjxq-2-1"><a href="#">2</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">多个师傅报价</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">3</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">挑选师傅雇佣</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">4</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">托管服务费用</font></a></li></li>
            <li class="bjxq-2-1"><a href="#">5</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">师傅服务中</b></font></a></li></li>
            <li class="bjxq-2-1"><a href="#">6</a><li class="bjxq-2-11"><br/><a href="#"><font style="margin-left:-50px;" color="#000" size="3">验收确定放款</font></a></li></li>
            <li class="bjxq-2-1" style="width:120px;" ><a href="#">7</a></li>
            <li style="margin-left:-143px; margin-top:28px; color:#000; font-size:16px;" >评价师傅</li>
        </div>
        
        <form id="addorder-fm" action="<?=site_url('order/baojia_submit/'.$type)?>" method="post">
        <div class="smza-2">
            <img src="<?=asset("images/141227.png")?>" />
            <b>服务类型:</b>
            <a <?=($type==4)?"class='on'":""?> href="<?=site_url('order/baojia/4')?>">提货配送上门</a>
            <a <?=($type==1)?"class='on'":""?> href="<?=site_url('order/baojia/1')?>">提货配送上门+安装</a>
            <a <?=($type==2)?"class='on'":""?> href="<?=site_url('order/baojia/2')?>">上门安装</a>
            <a <?=($type==3)?"class='on'":""?> href="<?=site_url('order/baojia/3')?>">上门维修</a>
            <a <?=($type==5)?"class='on'":""?> href="<?=site_url('order/baojia/5')?>">打包返货</a>
        </div>

        <div class="smza-2-1">
            <div class="col-md-10 smza-2-22">
                <div class="smza-2-3">
                    <font color="#f00">*</font>货品类目：
                    <select name="goods_type[]" required>
                        <option value="">请选择货品类目</option>
                        <option value="1">柜类</option>
                        <option value="2">床类</option>
                        <option value="3">床垫类</option>
                        <option value="4">桌类</option>
                        <option value="5">茶几类</option>
                        <option value="6">架类</option>
                        <option value="7">沙发类</option>
                        <option value="8">椅类</option>
                        <option value="9">屏风隔断</option>
                        <option value="10">办公类</option>
                        <option value="12">坐具类</option>
                    </select> 
                </div>
          
                <div class="smza-2-4">
                    <span style="float:left;"><font color="#f00">*</font>备注说明：</span>
                    <textarea name="goods_remark[]" cols="42" rows="3"></textarea>  
                </div>
          
                <div id="preview2" style="margin-left:80px; margin-bottom:20px;">
                    <a href="javascript:void(0)" class="upload-file1">
                        <input type="file" id="fileupload1" name="FileContent" />
                        <input type="hidden" name="goods_img[]" class="goods-img"/>
                    </a>
                    <div class="clear"></div>
                </div>         
                <input type="file" style="display: none;" id="previewImg">
            </div>    
        </div>

        <!--
        <div class="smwx-a">
            <a href="#">+继续添加维修商品</a>
        </div>
        -->   
       
        <div class="smza-3">
            <img width="29" src="<?=asset("images/1307.png")?>" />客户信息：  
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>客户姓名：
             <input name="customer_name" placeholder="请输入客户姓名" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>客户手机：
            <input name="customer_phone" placeholder="请输入客户手机号" type="text" required pattern="^1[3,5,8]\d{9}$">
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>所在地址：
            <select name="province" id="province" required>
                <option>请选择省</option>
            </select>
            <select name="city" id="city" required>
                <option>请选择市</option>
            </select>
            <select name="district" id="district" required>
                <option>请选择区</option>
            </select> 
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>详情地址：
            <input name="address" placeholder="请输入居住的详情地址" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>电梯步梯：
            <select name="elevater" required>
                <option value="">请选择</option>
                <option value="1">电梯</option>
                <option value="2">步梯</option>
            </select>
            <input style="width:140px;" name="floor" type="number" required>楼
        </div>
        <div class="smza-2-4">
            <span style="float:left; font-size:15px; padding-left:2%;">
                <font color="#f00">*</font>备注说明：
            </span>
            <textarea name="customer_remark" cols="42" rows="3" placeholder="请输入相关备注信息"></textarea>
        </div>
    
        <div class="smza-3">
            <img width="23" src="<?=asset("images/41329.png")?>" />下单用户：  
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>用户姓名：
            <input name="me_name" placeholder="请输入下单联系人姓名" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>用户手机：
            <input name="me_phone" placeholder="请输入下单联系人的手机号，以便师傅联系与你沟通" type="text" required>
        </div>
        <div class="smza-3-1">
            <font color="#f00">*</font>完成时间：
            <input name="hope_finish_time" placeholder="选择希望完成的日期时间" type="text" readonly class="form_datetime">
        </div>
        <div class="smza-4">
            <b>温馨提示：</b><br/>你发布的订单师傅将在24小时后师傅停止报价，停止师傅报价后你必须在3天内雇佣师傅及付款，否则订单自动关闭！
            <br/><br/>
            <button type="submit">确认发布订单</button>
        </div>
        </form>
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
var $goodsBox = $("#goods-box");
var upImgageToken = "<?=$up_token?>";
var up_url = "<?=$upload_url?>";
var source_url = "<?=$source_url?>";
var $provinces = <?=$__provinces?>;
var $tipBox = $("#tips-box");
var $imgCount = 0;

$("input[name='hope_finish_time']").datetimepicker({
    format:'yyyy-mm-dd',
    language: 'zh-CN',
    minView:2,
    todayBtn:true,
    autoclose:true,
    todayHighlight:true,
});

init_province();

//init province
function init_province(){
    var pro_html = "<option value=''>请选择省</option>";
    $.each($provinces[0], function(i, n){
        pro_html += "<option value='"+ i +"'>"+ n +"</option>";   
    });
    $("#province").html(pro_html);
};

//city
$("#province").change(function(){
    var pro_id = $("#province").find("option:selected").val();
    var html = "<option value=''>请选择市</option>";
    $.each($provinces[pro_id], function(i, n){
        html += "<option value='"+ i +"'>"+ n +"</option>";
    });
    $("#city").html(html);
});

//district
$("#city").change(function(){
    var city_id = $("#city").find("option:selected").val();
    var html = "<option value=''>请选择区</option>";
    $.each($provinces[city_id], function(i, n){
        html += "<option value='"+ i +"'>"+ n +"</option>";
    });
    $("#district").html(html);
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
        var html = '<img src="'+picUrl+'" />';
        $(".upload-file1").before(html);

        var img_url = $(".goods-img").val();
        if(img_url == ''){
            $(".goods-img").val(keyText.key);
        }else{
            $(".goods-img").val(img_url + ',' + keyText.key);
        }

        $imgCount++;
        if($imgCount >= 3){
            $(".upload-file1").hide();
        }
        console.log(picUrl);
    }
  }
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/octet-stream");
  xhr.setRequestHeader("Authorization", "UpToken "+upImgageToken+"");
  xhr.send(picBase);
}

//close goods none

//submit
$("#addorder-fm").submit(function(){
    if($imgCount<=0){
        showTip('请选择或上传货品信息');
    }else{
        $.ajax({
            type:'post',
            url:$("#addorder-fm").attr('action'),
            data:$("#addorder-fm").serialize(),
            success:function(msg){
                if(msg.status == 0){
                    var url="<?=site_url('order/index')?>";
                    showTip("<h4>下单成功！</h4>", url);
                }else{
                    showTip('<h4>'+msg.error+'</h4>');
                }
            }
        });
    }
    return false;
});


//tips
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

//关闭按钮
$(".close-tips").click(function(){
    $(".tips-info").hide();
});

$("#confirm-tips").click(function(){
    $tipBox.hide();
});
    
</script>

