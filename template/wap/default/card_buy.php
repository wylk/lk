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
        .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .lk-deal-link a{width: 30%;text-align: center; line-height: 45px; font-size:.5rem;}
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell p{width:38%; padding-left:3%; line-height: 25px}
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">买入</h1>
    </header>
    <div class="lk-content">
        <div class="lk-container-flex lk-deal-link">
                <a href="card_buy.php" class="layui-bg-orange">买入</a>
                <a href="card_sell.php">卖出</a>
                <a href="card_order.php">订单</a>
                <a href="card_orderlist.php">订单记录</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="">买入价：1.01</a>
                <a href="">余额：221</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="">买入数量：1760
                <a href="">WLK</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="">兑换资金：122</a>
                <a href="">CNY</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-c">
            <a href="" class="layui-btn layui-btn-warm" style="width: 90%">买入</a>
        </div>
        <div class="lk-container-flex">
            <h1 style="font-size:16px; font-weight: 600; padding:20px 0 10px 20px">市场卖单</h1>
        </div>
        <hr>
        <div class="lk-container-flex">
            <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
                <p class="item-flex">王**</p>
                <p class="item-flex">900WLK</p>
                <p class="item-flex">在线</p>
                <p class="item-flex">价格：1</p>
                <p class="item-flex">logo</p>
                <p class="item-flex">限额：100-900</p>
            </div>
            <div class="lk-container-flex">
                <p class="item-buy"><a href="">买入</a></p>
            </div>
        </div>
        <hr>
        <div class="lk-container-flex">
            <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
                <p class="item-flex">王**</p>
                <p class="item-flex">900WLK</p>
                <p class="item-flex">在线</p>
                <p class="item-flex">价格：1</p>
                <p class="item-flex">logo</p>
                <p class="item-flex">限额：100-900</p>
            </div>
            <div class="lk-container-flex">
                <p class="item-buy"><a href="">买入</a></p>
            </div>
        </div>
        <hr>
    </div>
    <?php include display('public_menu');?>
    <script type="text/javascript">
    </script>
</body>

</html>
