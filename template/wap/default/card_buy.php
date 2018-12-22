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
        #buyTran{
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
        .buy-order{
            background-color: #fff;
            margin: 3px 6px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="title" style="background-color: #fff;">
            <a href="card_buy.php" id="action">买入</a>
            <a href="card_sell.php">卖出</a>
            <a href="card_order.php">订单</a>
            <a href="card_orderlist.php">订单记录</a>
        </div>
        <div class="input-line">
            <div class="input-link">
                   <div class="input-title"><span>买入价:</span><input type='text' name="buyPrice" value='<?php echo number_format(option('hairpan_set.price'),2) ?>' placeholder="<?php echo number_format(option('hairpan_set.price'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></div>
                    <div style="color: #333">余额：<?php echo number_format($platformInfo['num'],2); ?></div>
            </div>

            <div class="input-link">
                   <div class="input-title">
                    <span>买入数量:</span><input type='text' name="buyNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                   </div>
                   <div>LK</div>
           </div>

           <div class="input-link">
                   <div class="input-title">最低买入量:<input type='text' name="limitNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" /></div>
                   <div>LK</div>
           </div>

           <div class="input-link">
                   <div class="input-title">兑换资金:<span id="money">0.00</span></div>
                   <div>RMB</div>
           </div>
                <div class="btn-link">
                        <a href="javascript:;" class="mui-btn mui-btn-primary mui-btn-outlined"  id="buyTran" style="width: 70%">买入</a>

                </div>
            </div>
            <?php if($register){ ?>
            <div style="background-color: #fff;color: #999;">
                <div class="lk-container-flex register" style="border: 1px solid #f2f2f2;">
                    <div>委托数</div><div>单价</div><div>总价</div><div>操作</div>
                </div>

                <?php foreach ($register as $key => $value) { ?>
                <div class="lk-container-flex register" id="register_<?php echo $value['id'] ?>" style="border: 1px solid #f2f2f2;">
                    <div>
                        <span id="num_<?php echo $value['id'] ?>"><?php echo number_format($value['num'],2) ?></span>LK
                    </div>
                    <div><?php echo number_format($value['price'],2) ?></div>
                    <div><?php echo number_format($value['price']*$value['num'],2) ?></div>
                    <div>
                        <a href="javascript:;" id="revoke_<?php echo $value['id'] ?>"  class="layui-btn">撤销</a>
                    </div>
                </div>
                <?php } } ?>
            </div>


        <div class="lk-container-flex" style="background-color: #fff;margin-top: 5px;">
            <h3 style="font-size:15px; font-weight: 600; padding:8px 0 8px 20px">市场卖单</h3>
        </div>
        <?php foreach ($sellList as $key => $value) { ?>
        <?php if($value['num'] <= $value['frozen']) continue; ?>
        <div class="lk-container-flex buy-order" id="tran_<?php echo $value['id'] ?>">
            <div class="lk-container-flex lk-bazaar-sell">
                <div style="width: 45%;padding-left: 5px;">
                    <p style="margin-left: 22px;"><?php echo $userInfo[$value['uid']]['name']?></p>
                    <img src="<?php echo $userInfo[$value['uid']]['avatar'] ?>" style="height:60px;border-radius: 20%;"/>
                </div>
                <div style="width: 50%;">
                    <p><span id="num_<?php echo $value['id'] ?>" num="<?php echo $value['num']-$value['frozen'] ?>"><?php echo number_format($value['num']-$value['frozen'],2) ?></span> WLK</p>
                    <p>价格：<?php echo number_format($value['price'],2) ?></p>
                    <p>限额：<?php echo number_format($value['limit'],2) ?> - <?php echo number_format($value['num']-$value['frozen'],2) ?></p>
                </div>
            </div>
            <div class="lk-container-flex">
                <p class="item-buy"><a href="javascript:;" id="transaction_<?php echo $value['id'] ?>">买入</a></p>
            </div>
        </div>
        <?php } ?>
    </div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
var id = "<?php echo $platformInfo['id']; ?>";
$(function(){
    $("#buyTran").bind("click",function(){
        var buyPrice = $("[name=buyPrice]").val();
        var buyNum = $("[name=buyNum]").val();
        var limitNum = $("[name=limitNum]").val();
        var money = buyPrice*buyNum;

        var data = {"buyPrice":buyPrice,"buyNum":buyNum,'id':id,"limitNum":limitNum,"type":"register"};
        $.post("./card_buy.php",data,function(result){
            if(!result.res){
                mui.toast(result.msg);
                 window.location.reload(true);
            }else{
                mui.toast(result.msg);
            }
        },"json");
    });
    $("input[name^=buy]").bind("keyup",function(){
        var buyPrice = $("[name=buyPrice]").val();
        var buyNum = $("[name=buyNum]").val();
        var money = buyPrice*buyNum;
        $("#money").html(money);
    })

    $("[id^=transaction]").bind("click",function(){
        var idStr = $(this).attr("id");
        var tranId = idStr.substring(idStr.indexOf("_")+1);
        // console.log(idStr,idStr.indexOf("_"),id);
        var packageId = "<?php echo $platformInfo['id']; ?>";
        var num = $("#num_"+tranId).attr("num");
        var data = {"type":"transaction","tranId":tranId,"packageId":packageId,"num":num}
        console.log(data);
        $.post("./card_buy.php",data,function(result){
            // console.log(result);
            if(!result.res){
                mui.toast(result.msg);
                $("#tran_"+tranId).remove();
                window.location.href="./card_order.php";
            }else{
                 mui.toast(result.msg);
            }
        },"json");
    });
    $("[id^=revoke_]").bind("click",function(){
        var idStr = $(this).attr("id");
        var tranId = idStr.substring(idStr.indexOf("_")+1);
        var packageId = "<?php echo $platformInfo['id']; ?>";
        var data = {"tranId":tranId,"packageId":packageId,"type":"revoke"}
        $.post("./card_buy.php",data,function(result){
            console.log(result);
            if(!result.res){
                mui.toast(result.msg);
                $("#register_"+tranId).remove();
                // window.location.reload(true);
            }else{
                 mui.toast(result.msg);
            }
        },"json");

    })
})

</script>
</body>
</html>
