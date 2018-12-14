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
      .api_block{/*border:1px solid red;background: white;height:50px;*/width: 100%;}
      .api_span{border:1px solid red;background:white;height:40px;line-height: 40px;}

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
  <div class="layui-container" style="padding-top:70px">
    <div class="api_block">
      <div class="api_span">
        <span style="">appid:</span>
        <span>15703216869</span>
        <span>复制</span>
      </div>
      <div class="api_span">
        <span>key:</span>
        <span>aa139b77c50b94a84a70a2feeca25d41</span>
        <span>复制</span>
      </div>
    </div>
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
