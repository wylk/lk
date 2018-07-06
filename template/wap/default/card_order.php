<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>卡片交易订单</title>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .lk-deal-link a{width: 25%;text-align: center; line-height: 45px; font-size:.5rem;}
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell{padding: 2% 5%;}
        .lk-bazaar-sell p{line-height: 25px}
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
        .order-left{width: 55%}
        .order-right{width: 45%;text-align: right;}
        .b{font-size:16px;color:#5FB878}
        .s{font-size:16px;color:#FF5722}
        .total{color:#393D49;font-weight: 550; font-size:16px}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i class="iconfont">&#xe697;</i>
        <h1 class="lk-title">买入</h1>
    </header>
    <div class="lk-content">
        <div class="lk-container-flex lk-deal-link">
                <a href="card_buy.php">买入</a>
                <a href="card_sell.php">卖出</a>
                <a href="card_order.php" class="layui-bg-orange">订单</a>
                <a href="card_orderlist.php">订单记录</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
            <div class="order-left">
                <p><span class="b">买入</span> 单号：2049023</p>
                <p>2018.07.06 14:36:55下单</p>
                <p>数量：150.0000</p>
            </div>
            <div class="order-right">
                <p><a class="layui-bg-cyan" style="padding: 5px 7px" href="">查看详情</a></p>
                <p>价格：1.00</p>
                <p style="color: green">待付款</p>
                <p>总金额：<span class="total">￥12500.00</span></p>
            </div>
        </div>
        <hr>
        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
            <div class="order-left">
                <p><span class="s">卖出</span> 单号：2049023</p>
                <p>2018.07.06 14:36:55下单</p>
                <p>数量：150.0000</p>
            </div>
            <div class="order-right">
                <p><a class="layui-bg-cyan" style="padding: 5px 7px" href="">查看详情</a></p>
                <p>价格：1.00</p>
                <p style="color: red">待支付</p>
                <p>总金额：<span class="total">￥12500.00</span></p>
            </div>
        </div>
        <hr>

    </div>
    <?php include display('public_menu');?>
    <script type="text/javascript">
    </script>
</body>

</html>
