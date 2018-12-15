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
      .layui-container{padding: 0 8px;}
      .api_block{padding: 10px 0px;background: white; border-radius: 5px;margin-top:5px;}
      .api_line{border-top:1px solid #ddd;}
      .api_span{background:white;height:40px;line-height: 40px;color: #333;display: flex;align-items: center;}
      .api_attr{display: block;float:left;margin:auto 10px;width: 45px;text-align: right;}
      .api_input{display: block;float:left;width: 65%;overflow:scroll;}
      .api_btn{float:right;margin-left:10px;height:25px;line-height: 25px;padding:2px 6px;border-radius: 3px;background: #41c7db85;}

      /*接口样式*/
      .inter{background: white;margin-top:5px;border-radius: 5px;padding:10px 0px;margin-bottom: 30px;}
      .inter_block{border:1px solid #29aee7;border-radius:4px;margin:15px 5px;display: flex;align-items: center;padding:8px;flex-direction: column;}
      .inter_row{/*border:1px solid red;*/width: 100%;}
      .inter_img{background-image: url(../template/wap/default/images/logo.jpg);background-size: 40px 40px;background-repeat: no-repeat;display: block;width: 40px;height: 40px;float: left;}
      .inter_row_attr{display: flex;justify-content: space-around;padding-left: 45px}
      .inter_attr{font-size:12px; color:#999;}
      .inter_num{font-size:14px;color:#333;}

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

<body style="background-color: #f2f2f2;">
  <header class="lk-bar lk-bar-nav" style="background-color: #FFF">
      <i class="iconfont">&#xe697;</i>
      <h1 class="lk-title">api接口</h1>
  </header>
  <div class="layui-container" style="padding-top:70px">
    <div style="font-size: 17px;">接口账号</div>
    <div class="api_block">
      <div class="api_span">
        <span class="api_attr">appid:</span>
        <span class="api_input">15703216869</span>
        <span class="api_btn">复制</span>
      </div>
      <div class="api_line"></div>
      <div class="api_span">
        <span class="api_attr">key:</span>
        <span class="api_input">aa139b77c50b94a84a70a2feeca25d41</span>
        <span class="api_btn">复制</span>
      </div>
    </div>
    <!-- 接口开关 -->
    <div style="margin-top: 80px;font-size: 17px;">接口管理</div>
    <div class="inter" >
      <?php for($i=0;$i<5;$i++){ ?>
      <div class="inter_block">
        <div class="inter_row" style="height: 40px;line-height: 40px;">
          <span class="inter_img"></span>
          <span style="color:#333;font-size: 17px;margin-left: 5px;">会员卡支付</span>
          <span style="float: right;border:1px solid #41c7db85;">
            <!-- <div style="display: block;width: 15px;height: 10px;border:1px solid red;"></div> -->
            开关
          </span>
        </div>
        <div class="inter_row inter_row_attr">
          <span class="inter_attr">组合支付：<i class="inter_num">￥123.45</i></span>
          <span class="inter_attr">余额支付：<i class="inter_num">￥123.45</i></span>
        </div>
      </div>
      <?php } ?>
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
