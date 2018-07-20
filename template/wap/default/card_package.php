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
        ul.lk-container-flex {width: 100%}
        .lk-content hr{margin: 0}
        .lk-card-package{margin: 0 15px;border:1px solid #5FB878; border-radius: 10px; height: 150px}
        .card-info{width:70%;line-height: 30px; padding:0 10px;}
        .card-logo p{width:50px; height: 50px; border-radius: 50%; border:0px solid #000;
                    background: url("/static/sweetalert/images/vs_icon@2x.png") no-repeat;
                    background-size: 110% 110%;
                }
        .card-handle{width:15%; border:1px solid #FF5722; border-radius: 5px; line-height: 30px; margin:15px 0; text-align: center;}
        hr.cut-off-rule{margin:10px 0;}

    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i class="iconfont">&#xe697;</i>
        <h1 class="lk-title">买入</h1>
    </header>
    <div class="lk-content">
        <div class="lk-container-flex" style="padding-left: 15px">
            <i class="layui-icon layui-icon-layer" style="font-size: 35px; color:#1E9FFF">&#xe638;</i>
            <h1 style="font-size:18px; line-height: 38px; margin-left:15px">卡包</h1>
        </div>
        <!-- <hr style="height:5px; margin:10px 0;">
        <div class="lk-container-flex lk-card-package lk-flex-direction-c">
            <div class="lk-container-flex" style="padding:10px 0">
                <div class="item-flex card-info">
                    <p>乐卡币：LKB</p>
                    <p style="font-size: 12px"><b style="margin-right: 20px;font-size:16px">800.11</b> 锁定：200</p>
                </div>
                <div class="item-flex card-logo">
                    <p></p>
                </div>
            </div>
            <hr>
            <div class="lk-container-flex lk-flex-direction-r">
                <ul class="lk-container-flex lk-justify-content-sa">
                    <a class="card-handle" href="">核销</a>
                    <a class="card-handle" href="">出售</a>
                    <a class="card-handle" href="">充值</a>
                    <a class="card-handle" href="">账单</a>
                    <a class="card-handle" href="card_buy.php">交易</a>
                </ul>
            </div>
        </div> -->
        <?php foreach($cardList as $key=>$value){ ?>
        <hr class="cut-off-rule">
        <div class="lk-container-flex lk-card-package lk-flex-direction-c">
            <div class="lk-container-flex" style="padding:10px 0">
                <div class="item-flex card-info">
                    <p>乐卡币：LKB<?php echo $value['type'] ?></p>
                    <p style="font-size: 12px"><b style="margin-right: 20px;font-size:16px">可用：<?php echo number_format($value['num'],2) ?></b> 锁定：<?php echo number_format($value['frozen'],2) ?></p>
                </div>
                <div class="item-flex card-logo">
                    <p></p>
                </div>
            </div>
            <hr>
            <div class="lk-container-flex lk-flex-direction-r">
                <ul class="lk-container-flex lk-justify-content-sa">
                    <a class="card-handle" href="./transferBill.php?id=<?php echo $value['id'] ?>">核销</a>
                    <a class="card-handle" href="./changeInto.php?id=<?php echo $value['id'] ?>">充值</a>
                    <a class="card-handle" href="./transaction.php?cardId=<?php echo $value['card_id'] ?>">出售</a>
                    <a class="card-handle" href="./recordBooks.php?id=<?php echo $value['id'] ?>"">账单</a>
                    <?php if($value['type'] == 'leka'){ ?>
                    <a class="card-handle" href="card_buy.php?uid=<?php echo $value['uid'] ?>">交易</a>
                    <?php }else{ ?>
                    <a class="card-handle" href="">暂定</a>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>

    <?php include display('public_menu');?>
    <script type="text/javascript">
    </script>
</body>

</html>
