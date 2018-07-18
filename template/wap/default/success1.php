<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        img{
          position: absolute;clip: rect(0px,250px,72px,0px);
          margin-left: 128px;
          margin-top: 126px;
          width: 99px;
        }
        .h1 h1{
              width: 120px;
              padding-top: 208px;
              margin-left: 123px;
              font-weight:normal;
              color: #5ec107;
        }
        ul{
          margin-left: 127px;
          margin-top: 53px;
        }
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">购买成功</h1>
</header>
  <div>
    <div class='h1'>
      <img src="http://lk.com/upload/images/201807/58920fc3b8ad40f4a30d427291ae29c2.png">
      <h1>支付成功</h1>
      <ul>
        <li><font size="5">乐卡支付</font></li>
        <li><font size="12" style="margin-left: -41px;">￥16.00</font></li>
      </ul>
    </div>
  </div>
  	<?php include display('public_menu');?>
</body>
</html>

