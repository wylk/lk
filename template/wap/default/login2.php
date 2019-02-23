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
  <style type="text/css"></style>
  <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
  <script type="text/javascript"></script>
  <style type="text/css">
    body{background-image:url(../template/wap/default/images/login_back_web.png);background-size: 100% 100%;background-repeat: no-repeat}
    .login_black{width: 95%; margin: 0 auto;margin-top:180px;}
    .login_header{background-image: url(../template/wap/default/images/login_line_web.png);background-repeat: no-repeat;background-size: 100% 100%;height: 23px;}
    .login_block{background: white;width: 93%;border-radius: 5px; margin: 0 auto; margin-top: -1px;padding-bottom: 20px;}
    .login_input{border-bottom: 1px solid #f2f2f2; padding: 5px; margin: 0 20px; padding-top: 25px;}
    .login_input input{height: 23px; width: 60%; padding: 5px; font-size: 18px;border:0px; margin-left: 3px;}

    .login_btn{border-radius: 5px; width:95%; }
  </style>
</head>
<body>
  <div class="login_black">
    <div class="login_header"></div>
    <div class="login_block">
      <div class="login_input">
        <input type="text" name="phone" value="手机号" placeholder="手机号">
      </div>
      <div class="login_input">
        <input type="text" name="phone" value="验证码" placeholder="验证码">
      </div>
      <div class="login_input">
        <input type="text" name="phone" value="短信验证码" placeholder="短信验证码">
      </div>
    </div>
  </div>
  <div class="login_btn">登录</div>
</body>

</html>
