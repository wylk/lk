<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .lk-nav-link a{width:30%;text-align: center; line-height: 45px; font-size:.5rem;}
        .lk-deal-link a{text-align: center; line-height: 45px; font-size:.5rem;padding: 0 20px;}
        .lk-deal-link a input[type='text']{
            display: inline;
            border:none;
        }
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell p{width:38%; padding-left:3%; line-height: 25px}
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">买入</h1>
    </header>
    <div class="lk-content">
        <div class="lk-container-flex lk-nav-link">
                <a href="card_buy.php" class="layui-bg-orange">买入</a>
                <a href="card_sell.php">卖出</a>
                <a href="card_order.php">订单</a>
                <a href="card_orderlist.php">订单记录</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="javascript:;">买入价：<input type='text' name="buyPrice" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></a>
                <a href="javascript:;">余额：<?php echo number_format($$card['num'],2); ?></a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="javascript:;">买入数量：<input type='text' name="buyNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                <a href="javascript:;">WLK</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="javascript:;">最低买入量：<input type='text' name="limitNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                <a href="javascript:;">WLK</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                <a href="javascript:;">兑换资金：<span id="money">0.00</span></a>
                <a href="javascript:;">CNY</a>
        </div>
        <hr>
        <div class="lk-container-flex lk-justify-content-c">
            <a href="javascript:;" id="buyTran" class="layui-btn layui-btn-warm" style="width: 90%">买入</a>
        </div>
        <div class="lk-container-flex">
            <h1 style="font-size:16px; font-weight: 600; padding:20px 0 10px 20px">市场卖单</h1>
        </div>
        <hr>
        <hr>
        <?php foreach ($sellList as $key => $value) { ?>
        <?php if($value['num'] <= $value['frozen']) continue; ?>
        <div class="lk-container-flex">
            <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
                <p class="item-flex">王**</p>
                <p class="item-flex"><?php echo number_format($value['num'],2) ?>WLK</p>
                <p class="item-flex">在线</p>
                <p class="item-flex">价格：<?php echo number_format($value['price'],2) ?></p>
                <p class="item-flex">logo</p>
                <p class="item-flex">限额：<?php echo number_format($value['limit'],2) ?>-<?php echo number_format($value['num'],2) ?></p>
            </div>
            <div class="lk-container-flex">
                <p class="item-buy"><a href="javascript:;" id="transaction_<?php echo $value['id'] ?>">买入</a></p>
            </div>
        </div>
        <hr>
        <?php } ?>
    </div>
    <?php include display('public_menu');?>
<script type="text/javascript">
    layui.use(['layer'],function(){
        $("#buyTran").bind("click",function(){
            layer.load();
            var buyPrice = $("[name=buyPrice]").val();
            var buyNum = $("[name=buyNum]").val();
            var limitNum = $("[name=limitNum]").val();
            var money = buyPrice*buyNum;
            var id = "<?php echo $platformInfo['id']; ?>";
            var data = {"buyPrice":buyPrice,"buyNum":buyNum,'id':id,"limitNum":limitNum,"type":"register"};
            $.post("./card_buy.php",data,function(result){
                console.log(result);
                layer.closeAll("loading");
                if(!result.res){
                    layer.msg(result.msg,{icon:1,skin:"demo-class"});
                }else{
                    layer.msg(result.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
        });
        $("input[name^=buy]").bind("keyup",function(){
            var buyPrice = $("[name=buyPrice]").val();
            var buyNum = $("[name=buyNum]").val();
            var money = buyPrice*buyNum;
            $("#money").html(money);
        })
        // $("[name=limitNum]").bind("keyup",function(){
        //     var buyNum = $("[name=buyNum").val();
        //     var limitNum = $("[name=limitNum]").val();
        //     if(limitNum > buyNum){
        //         layer.msg('最低购买数量不得大于购买数量',{icon:5,skin:"demo-class"});
        //     }
        // });
        $("[id^=transaction]").bind("click",function(){
            var idStr = $(this).attr("id");
            var tranId = idStr.substring(idStr.indexOf("_")+1);
            // console.log(idStr,idStr.indexOf("_"),id);
            var packageId = "<?php echo $platformInfo['id']; ?>";
            var data = {"type":"transaction","tranId":tranId,"packageId":packageId}
            console.log(data);
            $.post("./card_buy.php",data,function(result){
                console.log(result);
                if(!result.res){
                    layer.msg(result.msg,{icon:1,skin:"demo-class"});
                }else{
                    layer.msg(result.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
        });
        
    })
</script>
</body>
</html>