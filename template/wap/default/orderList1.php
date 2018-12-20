<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>订单列表</title>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>

    <style type="text/css">
    body,.lk-content{ background-color: #f2f2f2;}

    .content{margin:15px 5px;}
    .wrapper{}
    .bar{height: 40px;background: white;display: flex;flex-direction:row;justify-content: center;}
    .bar_nav{display:flex;width: 30%;justify-content: center;align-items: center;color:#999;font-size: 15px;}
    .action{border-bottom: 1px solid #29aee7;color: #29aee7}
    .order_list{display: none;}

/*订单列表*/
    .order-content{height:106px;background-color: white;border-radius: 5px;padding:8px 15px;margin-bottom:10px;display: block;}
    .order-line{color:#999;width: 100%;margin: 3px 0;font-size: 16px;padding:3px 0;}
    .order-attr{width: 30%;}
    .left{float: left;}
    .right{float: right;}
    .order-font{font-size: 14px;}
    .order-color{color: #333;}


    </style>
     <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
</head>

<body>
    <div class="lk-content" style="padding: 0px;margin: 0px;">
        <div class="wrapper" >
            <div class="bar">
                <span class="bar_nav action" name="all">全部订单</span>
                <span class="bar_nav" name='unpaid' >未付款</span>
                <span class="bar_nav" name="paid">付款</span>
            </div>
            <div class="content">
                <div id="pullrefreshs_all" class="order_list" style="display: block;touch-action: none;overflow: auto;height: 500px;">
                    <div><div id="content_all"></div></div>
                </div>
                <div id="pullrefreshs_unpaid" class="order_list" style="touch-action: none;overflow: auto;height: 500px;">
                    <div><div id="content_unpaid"></div></div>
                </div>
                <div id="pullrefreshs_paid" class="order_list" style="touch-action: none;overflow: auto;height: 500px;">
                    <div><div id="content_paid"></div></div>
                </div>
            </div>
        </div>
    </div>
    <?php //include display('public_menu');?>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.slidingPage.js?r=<?php echo time(); ?>" charset="utf-8"></script>
<script type="text/javascript">
    $(".bar_nav").bind("click",function(){
        var name = $(this).attr("name");
        $(".content .order_list").hide();
        $(this).parent().find("span").attr("class","bar_nav");
        $("[name="+name+"]").attr("class","bar_nav action");
        $("#pullrefreshs_"+name).show();
    });
// ***************** 分页 start *****************
$(function(){
    inter("./orderList.php",'.bar .bar_nav','#pullrefreshs_','#content_','name');
});
function strFunc(data){
    var price = Number(data['price']);
    var number = Number(data['number']);
    var sumPrices = Number(data['price']*data['number']);
  var str = '';
    str += '<a class="order-content" href="./orderDetail.php?id='+data['id']+'">';
    str += '<div class="order-line"><span>订单：'+data['onumber']+'</span>';
    if(data['status'] == 0){
        str += '<span class="right" style="color: #333;"><i class="mui-icon mui-icon-plusempty" style="color: #29aee7;"></i>&nbsp;付款</span></div>';
    }else{
        str += '<span class="right" style="color: #29aee7;">';
        if(data['status'] == 1) str += "交易成功";
        if(data['status'] == 2) str += "订单取消";
        if(data['status'] == 3) str += "已付款";
        if(data['status'] == 4) str += "订单超时";
        str += "</span></div>";
    }
    str += '<div class="order-line order-font"><span>'+getTime(data['create_time'])+'</span></div>';
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
