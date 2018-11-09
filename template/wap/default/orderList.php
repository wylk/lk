<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>订单列表</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>

    <style type="text/css">
    body,.lk-content{ background-color: #f2f2f2;}
    .order-content{height:106px;background-color: white;border-radius: 5px;padding:8px 15px;margin-bottom:10px;display: block;}
    .order-line{color:#999;width: 100%;margin: 3px 0;font-size: 16px;padding:3px 0;}
    .order-attr{width: 30%;}
    .left{float: left;}
    .right{float: right;}
    .order-font{font-size: 14px;}
    .order-color{color: #333;}
    .layui-tab-content{padding:0px;margin-top: 10px;}
    .layui-tab{margin:0;}
    .layui-tab-title{color: #999;}
    .layui-tab-brief>.layui-tab-title .layui-this{color:#333;}
    .layui-tab-brief>.layui-tab-title .layui-this:after{border-bottom: 1px solid #29aee7;}

    .content{border:1px solid red;height: 600px;}
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
    <div class="lk-content">
         <div class="layui-container">
            <div class="layui-tab layui-tab-brief" lay-filter="aduitTab">
                <ul class="layui-tab-title" style="background-color: white;">
                    <li class="layui-this " name="tab_all">全部订单</li>
                    <li class="" name="tab_unpaid">未付款订单</li>
                    <li class="" name="tab_paid">付款订单</li>
                </ul>
                <div class="layui-tab-content" >
                    <div class="layui-tab-item layui-show " id="pullrefreshs_all" style="touch-action: none;overflow: auto;height: 500px;">
                        <div id="content_all" ></div>
                    </div>
                    <div class="layui-tab-item " id="pullrefreshs_unpaid" style="touch-action: none;overflow: auto;height: 500px;">
                        <div id="content_unpaid" ></div>
                    </div>
                    <div class="layui-tab-item " id="pullrefreshs_paid" style="touch-action: none;overflow: auto;height: 500px;">
                        <div id="content_paid" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.slidingPage.js?r=<?php echo time(); ?>" charset="utf-8"></script>
<script type="text/javascript">
  layui.use(['element'],function(){
    var element = layui.element;
  })
// ***************** 分页 start *****************
$(function(){
    inter("./orderList.php",'.layui-tab-title li','#pullrefreshs_','#content_','name');
});
function strFunc(data){
    var price = Number(data['price']);
    var number = Number(data['number']);
    var sumPrices = Number(data['price']*data['number']);
  var str = '';
    str += '<a class="order-content" href="./orderDetail.php?id='+data['id']+'">';
    str += '<div class="order-line"><span>订单：'+data['onumber']+'</span>';
    if(data['status'] == 0){
        str += '<span class="right" style="color: #333;"><i class="layui-icon" style="color: #29aee7;">&#xe654;</i>&nbsp;付款</span></div>';
    }else{
        str += '<span class="right" style="color: #29aee7;">';
        if(data['status'] == 1) str += "交易成功";
        if(data['status'] == 2) str += "订单取消";
        if(data['status'] == 3) str += "已付款";
        if(data['status'] == 4) str += "订单超时";
        str += "</span></div>";
    }
    str += '<div class="order-line order-font"><span>'+data['create_time']+'</span></div>';
    str += '<div class="order-line">';
        str += '<div class="order-attr left order-font"><span>数量：</span><span class="order-color">'+number.toFixed(2)+'</span></div>';
        str += '<div class="order-attr left order-font"><span>价格：</span><span class="order-color">'+price.toFixed(2)+'</span></div>';
        str += '<div class="order-attr right order-color"><span class="right">总额：'+sumPrices.toFixed(2)+'</span></div>';
    str += '</div>';
    str += '</a>';
  return str;
}
// ***************** 分页 end *****************
</script>
</html>

