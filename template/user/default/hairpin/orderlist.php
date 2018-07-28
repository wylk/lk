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
    <style type="text/css">
        .container{flex-direction:column;text-align:center;height:130px;background-color: white;}
        .container h3,.container h2{margin:10px;padding:10px;}
        .detail{flex-direction:column;background-color: white;margin-top:30px;width: 95%;margin:0 auto;}
        .menuStyle{display:flex;justify-content:space-between;padding:8px;}
        .CodeStyle{display:flex;padding:8px;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        .codeAddress{padding: 5px 5px; line-height: 150px; height: 150px; color: #666;border: 1px solid #0f7f7a; width: 150px; margin:10px auto; border-radius: 10px;display:flex;justify-content:center;}
        .codeAddress img{
            height: 100%;
            width: 100%;
        }
        hr{
          margin: 0px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="detail">
          <div class='menuStyle'><span class="spanLeft">订单号：<?php echo $orderInfo['onumber'] ?></span><span class="spanRight">
             <?php if($orderInfo['sell_id'] == $userId){ ?>
            <p style="color:gray;"><?php echo $orderInfo['status'] == '1' ? "交易成功" : ($orderInfo['status'] == '2' ? "订单超时" : "未收款"); ?></p>
           <?php } ?>
           <?php if($orderInfo['buy_id'] == $userId){ ?>
           <p style="color:gray;"><?php echo $orderInfo['status'] == '1' ? "交易成功" : ($orderInfo['status'] == '2' ? "订单超时" : "未付款"); ?></p>
           <?php } ?>
          </span></div>
          <hr>
            <div class='menuStyle'><span class="spanLeft">数量：<?php echo number_format($orderInfo['number'],2); ?></span><span class="spanRight">单价：￥<?php echo number_format($orderInfo['price'],2); ?></span></div>
            <hr>
           <div class='menuStyle'><span class="spanLeft">总额：</span><span class="spanRight" style="color: red;">￥<?php echo number_format($orderInfo['price']*$orderInfo['number'],2)?></span></div>
            <hr>
           <div class='menuStyle'><span class="spanLeft">创建时间：</span><span class="spanRight"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span></div>
            <hr>
           
          <?php if($orderInfo['sell_id'] == $userId){ ?>
          <div class='menuStyle'><span class="spanLeft">交易状态：</span>
            <?php echo $orderInfo['status'] == '1' ? "<span class='spanRight' >已收款</span>" : ($orderInfo['status'] == '2' ? "<span class='spanRight'>订单超时</span>" : "<button class='spanRight' id='confirmTran'>确认收款</button>"); ?>
          </div>
          <?php } ?>
          <?php if($orderInfo['buy_id'] == $userId){ ?>
          <div class='menuStyle'><span class="spanLeft">收款人：老王</span><span class="spanRight">支付宝</span></div>
          <hr>
            <div class='codeStyle'><span class="spanLeft">二维码：</span>
            <div class="codeAddress"><img src="<?php echo STATIC_URL;?>/images/default_qr.png" /></div>
          </div>
          <?php } ?>

        </div>
    </div>
</body>
<script type="text/javascript">
  layui.use(['element','layer'],function(){
    var element = layui.element;
    var layer = layui.layer;
    $("#confirmTran").bind("click",function(){
      layer.confirm("确定收款吗？确定后平台币会转账到对方账户",function(){
        // layer.load();
        var orderId = "<?php echo $orderInfo['id'] ?>";
        var data = {"orderId" : orderId, "type" : "confirmTran"};
        $.post("?c=hairpin&a=orderList",data,function(result){
          console.log(result);
          layer.closeAll("loading");
          if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            // window.location.href = "./card_orderlist.php";
          }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
            // window.location.href = "./card_order.php";
          }
        },"json");
      })
    })
  })
</script>

</html>
