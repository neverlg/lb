<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="zhcz">
	<div class="container zhcz-1">
		<div class="zhcz-2">
    		充值金额<br/><br/>
          <span class="zhcz-2-1"> 
            <a class="on" rel="0.01">0.01元[test]
              <span class="zhcz-2-2 on">(送2元)</span>
            </a>
          </span>

      		<span class="zhcz-2-1"> 
      			<a class="on" rel="500">500元
      				<span class="zhcz-2-2 on">(送5元)</span>
      			</a>
      		</span> 

      		<span class="zhcz-2-1"> 
      			<a rel="2000">2000元
      				<span class="zhcz-2-2">(送25元)</span>
      			</a>
      		</span>

      		<span class="zhcz-2-1"> 
      			<a rel="5000">5000元
      				<span class="zhcz-2-2">(送80元)</span>
      			</a>
      		</span>

      		<span class="zhcz-2-1"> 
      			<a rel="10000">10000元
      				<span class="zhcz-2-2">(送200元)</span>
      			</a>
      		</span>
    	</div>
    
    	<div class="zhcz-2">
    		支付方式：<br/><br/>
      		<span class="zhcz-3-1"> 
      			<a class="on" href="#">
      				<img src="<?=asset("images/37.png")?>" />
      			</a>
      		</span> 
      		<span class="zhcz-3-2"> 
      			<a href="javascript:void(0);">
      				更多支付方式即将上线
      			</a>
      		</span>
    	</div>

    	<form id="recharge-fm" action="<?=site_url('ewallet/third_pay')?>" method="post">
 		<div class="zhcz-4">
 			充值金额：
 			<input type="hidden" name="fee" value="500" />
 			<font color="#f00" id="fee">500.00元</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 			<font color="#f00">(充值成功后，赠送的金额也会加在钱包里面)</font><br/><br/>
    		<button type="submit">立即支付</button>
 		</div>
 		</form>
	</div>
</div>

<?php require 'application/views/basic/bottom.php'; ?>

<script type="text/javascript">
	$(".zhcz-2-1 a").click(function(){
		$(".zhcz-2-1").find(".on").removeClass('on');
		var $node = $(this).parent(".zhcz-2-1");
		$node.find("a, span").addClass('on');
		var fee = $node.children("a").attr('rel');
		$("input[name='fee']").val(fee);
		$("#fee").text(fee + '.00元');
	});

</script>