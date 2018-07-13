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
        .codeAddress{padding: 10px 15px; line-height: 22px; color: #666;border: 1px solid #0f7f7a; margin: 10px; border-radius: 10px;}
        .code{width:202px;height:202px;margin:auto;}
        #getAddress{text-align:center;margin:10px 0;}
        .otherFunc{padding:10px 25px;margin:20px;}
        .otherFunc h2{background-color: #72add8; padding: 10px; border-radius: 5px;}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">转  账</h1>
    </header>
    <div class="lk-content">
        <div class="codeAddress">
            <h2>收款方：</h2>
            <div class="code"><img src="<?php echo $code; ?>" /></div>
            <p id="getAddress"><?php echo $userInfo['address'] ?></p>
            <p>此地址用于对应卡片转账收款地址，每卡券每用户都有对应地址</p>
        </div>
        <div class="otherFunc">
            <h2>付款方</h2>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
    layui.use(['layer','element'],function(){
        var layer = layui.layer;
        var element = layui.element;

    })
</script>
</html>
