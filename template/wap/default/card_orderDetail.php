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
        .detail{flex-direction:column;background-color: white;margin-top:30px;}
        .menuStyle{display:flex;justify-content:space-between;padding:8px;}
        .CodeStyle{display:flex;padding:8px;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        .line{background-color: #e4e0e0;height:2px;margin:0 auto; width:90%;}
        .codeAddress{padding: 10px 15px; line-height: 150px; height: 150px; color: #666;border: 1px solid #0f7f7a; margin:20px 60px; border-radius: 10px;display:flex;justify-content:center;}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">订单详情</h1>
    </header>
    <div class="lk-content">
        <div class="container">
           <h3>卡：<?php echo $orderInfo['card_id'] ?></h3>
           <h1>￥<?php echo number_format($orderInfo['price']*$orderInfo['number'],2)?></h1>
           <?php if($orderInfo['sell_id'] == $userId){ ?>
            <p style="color:gray;"><?php echo $orderInfo['status'] == '1' ? "交易成功" : ($orderInfo['status'] == '2' ? "订单超时" : "未收款"); ?></p>
           <?php } ?>
           <?php if($orderInfo['buy_id'] == $userId){ ?>
           <p style="color:gray;"><?php echo $orderInfo['status'] == '1' ? "交易成功" : ($orderInfo['status'] == '2' ? "订单超时" : "未付款"); ?></p>
           <?php } ?>
        </div>
        <div class="detail">
            <div class='menuStyle'><span class="spanLeft">数量：</span><span class="spanRight"><?php echo number_format($orderInfo['number'],2); ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">单价：</span><span class="spanRight">￥<?php echo number_format($orderInfo['price'],2); ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">创建时间：</span><span class="spanRight"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span></div>
           <p class="line"></p>
           <div class='menuStyle'><span class="spanLeft">订单号：</span><span class="spanRight"><?php echo $orderInfo['onumber'] ?></span></div>
          <p class="line"></p>
          <?php if($orderInfo['sell_id'] == $userId){ ?>
          <div class='menuStyle'><span class="spanLeft">交易状态：</span>
            <?php echo $orderInfo['status'] == '1' ? "<span class='spanRight' >已收款</span>" : ($orderInfo['status'] == '2' ? "<span class='spanRight'>订单超时</span>" : "<button class='spanRight' id='confirmTran'>确认收款</button>"); ?>
          </div>
          <?php } ?>
          <?php if($orderInfo['buy_id'] == $userId){ ?>
            <div class='codeStyle'><span class="spanLeft">付款码：</span>
            <div class="codeAddress"><img src="<?php echo STATIC_URL;?>/images/jftc_03.png" /></div>
          </div>
          <?php } ?>

        </div>
    </div>
    <?php include display('public_menu');?>
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
        $.post("./card_orderDetail.php",data,function(result){
          console.log(result);
          layer.closeAll("loading");
          if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            window.location.href = "./card_orderlist.php";
          }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
            window.location.href = "./card_order.php";
          }
        },"json");
      })
    })
  })
</script>

</html>
