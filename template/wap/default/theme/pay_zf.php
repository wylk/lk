<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>支付密码</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lines{
            width: 90%;
            margin: 50px auto;
        }
        .content{margin-top:45px; }
        .yl img{width: 100px;}
        .yl span{font-size: 21px;border-bottom: 2px solid #e0dede;}
        .zfb img{width: 75px;margin-left: 17px;margin-top: 15px;}
        .zfb span{font-size: 21px;border-bottom: 2px solid #e0dede;margin-left: 10px;}
        .wx img{width: 55px;margin-left: 27px;margin-top: 15px }
        .wx span{font-size: 21px;border-bottom: 2px solid #e0dede;margin-left: 22px;}
        h1{font-size: 40px;margin-top: 39px;margin-left: 35px;}
        h6{color: red;margin-top: 27px;font-size: 16px;margin-left: 19px;}

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
        <h1 class="lk-title">支付设置</h1>
    </header>
    <div class="lk-content">
        <h1>支付管理</h1>
        <h6>设置收款方式必须是本人账号</h6>
        <div class="content">
        <div class="yl"><img src="http://lk.com/template/wap/default/images/yl.jpg"><span>绑定银行卡</span></div>
        <div class="zfb"><img src="http://lk.com/template/wap/default/images/zfb.jpg"><span>绑定支付宝</span></div>
        <div class="wx"><img src="http://lk.com/template/wap/default/images/wx.jpg"><span>绑定微信</span></div>
        </div>


    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">

</script>

</html>
