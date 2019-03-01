<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>卡片交易订单</title>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
     <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .lk-deal-link a{width: 25%;text-align: center; line-height: 45px; font-size:15px;}
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell{padding: 2% 5%;}
        .lk-bazaar-sell p{line-height: 25px}
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
        .order-left{width: 55%}
        .order-right{width: 45%;text-align: right;}
        .b{font-size:16px;color:#5FB878}
        .s{font-size:16px;color:#FF5722}
        .total{color:#393D49;font-weight: 550; font-size:16px}
         #action {
            color: #29Aee7;
            border-bottom: 1px solid #29Aee7;
        }
        .title{display: flex;padding: 0 5px;line-height: 35px;color: #999;}
        .title a{color:#999;width:25%;text-align: center; line-height: 40px; font-size:14px;}

        .mui-scroll-wrapper,.mui-scroll,.mui-scrollbar{/*position: relative;*/background: white;}
        p{color:#333;margin-bottom: 0px;}
        .content hr{height: 1px; margin: 10px 0; border: 0; clear: both;}
    </style>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
</head>

<body>
    <div class="content">
        <div id="pullrefresh" class="mui-content mui-scroll-wrapper">
            <div class="mui-scroll" >
                <div class="title" style="background-color: #fff;">
                    <a href="card_buy.php" >买入</a>
                    <a href="card_sell.php">卖出</a>
                    <a href="card_order.php" >订单</a>
                    <a href="card_orderlist.php" id="action">订单记录</a>
                </div>
                <div id="order_content"></div>
            </div>
        </div>

    </div>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
  mui('body').on('tap','a',function(){
    window.top.location.href=this.href;
});
mui.init({
    pullRefresh: {
        container: '#pullrefresh',
        down:{
            style:'circle',
            callback:pulldownRefresh
        },
        up:{
            auto:true,
            contentrefresh:'正在加载...',
            callback:pullupRefresh
        }
    }
});

function pulldownRefresh(){
    var data = {type:"page",page:1};
    mui.post("./card_orderlist.php",data,function(result){
        if(result.error == 0 && result.data.length > 0){
            var strHtml = "";
            $.each(result.data,function(key,value){
                strHtml += strFunc(value);
            })
            $("#order_content").html(strHtml);
            page = 2;
        }
        mui("#pullrefresh").pullRefresh().endPulldownToRefresh(false);
        mui("#pullrefresh").pullRefresh().refresh(true);
    },"json");

}
var page = 1;
function pullupRefresh(){
    var strHtml = '';
    var data = {type:"page",page:page};
    $.post("./card_orderlist.php",data,function(result){
        console.log(result);
        console.log(result.data.length);
        if(result.error == 0 && result.data.length > 0){
            $.each(result.data,function(key,value){
                strHtml += strFunc(value);
            })
            page++;
            $("#order_content").append(strHtml);
            mui("#pullrefresh").pullRefresh().endPullupToRefresh(false);
        }else{
            mui("#pullrefresh").pullRefresh().endPullupToRefresh(true);
        }
    },"json");
}
function strFunc(data){
    var userId = "<?php echo $userId ?>";
    var number = new Number(data['number']);
    var price = new Number(data['price']);
    var str = "";
    str += '<div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell" style="background: white;">';
    str += '<div class="order-left">';
    if(data['sell_id'] == userId)
        str += '<p><span class="s">卖出</span>';
    else
        str += '<p><span class="b">买入</span>';
    str += '单号：'+data['onumber']+'</p><p><?php echo date("Y-m-d H:i:s",$value['create_time']) ?>下单</p>';
    str += '<p>数量：'+number.toFixed(2)+'</p>';
    str += '</div>';
    str += '<div class="order-right">';
    str += '<p><a class="layui-bg-cyan" style="padding: 5px 7px" href="card_orderDetail.php?id='+data['id']+'" >查看详情</a></p>';
    str += '<p>价格：￥'+price.toFixed(2)+'</p>';
        str += '<p style="color: #2F4056">已完成</p>';
    str += '<p>总金额：<span class="total">￥'+(number*price).toFixed(2)+'</span></p>';
    str += '</div></div><hr>';
    return str; 
}
  (function($){
        $(".mui-scroll-wrapper").scroll({
            bounce:false,
            indicators:false
        })
    })
</script>
</body>

</html>
