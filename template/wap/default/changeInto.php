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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/clipboard.min.js" charset="utf-8"></script>
    <style type="text/css">
        .codeAddress{
            padding: 10px 15px; 
            line-height: 40px; 
            color: #666;
            border: 1px solid #000;
            margin:70px 10px;
            border-radius: 10px;
        }
        .code{width:202px;height:202px;margin:auto;}
        #getAddress{text-align:center;}
        .otherFunc{padding:10px 25px;margin:20px;}
        .codeAddress h2{text-align: center;color: #abaf05}
        .getAdd{
            display: flex;
            margin-top: 25px; 
        }
        .lk-btn{
            width: 85px;
            margin-left: 10px;
            padding: 0px 0px;
            color: #f6bc00;
            border: 1px solid #f6bc00;
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
        <h1 class="lk-title">收款</h1>
    </header>
    <div class="lk-content">
        <div class="codeAddress">
            <h2>收款二维码</h2>
            <div class="code"><img src="<?php echo $code; ?>" /></div>
            <div class="getAdd">
                <p id="getAddress" ><?php echo $userInfo['address'] ?></p>
                <a class="layui-btn layui-btn-primary lk-btn" id="copyAddress" data-clipboard-target="#getAddress">点击复制</a>
            </div>
        </div>
        <div class="otherFunc">
            <p style="font-size: 12px;color: red;text-align: center;">此地址为此卡的收款地址,妥善保管</p>
            <!-- <h2 >付款方</h2> -->
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
    layui.use(['layer','element'],function(){
        var layer = layui.layer;
        var element = layui.element;
        // 点击复制功能
        $("#copyAddress").bind("click",function(){
            var clipboard = new ClipboardJS("#copyAddress");
            clipboard.on("success",function(e){
                e.clearSelection();
                layer.msg("复制成功",{ icon: 1, skin: "demo-class" });
            })
            clipboard.on("error",function(e){
                layer.msg("复制失败",{ icon: 5, skin: "demo-class" });
            })

        })
    })
</script>
</html>
