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
        .lk-deal-link a{width: 25%;text-align: center; line-height: 45px; font-size:15px;}
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
        <?php foreach($orderList as $key=>$value){ ?>
        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
            <div class="order-left">
                <p>
                <?php if($value['sell_id'] == $userId){ ?>
                    <span class="s">卖出</span>
                <?php }else{ ?>
                    <span class="b">买入</span>
                <?php } ?>
                </span> 单号：<?php echo $value['onumber'] ?></p>
                <p><?php echo date("Y-m-d H:i:s",$value['create_time']); ?>下单</p>
                <p>数量：<?php echo number_format($value['number'],2) ?></p>
            </div>
            <div class="order-right">
                <p><a class="layui-bg-cyan" style="padding: 5px 7px" href="card_orderDetail.php?id=<?php echo $value['id'] ?>" >查看详情</a></p>
                <p>价格：￥<?php echo number_format($value['price'],2) ?></p>
                <?php if($value['sell_id'] == $userId){ ?>
                    <p style="color: red">
                    <?php if($value['status'] == "0") echo "待收款" ?>
                    <?php if($value['status'] == "3") echo "对方已付款" ?>
                    </p>
                <?php }else{ ?>
                    <p style="color: green">
                    <?php if($value['status'] == "0") echo "待付款" ?>
                    <?php if($value['status'] == "3") echo "已付款" ?>
                    </p>
                <?php } ?>
                </p>
                <p>总金额：<span class="total">￥<?php echo number_format($value['number']*$value['price'],2) ?></span></p>
            </div>
        </div>
        <hr>
        <?php } ?>

    </div>
    <?php include display('public_menu');?>
    <script type="text/javascript">
    </script>
</body>

</html>
