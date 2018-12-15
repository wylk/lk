<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>卡包</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=1">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        body{
            background-color: #f2f2f2;
        }
        ul.lk-container-flex {width: 100%}
        .lk-content hr{margin: 0;}
        .lk-card-package{margin: 0 5px 8px;border:1px solid #dedede; border-radius: 3px; height: 125px;background-color: #fff;}
        .card-info{width:70%;line-height: 30px; padding:0 10px;}
        .card-logo p{width:50px; height: 50px; border-radius: 50%; border:0px solid #000;
                    background: url("/static/sweetalert/images/vs_icon@2x.png") no-repeat;
                    background-size: 110% 110%;
                }
        .card-handle{width:20%; border-right:1px solid #ded5d5; line-height: 30px; margin:5px 0; text-align: center; color: #666;}
        hr.cut-off-rule{margin:10px 0;}
        .no-border{
            border-right: 0px;
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
        <i class="iconfont">&#xe697;</i>
        <h1 class="lk-title">卡包</h1>
    </header>
    <div class="lk-content">
       <div class="lk-container-flex" style="padding-left: 15px;height: 15px;">
          <!--  <i class="layui-icon layui-icon-layer" style="font-size: 35px; color:#1E9FFF">&#xe638;</i>
          <h1 style="font-size:18px; line-height: 38px; margin-left:15px">卡包</h1> -->
       </div>
        
        <?php foreach($cardList as $key=>$value){ ?>
        
        <div class="lk-container-flex lk-card-package lk-flex-direction-c">
            <?php if($value['type'] == option("hairpan_set.platform_type_name")){ ?>
            <a href="card_buy.php?uid=<?php echo $value['uid'] ?>" class="lk-container-flex" style="padding:10px 0;">
            <?php }else{ ?>
            <a href="home.php?card_id=<?php echo $value['card_id'] ?>&plugin=<?php echo $value['type'] ?>&shoreUid=<?php echo $cardAttrArr[$value['card_id']]['uid'] ?>" class="lk-container-flex" style="padding:10px 0;">
            <?php } ?>
                <div class="item-flex card-info">
                    <p><?php echo $value['type']==option("hairpan_set.platform_type_name") ? '乐卡' : $cardType[$cardAttrArr[$value['card_id']]['uid']]; ?>
                    ：
                        <?php echo isset($cardAttrArr[$value['card_id']]['name']) ? $cardAttrArr[$value['card_id']]['name'] : $value['type'] ?>
                    </p>
                    <p style="font-size: 13px;color: #999"><span style="margin-right: 20px;">可用：<i style="font-size: 14px;color: #333;"><?php echo number_format($value['num'],2) ?></i></span> 锁定：<?php echo number_format($value['frozen']+$value['bail'],2) ?></p>
                </div>
                <div class="item-flex card-logo">
                    <p <?php echo isset($cardAttrArr[$value['card_id']]['card_log']) ? 'style="background:url('.$cardAttrArr[$value['card_id']]['card_log'].') no-repeat;background-size: 100% 100%;"' : '' ?> ></p>
                </div>
            </a>
            <hr>
            <div class="lk-container-flex lk-flex-direction-r">
                <ul class="lk-container-flex lk-justify-content-sa">
                    <a class="card-handle" href="./transferBill.php?cardId=<?php echo $value['card_id'] ?>">核销</a>
                    <a class="card-handle" href="./changeInto.php?id=<?php echo $value['id'] ?>">充值</a>
                    
                    <a class="card-handle" href="./recordBooks.php?cardId=<?php echo $value['card_id']; ?>">账单</a>
                    <?php if($value['type'] == option("hairpan_set.platform_type_name")){ ?>
                    <a class="card-handle no-border" href="card_buy.php?uid=<?php echo $value['uid'] ?>">交易</a>
                    <?php }else{ ?>
                    <a class="card-handle no-border" href="./transaction.php?cardId=<?php echo $value['card_id'] ?>">出售</a>
                    <?php } ?>
                </ul>
            </div>
        </div>
       <!--  <hr class="cut-off-rule"> -->
        <?php } ?>
    </div>

    <?php include display('public_menu');?>
    <script type="text/javascript">
    </script>
</body>

</html>
