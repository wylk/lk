<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>个人中心</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .item-headers{
            margin: 0px auto 20px;
            background-image: url('../template/wap/default/images/my.jpg?r=234');
            background-repeat:no-repeat;
            background-size:100% 100%;
            -moz-background-size:100% 100%;
            height: 100px;
            color: #fff;
        }
        .item-header-img{
            width: 30%;
            height: 100%;
        }
        .item-header-name{
            width: 60%;
            height: 100%;
            color: #999;
        }
        .item-rows{
            min-height: 80px;
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
        .user_info p:first-child{
            color: #fff;
            font-size: 16px;
        }
        img{
           height: 65px;
           width: 65px;
           border-radius: 2%; 
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
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">个人中心</h1>
  </header>
<div class="lk-content" style="background-color: #f2f2f2;">


        <div class="item-headers lk-container-flex" >
            <div class="item-header-img lk-container-flex lk-justify-content-c lk-align-items-c">
                <?php  if($res['avatar']){?>
                    <img src="<?php echo $res['avatar'];?>">
                <?php }else{?>
                    <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg">
               <?php } ?></div>
            <div class="item-header-name lk-container-flex lk-align-items-c">
                   <div class="user_info">
                        <?php if($res['name']){?>
                             <p><?php echo  $res["name"];?></p>
                        <?php }else{?>
                             <p>乐卡用户</p>
                        <?php }?>

                    <p style="margin-top: 10px;color: #f0f0f0;">手机号:<?php echo $phone; ?></p>
                    </div>
            </div>

        </div>
        <div class="item-rows">
            <?php foreach ($menu as $k => $v) {?>
            <?php if(isset($v['msg'])){ ?>
                <a href="javascript:;" onclick="showMsg('<?php echo $v['msg']; ?>')">
            <?php }else{ ?>
                <a href="<?php echo $v['url'];?>">
            <?php } ?>
                <div class="item-row lk-container-flex " style="margin: 0px auto;">
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
<script type="text/javascript">
    var layer;
    layui.use(['layer'],function(){
        layer = layui.layer;
    })
    function showMsg(msg){
        layer.msg(msg, { icon: 5, skin: "demo-class" });
    }
</script>
