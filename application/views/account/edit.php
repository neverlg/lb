<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php require 'application/views/basic/header.php'; ?>   
<?php require 'application/views/basic/top2.php'; ?>

<div class="nr-1">
	<div class="container">
		<a href="<?=site_url('main/index')?>">首页</a>》
		<a href="javascript:void(0);">后台管理中心</a>》
        <a href="javascript:void(0);">基本资料</a>
	</div>
</div>

<div class="htnr">
	<div class="container">
		<?php require 'application/views/basic/left_nav.php'; ?>

    	<div class="col-md-9">
    		<div class="bjck">
        		<div class="bjck-1">
        			<span class="bjck-1-1"><a href="javascript:void(0);">基本资料</a></span>
        		</div>
            	<div class="jbzl-1">
            		<div class="jbzl-lef col-md-8">
                    <form id="account-fm" action="<?=site_url('account/edit_submit')?>" method="post">
                		用户名：<?=$info['me_username']?> <br/>
                		注册类型：<?=$info['me_category']?> <br/>

                		真实姓名：<input name="truename" type="text" value="<?=$info['me_truename']?>" /> <br/>

                		手机号码：<?=$info['me_phone']?> <br/>

                		所在地区：<select name="province" id="province">
                                    <option value="">请选择省</option>
                                  </select> 
                                  <select name="city" id="city">
                                    <option value="">请选择市</option>
                                  </select>
                                  <select name="district" id="district">
                                    <option value="">请选择区</option>
                                  </select>
                                  <br/>

                		详细地址：<input name="detail_address" type="text" value="<?=$info['me_local_address']?>" /> <br/>

                		备用号码：<input name="phoneps" type="text" value="<?=$info['me_phoneps']?>" /> <br/>

                		QQ号码：<input name="qq" type="text" value="<?=$info['me_qq']?>" /> <br/>

                		淘宝旺旺ID：<input name="tb_name" type="text" value="<?=$info['me_tb_name']?>" /> <br/>

                		淘宝店铺网址：<input name="tb_url" type="text" value="<?=$info['me_tb_url']?>" /> <br/>

                        京东店铺ID：<input name="jd_name" type="text" value="<?=$info['me_jd_name']?>" /> <br/>

                        京东店铺网址：<input name="jd_url" type="text" value="<?=$info['me_jd_url']?>" /> <br/><br/>

                		<div class="jbzl-lef-1">
                			<button type="submit" >提交</button>
                		</div>
                    </form>
                	</div>
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
    var $provinces = <?=$__provinces?>;

    init_province();

    //init province
    function init_province(){
        var pro = "<?=$info['province']?>";
        var city = "<?=$info['city']?>";
        var dis = "<?=$info['district']?>";
        var pro_html = '';
        var city_html = '';
        var dis_html = '';
        if(pro == ''){
            pro_html = "<option value=''>请选择省</option>";
        }
        $.each($provinces[0], function(i, n){
            if(pro == n){
                pro_html += "<option rel='"+ i +"' value='"+ n +"' checked='checked'>"+ n +"</option>";
            }else{
                pro_html += "<option rel='"+ i +"' value='"+ n +"'>"+ n +"</option>";
            }
            
        });
        $("#province").html(pro_html);

        if(city == ''){
            city_html = "<option value=''>请选择市</option>";
        }
        var pro_id = $("#province").find("option:selected").attr('rel');
        if(pro_id > 0){
            $.each($provinces[pro_id], function(i, n){
                if(city == n){
                    city_html += "<option rel='"+ i +"' value='"+ n +"' selected='selected'>"+ n +"</option>";
                }else{
                    city_html += "<option rel='"+ i +"' value='"+ n +"'>"+ n +"</option>";
                }
            });
        }
        $("#city").html(city_html);

        if(dis == ''){
            dis_html = "<option value=''>请选择区</option>";
        }
        var city_id = $("#city").find("option:selected").attr('rel');
        if(city_id > 0){
            $.each($provinces[city_id], function(i, n){
                if(dis == n){
                    dis_html += "<option rel='"+ i +"' value='"+ n +"' selected='selected'>"+ n +"</option>";
                }else{
                    dis_html += "<option rel='"+ i +"' value='"+ n +"'>"+ n +"</option>";
                }
            });
        }
        $("#district").html(dis_html);
    };

    //city
    $("#province").change(function(){
        var pro_id = $("#province").find("option:selected").attr('rel');
        var html = "<option value=''>请选择市</option>";
        $.each($provinces[pro_id], function(i, n){
            html += "<option rel='"+ i +"' value='"+ n +"'>"+ n +"</option>";
        });
        $("#city").html(html);
    });

    //district
    $("#city").change(function(){
        var city_id = $("#city").find("option:selected").attr('rel');
        var html = "<option value=''>请选择区</option>";
        $.each($provinces[city_id], function(i, n){
            html += "<option rel='"+ i +"' value='"+ n +"'>"+ n +"</option>";
        });
        $("#district").html(html);
    });

    $("#account-fm").submit(function(){
        $.ajax({
            type:"post",
            url:$("#account-fm").attr('action'),
            data:$("#account-fm").serialize(),
            success:function(msg){
                if(msg.status == 0){
                    window.location.href = "<?=site_url('account/index')?>";
                }else{
                    var html = '<h4>'+ msg.error +'</h4>';
                    showTip(html);
                }
            }
        });
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
