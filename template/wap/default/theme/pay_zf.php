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
         body{background: white;}
        .lines{width: 90%;margin: 50px auto;}
        .content{margin-top:45px; }
        .yl img{width: 100px;margin-top: -7px;}
        .yl span{font-size: 16px;}
        .zfb img{width: 72px;margin-left: 17px;}
        .zfb span{font-size: 16px;margin-left: 10px;}
        .wx img{width: 50px;margin-left: 27px;}
        .wx span{font-size: 16px;margin-left: 22px;}
        h1{font-size: 18px;margin-top: 39px;margin-left: 35px;}
        h6{color: #737e82;margin-top: 27px;font-size: 16px;margin-left: 19px;}
        .checkbox{float: right;margin-right: 50px;margin-top: 13px;}
       [id^="checkbox-9-"] + label {background-color: #FFF;padding: 9px;border-radius: 5px;display: inline-block;position: relative;margin-left: -20px;z-index: -1;z-index: -1px;width: 45px;box-shadow: 0 0 1px rgba(0,0,0,0.6);height: 10px;}
       [id^="checkbox-9-"]:checked + label:after {content: 'YES';left: 25px;color: #168fbb;}
       [id^="checkbox-9-"] + label:after {content: 'NO';position: absolute;top: 7px;left: 37px;font-size: 1.2em;color: #868686;}
       [id^="checkbox-9-"]{width: 21px;height: 24px;top: 2px;left: 2px;}
       .qj i{color: red;float: right;margin-top: -27px;margin-right: 15px;}
       .j i{color: red;float: right;margin-top: -56px;margin-right: 15px;}
       .qja i{color: red;float: right;margin-top: -35px;margin-right: 15px;}

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
        <div class="yl">
            <img src="<?php echo $config['site_url']?>/template/wap/default/images/yl.jpg">
            <span value="1">绑定银行卡</span>
            <div class="checkbox" id="yl">
                <input type="checkbox" id="checkbox-9-4" /><label for="checkbox-9-4"></label>
            </div>
        </div>
        <div class="zfb">
            <img src="<?php echo $config['site_url']?>/template/wap/default/images/zfb.jpg">
            <span value="2">绑定支付宝</span>
            <div class="checkbox" id="zfb">
                <input type="checkbox" id="checkbox-9-3" /><label for="checkbox-9-3"></label>
            </div>
        </div>
        <div class="wx">
            <img src="<?php echo $config['site_url']?>/template/wap/default/images/wx.jpg">
            <span value="3">绑定微信</span>
            <div class="checkbox" id="wx">
                <input type="checkbox" id="checkbox-9-2" /><label for="checkbox-9-2"></label>
            </div>
        </div>
        </div>


    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
$('#yl').click(function(){
     var tex=$("#checkbox-9-4").parent().prev().attr('value');
     var a=$("#checkbox-9-4").is(':checked');
     if(a==false){
         return false;
     }else{
          window.location.href = "./pay_xq.php?type="+tex+"";
     }
})
$('#zfb').click(function(){
     var tex=$("#checkbox-9-3").parent().prev().attr('value');
     var a=$("#checkbox-9-3").is(':checked');
     if(a==false){
         return false;
     }else{
          window.location.href = "<?php echo $config['site_url']?>/wap/pay_xq.php?type="+tex+"";
     }
})
$('#wx').click(function(){
     var tex=$("#checkbox-9-2").parent().prev().attr('value');
     var a=$("#checkbox-9-2").is(':checked');
     if(a==false){
         return false;
     }else{
          window.location.href = "<?php echo $config['site_url']?>/wap/pay_xq.php?type="+tex+"";
     }
})
</script>

</html>
