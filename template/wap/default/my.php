<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .item-headers{
            margin: 0px auto 10px;
            background: #477359;
            height: 100px;
            color: #fff;
        }
        .item-header-img{
            width: 40%;
            height: 100px;
        }
        .item-header-name{
            width: 60%;
            height: 100px;
        }
        .item-rows{
            min-height: 200px;
            background: #fff;
            padding-top: 10px;
        }
        .item-row{
            width: 95%;
            line-height: 30px;
        }
        .item-row-title{
           flex-grow: 1;
        }
        .center{
            text-align: center;
        }
        .row{
            width: 18%;
        }
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">个人中心</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">

    
        <div class="item-headers lk-container-flex" >
            <div class="item-header-img lk-container-flex lk-justify-content-c lk-align-items-c"> <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg" style="height: 80px;width: 80px;border-radius: 50%;"></div>
            <div class="item-header-name lk-container-flex lk-align-items-c"> 
                <div>
                    <p>老王</p>    
                    <p style="margin-top: 5px;">手机号:<?php echo $phone; ?></p>    
                </div>
            </div>
           
        </div>
        <div class="item-rows">
            <?php foreach ($menu as $k => $v) {?>
            <a href="<?php echo $v['url'];?>">
                <div class="item-row lk-container-flex" style="margin: 0px auto;">
                    <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;"><?php echo $v['icon'];?></i></div>
                    <div class="item-row-title row" ><?php echo $v['title'];?></div>
                    <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
                </div>
            </a>
            <hr class="layui-bg-gray">
            <?php }?>
        </div>
</div>
<?php include display('public_menu');?>
</body>
</html>
