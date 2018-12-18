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
    <style type="text/css">
      .login_block{height:100px;border:1px solid #d2d2d2;background-color: white;margin: 150px 10px;display: flex;flex-direction: column;justify-content: center;}
      .login_input{height: 40px;/*border:1px solid red;*/display: flex;flex-direction: row;justify-content: center;margin:0 40px}
      .login_line{margin:0px;padding: 0px;}
      .login_input span{display: flex;align-items: center;width: 65px;flex-direction: column;justify-content: center;}
      .login_input input{border:0px;}
      .login_input img{height: 30px;border-radius:4px;}
    </style>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
    <script type="text/javascript"></script>
</head>

<body style="background-color: #f2f2f2;">
  <div class="login_block">
    <div class="login_input">
      <span>手机号：</span>
      <input type="text" name="phone" placeholder="请输入手机号">
    </div>
    <hr class="login_line" />
    <div class="login_input">
      <input type="text" name="check" placeholder="请输入验证码">
      <span>
        <img onclick="this.src='login.php?action=check&'+Math.random();" src="./login.php?action=check"  />
      </span>
    </div>
  </div>
</body>

</html>
