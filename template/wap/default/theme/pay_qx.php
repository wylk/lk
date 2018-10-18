
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
        .lines{width: 90%;margin: 50px auto;}
        h6{color: red;margin-top: 26px;font-size: 16px;margin-left: 23px;}
        .name{    font-size: 24px;
    margin-top: 29px;
    margin-left: 39px;}
        .phone{    font-size: 24px;
    margin-top: 29px;
    margin-left: 39px;}
        .pwd{    font-size: 24px;
    margin-top: 29px;
    margin-left: 39px;}
    h4{color: red;
    margin-top: 73px;
    text-align: center;
    font-size: 16px;}
     h5{color: red;
    margin-top: 73px;
    text-align: center;
    font-size: 16px;}
    button{     font-size: 19px;
    color: #1d0b03f2;
    width: 94%;
    height: 46px;
    margin-left: 2%;
    margin-top: 37px;
    background-color: #fdd261;
    border-radius: 8px;}



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
        <h1 class="lk-title">
        <?php if($tex=='1'){?>修改银行卡
        <?php }else if($tex=='2'){?>
             修改支付宝
        <?php }else{?>
             修改微信
        <?php } ?>

        </h1>
    </header>
    <div class="lk-content">
          <?php if($tex=='1'){?>
               <h6>必须是本人的银行卡</h6>
        <?php }else if($tex=='2'){?>
              <h6>必须是本人的支付宝账号</h6>
        <?php }else{?>
              <h6>必须是本人的微信账号</h6>
        <?php } ?>


        <div class="name">用户</div>
        <div class="phone">账号</div>
        <div class="pwd">密码</div>
        <h4>点击下方上传收款二维码</h4>


        <div class="wrapper">
        <label>
        <input style="position:absolute;opacity:0;" type="file" name="file" id="Album_img" accept="image/gif,image/jpeg,image/x-png"/>
        <img style="    width: 64%;
    height: 162px;
    margin-left: 18%;" src="http://lk.com/template/wap/default/images/img.jpg">
        </label>

        </div>

        <div>
              <h1 class="lk-title">
        <?php if($tex=='1'){?>
              <h5>请拍摄银行卡正面,必须是能看清卡号的哦~上传即可</h5>
        <?php }else if($tex=='2'){?>
             <h5>打开支付宝app,在首页打开收钱，打开个人收款二维码,保存图片上传即可</h5>
        <?php }else{?>
              <h5>打开微信app,点击+号,打开收付款,选择收款,保存图片上传即可</h5>
        <?php } ?>

        </h1>

        </div>
        <?php if($tex=='1'){?>
              <button>
            修改银行卡
        </button>
        <?php }else if($tex=='2'){?>
             <button>
            修改支付宝
        </button>
        <?php }else{?>
            <button>
            修改微信
        </button>
        <?php } ?>



    </div>
    <?php include display('public_menu');?>
</body>


</html>
