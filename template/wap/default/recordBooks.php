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
        .layui-container p{ line-height: 25px;}
        .layui-container p i { color: red; margin-right: 10px;}
        .layui-tab-content { height: auto}
        .lk-content hr{margin: 0}
        .lk-container-flex {padding: 0 5px;}
        .order-left{width: 63%;}
        .order-right{width: 36.9%;text-align: right;}

    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">账单记录</h1>
    </header>
    <div class="lk-content">
         <div class="layui-container">
            <div class="layui-tab" lay-filter="aduitTab">
                <?php if(isset($recordList)){?>
                    <?php  foreach($recordList as $key=>$value){ ?>
                    <div class="lk-container-flex">
                        <div class="order-left">
                            <p>账户:<?php echo substr($value['get_address'],0,16) ?>...</p>
                            <p>时间:<?php echo date("Y-m-d H:i:s",$value['createtime']) ?></p>
                        </div>
                        <div class="order-right">
                            <?php if($value['send_address'] == $address){ ?>
                                <p style="color: red">-<span class="total"><?php echo number_format($value['num'],2)?>hsr</span></p>
                                <p><a class="" style="padding: 5px 7px;font-weight: bold;" href="">转出成功</a></p>
                            <?php }else{ ?>
                                <p style="color: green;">+<span class="total"><?php echo number_format($value['num'],2)?>hsr</span></p>
                                <p><a class="" style="padding: 5px 7px;font-weight: bold;" href="">转入成功</a></p>
                            <?php }?>
                        </div>
                    </div>
                    <hr>
                    <?php } ?>
                <?php }else{?>
                    <div style="margin: 50px auto;text-align: center;"><h3>暂无账单记录</h3></div>
                <?php }?>
            </div>
                   
            </div>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
</html>
