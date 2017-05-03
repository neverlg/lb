<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top1.php'; ?>

<div class="nr-1">
  <div class="container">
     <a href="<?=site_url('main/index')?>">首页</a>》<a href="javascript:void(0);">帮助中心</a>
  </div>
</div>

<div class="container">
  <div class="col-md-3">
      <div class="htnr-1-1">
          帮助中心
      </div>
      <div class="htnr-tt">
        <div class="htnr-1-2">
              常见问题
        </div> 
        <li class="bzzx-1">
            <a href="<?=site_url('article/index/0')?>">账户相关<span class="bzzx-1-1">></span></a>
        </li>
        <li class="bzzx-1">
            <a href="<?=site_url('article/index/1')?>">订单相关<span class="bzzx-1-1">></span></a>
        </li>
        <li class="bzzx-1">
            <a href="<?=site_url('article/index/2')?>">付款相关<span class="bzzx-1-1">></span></a>
        </li>
        <li class="bzzx-1">
            <a href="<?=site_url('article/index/3')?>">退款相关<span class="bzzx-1-1">></span></a>
        </li>
        <li class="bzzx-1">
            <a href="<?=site_url('article/index/4')?>">投诉相关<span class="bzzx-1-1">></span></a>
        </li>
      </div>
      <div class="htnr-tt">
        <div class="htnr-1-2">
            用户反馈
        </div> 
        <li class="bzzx-1">
            <a href="<?=site_url('message/feedback')?>" class='on'>我要反馈<span class="bzzx-1-1">></span></a>
        </li>
      </div>
    </div>
    <div class="col-md-9">
      <div class="bjck">
        <div class="bjck-1">
          <span class="bjck-1-1"><a href="#">我要反馈</a></span>
        </div>
        
        <form id="fb-form" action="<?=site_url('message/feedback_submit')?>" method="post">  
        <div class="wyfk-1">
          建议反馈：<br/><textarea name="content" id="fb-content" placeholder="简短说明一下您遇到的问题或建议，如有必要，请留下您的联系方式或邮箱，便于我们联系并回复您的问题（1000字以内）"></textarea>
        </div>
        <div class="wyfk-1-1">
          <input type="submit" value="提交" />
        </div>
        </form>
      </div>     
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

  $("#fb-form").submit(function(){
    var content = $("#fb-content").val();
    if(content == ''){
      alert('请填写反馈信息');
    }else{
      $.ajax({
        type:"post",
        url:$("#fb-form").attr("action"),
        data:$("#fb-form").serialize(),
        success:function(msg){
          if(msg.status == 0){
            var html = '<h4>感谢您的建议，我们会在第一时间处理！</h4>';
            var url = '<?=site_url("article/index")?>';
            showTip(html, url);
          }else{
            var html = '<h4>'+ msg.error +'</h4>';
            showTip(html);
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
</script>>