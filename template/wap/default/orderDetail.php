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
        .container{flex-direction:column;text-align:center;line-height:30px;background-color: white;margin-top:50px; }
        .detail{flex-direction:column;background-color: white;}
        .menuStyle{display:flex;justify-content:space-between;padding:8px;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        hr{width: 90%;margin: 2px auto;}
        .title{
            border-bottom: 1px solid #e6e6e6; 
            line-height:30px;
            background: #f1de9b;
            font-size: 12px;
            color: red;
            padding-left: 25px;
        }
        .sum{
            font-size: 18px;
            font-weight: bold;
            color: red;
        }
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
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">订单详情</h1>
    </header>
    <div class="lk-content">
        <div class="title">
            请收藏该页面地址,方便查询订单状态。
        </div>
        <div class="detail">
            <div class='menuStyle'>
                <span class="spanLeft">订单状态：</span>
                <span class="spanRight">
                    <?php if($orderInfo['status']==0) echo "<a class='btnPay' href='./pay.php?id=\"".$orderInfo['id']."\" '>去付款</a>"; ?>
                    <?php if($orderInfo['status']==1) echo "交易成功"; ?>
                    <?php if($orderInfo['status']==2) echo "订单取消"; ?>
                    <?php if($orderInfo['status']==3) echo "已付款"; ?>
                    <?php if($orderInfo['status']==4) echo "订单超时"; ?>
                </span>
            </div>
            <hr>
            <div class='menuStyle'>
                <span class="spanLeft">数量：</span><span class="spanRight"><?php echo number_format($orderInfo['number'],2); ?></span>
            </div>
           <hr>
           <div class='menuStyle'><span class="spanLeft">创建时间：</span><span class="spanRight"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span></div>
          <hr>
           <div class='menuStyle'><span class="spanLeft">订单号：</span><span class="spanRight"><?php echo $orderInfo['onumber'] ?></span></div>
        </div>
        <hr>
        <div class="container">
            <p>数量:<?php echo number_format($orderInfo['number'],2); ?>&nbsp;&nbsp;  * &nbsp;&nbsp;  单价:<?php echo $orderInfo['price'] ?></p>
            <p class="sum">实付：¥<?php echo number_format($orderInfo['prices'],2)?></p>
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
