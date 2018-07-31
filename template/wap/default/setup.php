<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
       
        .item-row{
            background-color: #fff;
            width: 100%;
            line-height: 45px;
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
        .layui-bg-gray{
            margin: 0px 0px;
        }
        .row-flow{
            height: 10px;
        }
    </style>
</head>
<body>
     <header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">设置</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">
    <a href="./pay_pw.php">
        <div class="item-row lk-container-flex" style="margin: 20px auto 0px;">
            <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe71c;</i></div>
            <div class="item-row-title row" >账户安全设置</div>
            <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
        </div>
    </a>
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6ba;</i></div>
        <div class="item-row-title row" >消息设置</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>


    <div class="item-row lk-container-flex" style="margin: 20px auto 0px;">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe715;</i></div>
        <div class="item-row-title row" >地理位置设置</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6c7;</i></div>
        <div class="item-row-title row" >联系客服</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6f5;</i></div>
        <div class="item-row-title row" >关于我们</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <a href="javascript:;" id = "signOut">
     <div class="item-row lk-container-flex" style="margin: 40px auto 10px;">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe718;</i></div>
        <div class="item-row-title row" >退出登录</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    </a>
    <div class="row-flow"></div>
</div>
</body>
</html>
<script type="text/javascript">

layui.use(['form','layer'], function(){
    var layer = layui.layer;
    //退出登录
    $("#signOut").bind("click",function(){
        var phone = <?php echo $wap_user['phone'];?>;
        $.post("./login.php",{phone:phone,type:"signOut"},function(res){
            if(res.error == 0){
                layer.msg(res.msg,{icon:1,time:2000},function(){
                    window.location.href = "./login.php";
                });
            }
        },'json')
    })
});
</script>