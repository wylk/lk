<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/clipboard.min.js" charset="utf-8"></script>
    <style type="text/css">
      .layui-input-block{margin-right: 50px;}
      .layui-input{border:0; padding-left:6px;}
      .layui-form-item .layui-input-inline.us-input-inline{display: inline-block; float: none; left: 0;  width: auto; margin: 0; padding: 10px 0 10px 0px;}
      .layui-form-item{margin: 0; line-height: 45px;}
      .us-btn{background-color: #FFF; color:#FF5722; font-weight: 500}
      .us-btn:hover{color:#FF5722;}
      .layui-form-item .layui-form-label{margin-top:10px;}
      .layui-row{border-radius: 3px;}

      .layui-checkbox{background-color: #FFF; color:#FFF; width: 12px; height: 12px; border:1px solid #f2f2f2; margin:10px; font-size:9px;padding:2px;}

      .us-checkbox{background-color: #FFF; color:#000; width: 12px; height: 12px; border:1px solid #ddd; margin:10px; font-size:9px;padding:2px; }
      .layui-layer-btn{background:none;}
      .layui-form-item button{padding:2px;border-radius: 6px;background: #29aee7;width: 45px;}
      .api_state{border:1px solid red;width:100%;height:40px;margin-top: 10px;background: #FFF;}
    </style>
     <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
     <script type="text/javascript">
        $(function(){
            lk.is_weixin() && function(){
                $('.lk-bar-nav').css('display','none');
                $('.lk-content').css({"padding":"0px"});
            }()
        })
    </script>
</head>

<body style="background-color: rgba(240,240,240,.3);">
  <header class="lk-bar lk-bar-nav" style="background-color: #FFF">
      <i class="iconfont">&#xe697;</i>
      <h1 class="lk-title">api接口</h1>
  </header>
  <div class="layui-container" style="padding-top:155px">
    <form class="layui-form" action="javascript:;">
  <div class="layui-row" style="border:1px solid #d2d2d2; background-color: #FFF; margin-bottom:50px;">
    <div class="layui-col-xs12">
      <?php if(empty($userInfo['mid'])){ ?>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                <input type="text" name="phone" id="phone" required lay-verify="phoneNumber" placeholder="<?php echo $phoneShow ?>" autocomplete="off" class="layui-input" value="<?php echo $phoneShow; ?>" readonly>
            </div>
        </div>
        <div class="layui-form-item"  style="border-top:1px solid #F0F0F0">
          <div class="layui-input-inline us-input-inline" style=" border-right:1px solid #F0F0F0">
                <input type="text" name="password" required lay-verify="passVerify" placeholder="请输入手机验证码" autocomplete="off" class="layui-input" style="float:right; width: 78%">
          </div>
            <a href="javascript:;"  id="getVerify" class="layui-btn us-btn">获取验证码</a>
        </div>
      <?php }else{ ?>
        <div class="layui-form-item">
            <label class="layui-form-label">工商号：</label>
            <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                <input type="text" id="mid" name="mid" placeholder="<?php echo $userInfo['mid'] ?>" autocomplete="off" class="layui-input" value="<?php echo $userInfo['mid']; ?>" readonly>
            </div>
            <button id="copy_mid" data-clipboard-target="#mid">复制</button>
        </div>
        <div class="layui-form-item"  style="border-top:1px solid #F0F0F0">
            <label class="layui-form-label">秘钥：</label>
            <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                <input type="text" id="key" name="key" length="16" placeholder="<?php echo $userInfo['mid_key'] ?>" autocomplete="off" class="layui-input" value="<?php echo $userInfo['mid_key']; ?>" >
            </div>
            <button id="copy_key" data-clipboard-target="#key">复制</button>
      <?php } ?>
        </div>
  </div>
</div>
<?php if(empty($userInfo['mid'])){ ?>
  <div class="layui-row">
  <button id="layui-btn" class="layui-btn" style="width:100%;">申请商户号</button>
  </div>
<?php }else{ ?>
  <div class="api_state">
      此账号用于优惠券余额和组合支付使用，请妥善保管此账号
  </div>
<?php } ?>
</form>
</div>

</body>

</html>
<script type="text/javascript">
  var layer;
  layui.use(['layer'],function(){
    layer = layui.layer;
  });
	$("#getVerify").bind("click",function(){
		var data = {type:"verify"};
		$.post("./userApi.php",data,function(res){
		  if(res.messageRes)
		  	layer.msg("验证码发送成功",{icon:1,skin:'demo-class'});
		  else 
		  	layer.msg("验证码发送失败",{icon:5,skin:'demo-class'});
		},"json");
	});
	$("#layui-btn").bind("click",function(){
		var pwd = $("[name=password]").val();
		if(pwd.length != 6){
			layer.msg("验证码不正确",{icon:5,skin:'demo-class'});
			return;
		}
		var data = {type:'apply',pwd:pwd};
		$.post("./userApi.php",data,function(res){
		  if(!res['res']){
		    layer.msg(res.msg,{icon:1,skin:'demo-class'});
		    setTimeout(function(){
		      window.location.reload(true);
		    },1000);
		  }else
		    layer.msg(res.msg,{icon:5,skin:'demo-class'});
		},"json");
	});
	$("[id^=copy_]").bind("click",function(){
		var idStr = $(this).attr('id');
	    var clipboard = new ClipboardJS("#"+idStr);
	    clipboard.on("success",function(e){
	        e.clearSelection();
	        layer.msg("复制成功",{ icon: 1, skin: "demo-class" });
	    })
	    clipboard.on("error",function(e){
	        layer.msg("复制失败",{ icon: 5, skin: "demo-class" });
	    })
	})
</script>
