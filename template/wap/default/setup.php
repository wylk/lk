<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>设置</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
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
            width: 15%;
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
<div class="lk-content" style="background-color: #f2f2f2;height: 100%;margin-bottom: 0px;">
    <a href="./pay_pw.php">
        <div class="item-row lk-container-flex" style="margin: 0px auto 0px;">
            <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe71c;</i></div>
            <div class="item-row-title row" >支付密码</div>
            <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 18px;color: #999">&#xe6a7;</i></div>
        </div>
    </a>
    <hr class="layui-bg-gray">
              <span class="show">
                    <a href="./pay_zf.php">
                         <div class="item-row lk-container-flex" style="margin: 0px auto">
                            <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;"><img src="<?php echo $config['site_url']?>/template/wap/default/images/zf.png" width="23px;"></i></div>
                            <div class="item-row-title row" >支付管理</div>
                            <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 18px;color: #999">&#xe6a7;</i></div>
                        </div>
                    </a>
                    <hr class="layui-bg-gray">
                    <?php if($user['status'] == 2){?>
                    <a href="./map.php">
                    <div class="item-row lk-container-flex" style="margin: 0px auto" >
                        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe715;</i></div>
                        <div class="item-row-title row"  >地址设置</div>
                        <div class="item-row-arrow row center" ><i class="iconfont"   style="font-size: 18px;color: #999">&#xe6a7;</i></div>
                    </div>
                    </a>
                    <?php }?>
                </span>

     <div class="item-row lk-container-flex" style="margin: 20px auto 0px;">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6ba;</i></div>
        <div class="item-row-title row" >联系客服</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 18px;color: #999">&#xe6a7;</i></div>
    </div>

   <!--  <hr class="layui-bg-gray">
   <div class="item-row lk-container-flex" style="margin: 20px auto 0px;>
       <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6c7;</i></div>
       <div class="item-row-title row" >联系客服</div>
       <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
   </div> -->
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6f5;</i></div>
        <div class="item-row-title row" >关于我们</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 18px;color: #999">&#xe6a7;</i></div>
    </div>
    <a href="javascript:;" id = "signOut">
     <div class="item-row lk-container-flex" style="margin: 40px auto 10px;">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe718;</i></div>
           <?php if(is_weixin()){?>
              <div class="item-row-title row" >退出登录</div>
        <?php }else{?>
             <div class="item-row-title row" >退出登录</div>
         <?php } ?>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 18px;color: #999">&#xe6a7;</i></div>
    </div>
    </a>
</div>
</body>
</html>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
 <script type="text/javascript">
    $(function(){
        lk.is_weixin() && function(){
            $('.lk-bar-nav').css('display','none');
            $('.lk-content').css({"padding":"0px"});
        }()
    })
</script>
<script type="text/javascript">

         //var url = "<?php echo './login.php?referer='.urlencode($_SERVER['REQUEST_URI']);?>";   
        var url = "index.php";   
        layui.use(['form','layer'], function(){
            var layer = layui.layer;
            //退出登录
            $("#signOut").bind("click",function(){
                var phone = <?php echo $wap_user['phone'];?>;
                $.post("./login.php",{phone:phone,type:"signOut"},function(res){
                    if(res.error == 0){
                        layer.msg(res.msg,{icon:1,time:2000},function(){
                            window.location.href = url;
                        });
                    }
                },'json')
            })
        });


</script>



