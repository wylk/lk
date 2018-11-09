<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        html,body{
            background-color: #f2f2f2;
            color: #999;
        }
        .content{
            margin:40px 15px 10px;
            border-radius: 5px;
            background-color: #fff;
            padding: 10px 5px 30px;
        }
        .container{flex-direction:column;text-align:center;line-height:30px;}
        .detail{flex-direction:column;background-color: white;}
        .menuStyle{line-height:40px;display:flex;justify-content:space-between;border-bottom:1px solid #f0f0f0;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        .title{
            border-bottom: 1px solid #e6e6e6; 
            line-height:30px;
            background: #f1de9b;
            font-size: 12px;
            color: red;
            padding-left: 25px;
        }

        .foot{
            line-height: 80px;
            text-align: center;
        }
        a{
            text-decoration:none;
            color: #999; 
            display: inline-block;
            border: 1px solid #29aee7;
            width: 80%;
            text-align: center;
            line-height: 30px;
            border-radius: 5px;
        }
    </style>
     
</head>

<body>
    <div class="content">
        <div class="detail">
            <div class='menuStyle'>
                <span class="spanLeft">订单状态：</span></a>
                <span class="spanRight" style="color: #333"><!-- <a class='btnPay' href='./pay.php?id=\"".$orderInfo['id']."\" '> -->
                    <?php if($orderInfo['status']==0) echo "未付款"; ?>
                    <?php if($orderInfo['status']==1) echo "交易成功"; ?>
                    <?php if($orderInfo['status']==2) echo "订单取消"; ?>
                    <?php if($orderInfo['status']==3) echo "已付款"; ?>
                    <?php if($orderInfo['status']==4) echo "订单超时"; ?>
                </span>
            </div>
           
           <div class='menuStyle'><span class="spanLeft">创建时间：</span><span class="spanRight" style="font-size: 12px;"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span></div>
          
           <div class='menuStyle'><span class="spanLeft">订单号：</span><span class="spanRight" style="font-size: 12px;"><?php echo $orderInfo['onumber'] ?></span></div>
        </div>
        
        <div class="menuStyle">
            <span style="font-size: 12px;margin-left: 20px;">数量:<?php echo number_format($orderInfo['number'],2); ?>*单价:<?php echo number_format($orderInfo['price'],2); ?></span>&nbsp;&nbsp;<span style="margin-right: 20px;color: #333;">实付：¥<?php echo number_format($orderInfo['prices'],2)?></span>
        </div>
        <div class="foot">
            <?php if($orderInfo['status']==0){?>
                <a href='./pay.php?id=<?=$orderInfo['id'];?>'> 支付</a>
            <?php } else if($orderInfo['status']==1){?>
                <a href='./card_package.php'> 卡包</a>
            <?php }?>
        </div>
    </div>
    <?php //include display('public_menu');?>
</body>

</html>
