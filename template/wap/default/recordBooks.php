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
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <style type="text/css">
        p{padding:0;margin:0;}
        .layui-container p{ line-height: 25px;}
        .layui-container p i { color: red; margin-right: 10px;}
        .layui-tab-content { height: auto}
        .lk-content hr{margin: 4px;height: 1px;}
        .lk-container-flex {padding: 0 5px;}
        .order-left{width: 63%;}
        .order-left p{color: #999;}
        .order-right{width: 36.9%;text-align: right;}
        .order-right a{padding: 5px 7px;font-weight: bold; color: #333;}

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
        <h1 class="lk-title">账单记录</h1>
    </header>
    <div class="lk-content">
        <div class="layui-container" id="pullrefreshs" style="touch-action: none;overflow: auto;height: 500px;">
            <div class="layui-tab" lay-filter="aduitTab" id="content"></div>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.slidingPage.js?r=<?php echo time(); ?>" charset="utf-8"></script>
<script type="text/javascript">

$(function(){
    inter("./recordBooks.php?cardId=<?php echo $cardId; ?>",'.layui-container','#pullrefreshs','#content');
});
function strFunc(data){
    var num = Number(data['num']);
    
    var str = '';
    str += '<div class="lk-container-flex">';
        str += '<div class="order-left">';
            str += '<p>账户:'+data['get_address'].substring(0,16)+'...</p><p>时间:'+data['createtime']+'</p>';
        str += '</div>';
        str += '<div class="order-right">';
        if(data['send_address'] == '<?php echo $address ?>'){
            str += '<p style="color: red">-<span class="total">'+num.toFixed(2)+'hsr</span></p>';
            str += '<p><a href="javascript:;">转出成功</a></p>';
        }else{
            str += '<p style="color: green;">+<span class="total">'+num.toFixed(2)+'hsr</span></p>';
            str += '<p><a href="javascript:;">转入成功</a></p>';
        }
        str += '</div>';
    str += '</div><hr>';
  return str;
}
</script>