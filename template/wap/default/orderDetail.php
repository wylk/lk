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
        .container{flex-direction:column;text-align:center;height:130px;background-color: white;}
        .container h3,.container h2{margin:10px;padding:10px;}
        .detail{flex-direction:column;background-color: white;margin-top:30px;}
        .menuStyle{display:flex;justify-content:space-between;padding:8px;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        .line{background-color: #e4e0e0;height:2px;margin:0 auto; width:90%;}

    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">订单详情</h1>
    </header>
    <div class="lk-content">
        <div class="container">
           <h3><?php echo $orderInfo['card_id'] ?></h3>
           <h1><?php echo number_format($orderInfo['number']*$orderInfo['prices'],2)?></h1>
           <p style="color:gray;"><?php echo $orderInfo['status'] == '1' ? "交易成功" : ($orderInfo['status'] == '2' ? "订单超时" : "未付款"); ?></p>
        </div>
        <div class="detail">
            <div class='menuStyle'><span class="spanLeft">数量：</span><span class="spanRight"><?php echo number_format($orderInfo['number'],2); ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">价格：</span><span class="spanRight"><?php echo number_format($orderInfo['prices'],2); ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">创建时间：</span><span class="spanRight"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">订单号：</span><span class="spanRight"><?php echo $orderInfo['onumber'] ?></span></div>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
  layui.use(['element'],function(){
    var element = layui.element;
  })
</script>

</html>
