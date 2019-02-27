<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <!--  <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
   <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>"> -->
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <style type="text/css">
        body{
            background-color: #f2f2f2;

        }
        .lk-container-flex{
            display: flex;
        }
        .title{display: flex;padding: 0 5px;line-height: 35px;color: #999;}
        .title a{color:#999;width:25%;text-align: center; line-height: 40px; font-size:14px;}
        .input-line{
            background-color: #fff;
            margin-top:10px;
            color: #999;
            font-size: 14px;
            border-radius: 3px;
            margin:5px;
        }
        .input-link{
            display: flex;
            padding: 0 15px;
            border:1px solid #f2f2f2;
            height: 50px;
            align-items:center;
        }
        input[type=text]{
            width: 40%;
            border: 0px;
            margin: 0px;
        }
        .input-title{
            width: 65%;
            line-height: 50px;
        }
        .btn-link{
            height: 80px;
            text-align: center;
            padding-top: 20px;
            border:1px solid #f2f2f2;
        }
        #sellTran{
            color: #999;
            border-color: #29Aee7;
        }

        .lk-deal-link a{text-align: center; line-height: 45px; font-size:15px;padding: 0 3px;}
        .lk-deal-link a input[type='text']{display: inline;border:none; background-color: #ffffff;}
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell{width: 80%;padding: 5px;}
        .lk-bazaar-sell p{height: 27px;line-height: 27px;}
        /*.lk-bazaar-sell p{width:38%; padding-left:3%; line-height: 25px}*/
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
        .register div{width:20%;height:38px;line-height:38px;margin-left:20px;}
        #action {
            color: #29Aee7;
            border-bottom: 1px solid #29Aee7;
        }
        .sell-order{
            background-color: #fff;
            margin: 3px 6px;
            border-radius: 5px;
        }
        .order-ul{width: 100%;}
        .order_num,.order_price{display: block; float: left;}
        .order_num{color:#333;}
        .order_price{color: #999;margin-left: 10px;}
        .order_money{color: red}
        .mui-table-view-cell{padding: 8.8px 15px;}
        .order_sellBtn{float: right;position: absolute;right: 10px;top:0px;    font-size: 14px; color: #29Aee7;}
        .mui-media img{border-radius: 5px; }
        .wei{ width: 25%; float: left; height: 30px; line-height: 1.9rem;text-align: center;color:#999;}
        .wei button{border:0;color:#29Aee7; }
    </style>
</head>

<body>

    <div class="content">

    <div id="pullrefresh" class="mui-content mui-scroll-wrapper">
    <div class="mui-scroll">
            <div class="title" style="background-color: #fff;">
                <a href="card_buy.php" >买入</a>
                <a href="card_sell.php" id="action">卖出</a>
                <a href="card_order.php">订单</a>
                <a href="card_orderlist.php">订单记录</a>
            </div>
            <div class="input-line">
                <div class="input-link">
                    <div  class="input-title">
                            <span>卖出价：<input type='text' name="sellPrice" value='<?php echo number_format(option('hairpan_set.price'),2) ?>' placeholder="<?php echo number_format(option('hairpan_set.price'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></span>
                            </div>
                             <div style="color: #333">余额：<?php echo number_format($platformInfo['num'],2); ?></div>
                </div>
                <div class="input-link">
                    <div  class="input-title">
                    <span>卖出数量：<input type='text' name="sellNum" value='' placeholder="<?php echo number_format(option('hairpan_set.limit'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                    </span>
                    </div>
                    <div>WLK</div>

                </div>
                <div class="input-link">
                        <div  class="input-title">
                        <span>最低卖出量：<input type='text' name="limitNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                        </span></div>
                        <div>WLK</div>

                </div>
                <div class="input-link">
                       <div class="input-title">兑换资金:<span id="money">0.00</span></div>
                       <div>RMB</div>
                </div>
                <div class="btn-link">
                    <button  id="sellTran" class="mui-btn mui-btn-primary mui-btn-outlined" style="width: 70%">卖出</button>
                </div>
            </div>
            <?php if($register){ ?>

          <div style="background-color: #fff;color: #999;">
            <div class="lk-container-flex" style="background-color: #fff;margin-top: 5px;">
                <h3 style="font-size:16px; font-weight: 600; padding:20px 0 10px 20px">委托卖单</h3>
            </div>
        <ul class="mui-table-view">
            <li class="mui-table-view-cell mui-media">
                <div class="mui-media-body">
                    <p class="mui-ellipsis wei">数量</p>
                    <p class="mui-ellipsis wei">单价</p>
                    <p class="mui-ellipsis wei">总价</p>
                    <p class="mui-ellipsis wei">操作</p>
                </div>
            </li>
            <?php foreach($register as $key=>$value){ ?>
            <li class="mui-table-view-cell mui-media" id="register_<?php echo $value['id'] ?>">
                <div class="mui-media-body">
                    <p class="mui-ellipsis wei" id="num_<?php echo $value['id'] ?>"><?php echo number_format($value['num'],2) ?></p>
                    <p class="mui-ellipsis wei"><?php echo number_format($value['price'],2) ?></p>
                    <p class="mui-ellipsis wei"><?php echo number_format($value['price']*$value['num'],2) ?></p>
                    <p class="mui-ellipsis wei">
                        <button type="button" id="revoke_<?php echo $value['id'] ?>">撤销</button>
                    </p>
                </div>
            </li>
            <?php } ?>
            </div>
        </ul>
            <?php } ?>
             <div class="lk-container-flex" style="background-color: #fff;margin-top: 5px;">
                <h3 style="font-size:15px; font-weight: 600; padding:8px 0 8px 20px">市场卖单</h3>
            </div>
        <!-- 买单展示 -->
        <ul class="mui-table-view order-ul"  id="buylist_content"></ul>
    </div>
</div>

      
    </div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
mui("body").on("tap","a",function(){
    document.location.href = this.href;
})
    $("#sellTran").bind("click",function(){
        console.log("dkjjjkj");
        var price = $("[name=sellPrice]").val();
        var num = $("[name=sellNum]").val();
        var limit = $('[name=limitNum]').val();
        var id = "<?php echo $platformInfo['id'] ?>";
        var data = {"price":price,"num":num,"id":id,"limitNum":limit,"type":"register"};
        console.log(data);
        $.post("./card_sell.php",data,function(res){
            console.log(res);
            //layer.closeAll("loading");
            if(!res.res){
                mui.toast(res.msg);
                window.location.reload(true);
            }else{
                mui.toast(res.msg);
               if(res.url){
                    setTimeout(function(){
                        window.location.href = res.url;
                    },1000);
               }
            }
        },"json");
    })

    // $("[name=limitNum]").bind("keyup",function(){
    //     var sellNum = $("[name=sellNum]").val();
    //     var limitNum = $("[name=limitNum]").val();
    //     if(limitNum > sellNum){
    //         layer.msg("售卖最低限制数量不得大于售卖数量",{icon:5,skin:"demo-class"});
    //     }
    // })
    // $("[id^=transaction]").bind("click",function(){
    function tranFunc(tranId,num){
        console.log(tranId,num);
        // var idStr = $(this).attr("id");
        // var tranId = idStr.substring(idStr.indexOf("_")+1);
        var packageId = "<?php echo $platformInfo['id']; ?>";
        // var num = $("#num_"+tranId).html();
        var data = {'type':"transaction","tranId":tranId,"packageId":packageId,"num":num};
        $.post("./card_sell.php",data,function(result){
            console.log(result);
            if(!result['res']){
                 mui.toast(result.msg);
                window.location.href = "./card_order.php";
            }else{
                 mui.toast(result.msg);
                if(result.url){
                    setTimeout(function(){
                        window.location.href = result.url;
                    },1000);
               }
            }
        },'json');
    }
    // });
    $("[id^=revoke_]").bind("click",function(){
        var idStr = $(this).attr("id");
        var tranId = idStr.substring(idStr.indexOf("_")+1);
        var packageId = "<?php echo $platformInfo['id']; ?>";
        var data = {"tranId":tranId,"packageId":packageId,"type":"revoke"}
        $.post("./card_sell.php",data,function(result){
            console.log(result);
            if(!result.res){
                 mui.toast(result.msg);
                $("#register_"+tranId).remove();
                // window.location.reload(true);
            }else{
                mui.toast(result.msg);
            }
        },"json")
    })

$('input[name^=sell]').bind("keyup",function(){
    var price = $("[name=sellPrice]").val();
    var num = $("[name=sellNum]").val();
    var money = price*num;
    console.log(money);
    $("#money").html(money);
})

// ***************** 分页 start *****************
var page = 0;
mui.init({
    pullRefresh: {
        container: '#pullrefresh',
        up:{
            auto:true,
            contentrefresh:'正在加载...',
            callback:pullupRefresh
        }
    }
});

function pullupRefresh(){
    console.log(page);
    var data = {type:'page',"page":page};
    $.post("./card_sell.php",data,function(result){
        if(result.data['buyList'].length > 0){
            page++;
            var htmlStr = '';
            $.each(result.data['buyList'],function(key,value){
                var str = strFunc(value,result.data['userInfo']);
                if(str) htmlStr += str;
            })
            $("#buylist_content").append(htmlStr);
            mui("#pullrefresh").pullRefresh().endPullupToRefresh(false);
        }else{
            mui("#pullrefresh").pullRefresh().endPullupToRefresh(true);
        }
    },"json");

}
function strFunc(card,userInfo){
    var num = Number(card['num']-card['frozen']);
    if(num <= 0) return false;
    var price = Number(card['price']);
    var sum = num*price;
    var str = '';
    str += '<li class="mui-table-view-cell mui-media">';
    str += '<img class="mui-media-object mui-pull-left" src="';
    if(userInfo[card['uid']]['avatar']) str += userInfo[card['uid']]['avatar'];
    else str += '../static/images/jftc_03.png';
        str += '"><div class="mui-media-body">';
            str += '<p class="mui-ellipsis"><span class="order_num">数量:'+num+'</span><span class="order_price">单价:'+price.toFixed(2)+'</span></p>';
            str += '<p class="mui-ellipsis"><span class="order_money">￥'+sum.toFixed(2)+'</span></p>';
        str += '</div>';
        str += '<button type="button" onclick="tranFunc('+card['id']+','+num+')" style="float: right;position: absolute;right: 10px;top:0px;    font-size: 14px; color: #29Aee7;border:0">卖出</button>';
    str += '</li>';
    return str;
}
// ***************** 分页 end *****************

</script>

</body>

</html>
