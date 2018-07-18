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
        .layui-container p{ line-height: 35px;}
    .layui-container p i { color: red; margin-right: 10px;}
    .layui-tab-content { height: auto}
        .lk-content hr{margin: 0}
       .lk-container-flex {padding: 0 5px;}
       .order-left{width: 63%}
        .order-right{width: 37%;text-align: right;}

    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">账单记录</h1>
    </header>
    <div class="lk-content">
         <div class="layui-container">
            <div class="layui-tab layui-tab-card" lay-filter="aduitTab">
                <?php foreach($recordList as $key=>$value){ ?>
                <?php if($value['send_address'] == $address){ ?>
                <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell" style="background-color: red">
                    <div class="order-left">
                        <p>账户：<?php echo $value['get_address'] ?></p>
                        <p><?php echo date("Y-m-d H:i:s",$value['createtime']) ?></p>
                    </div>
                    <div class="order-right">
                        <p><a class="" style="padding: 5px 7px" href=""></a></p>
                        <p>总金额：-<span class="total"><?php echo number_format($value['num'],2)?></span></p>
                    </div>
                </div>
                <hr>
                <?php }else{ ?>
                <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell" style="background-color: green;">
                    <div class="order-left">
                        <p>账户：<?php echo $value['send_address'] ?></p>
                        <p><?php echo date("Y-m-d H:i:s",$value['createtime']) ?></p>
                    </div>
                    <div class="order-right">
                        <p><a class="" style="padding: 5px 7px" href=""></a></p>
                        <p>总金额：<span class="total"><?php echo number_format($value['num'],2)?></span></p>
                    </div>
                </div>
                <hr>
                <?php }} ?>
            </div>
                   
            </div>
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
