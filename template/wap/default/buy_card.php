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
        .container {align-items: center; background-color: #FFF;}
        .lk-deal-link a{
            width: 25%;
            text-align: center;
        }
    </style>
</head>

<body style="background-color: rgba(240,240,240,.3);">
    <header class="lk-bar lk-bar-nav">
        <i class="iconfont">&#xe697;</i>
        <h1 class="lk-title">买入</h1>
    </header>
    <div class="lk-content">
        <div class="lk-container-flex lk-deal-link">
                <a href="">买入</a>
                <a href="">卖出</a>
                <a href="">订单</a>
                <a href="">订单记录</a>
        </div>
        <hr>
    </div>
    <script type="text/javascript">
    </script>
</body>

</html>
