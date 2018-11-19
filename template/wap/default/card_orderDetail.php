<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>订单详情</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script> -->
    <style type="text/css">
        html body {
            background-color: #fff;
        }
        .container{flex-direction:column;text-align:center;height:130px;background-color: white;}
        .container h3,.container h2{margin:10px;padding:10px;}
        .detail{flex-direction:column;background-color: white;margin-top:30px;width: 95%;margin:0 auto;}
        .menuStyle{display:flex;justify-content:space-between;padding:8px;}
        .CodeStyle{display:flex;padding:8px;}
        .detail .spanLeft{font-size: 15px;margin:2px 20px;}
        .detail .spanRight{font-size: 15px;margin:2px 20px;}
        .spanBtn{height:100px;align-items:center;}
        .spanBtn .spanRight{display:inline-flex;flex-direction: column;height:100%;justify-content:center;align-items:center;}
        .spanBtn .spanRight .spanitem{font-size: 15px;margin:2px 20px;}
        hr{margin: 0px 19px;}
       .codeAddress{padding: 5px 5px; line-height: 250px; color: #666;border: 1px solid #0f7f7a; width: 250px; margin:10px auto; border-radius: 10px;display:flex;justify-content:center;}
        .codeAddress img{ height: 100%; width: 100%;}

        .detail1{flex-direction:column;background-color: white;width: 95%;margin:0 auto;border-radius: 5px;border:1px solid #c5c3c3;}
        .menuStyle1{display:flex;justify-content:space-between;padding:8px;}
        .detail1 .spanLeft1{font-size: 15px;margin:2px 20px;}
        .detail1 .spanRight1{font-size: 15px;margin:2px 20px;}
        .color_gray{color:#999;}
        .color_black{color:#333;}
        .color_red{color:red;}
        .word{width: 95%;margin: 0 auto;padding:20px 10px 10px 25px;}
        .img{width: 50px;}
    </style>
</head>

<body style="background: #f2f2f2;">
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">订单详情</h1>
    </header>
    <div class="lk-content">
      <div class="detail1">
        <div class="menuStyle1">
          <span class="spanLeft1 color_black">订单号：<span class="color_gray"><?php echo $orderInfo['onumber'] ?></span></span>
          <span class="spanRight1 color_black">
            <?php if($orderInfo['sell_id'] == $userId){ ?>
              <?php if($orderInfo['status'] == '0') echo "未收款" ?>
              <?php if($orderInfo['status'] == '1') echo "交易成功" ?>
              <?php if($orderInfo['status'] == '2') echo "交易取消" ?>
              <?php if($orderInfo['status'] == '3') echo "已收款" ?>
              <?php if($orderInfo['status'] == '4') echo "订单超时" ?>
            <?php }else{ ?>
              <?php if($orderInfo['status'] == '0') echo "未付款" ?>
              <?php if($orderInfo['status'] == '1') echo "交易成功" ?>
              <?php if($orderInfo['status'] == '2') echo "交易取消" ?>
              <?php if($orderInfo['status'] == '3') echo "已付款" ?>
              <?php if($orderInfo['status'] == '4') echo "订单超时" ?>
            <?php } ?>
          </span>
        </div>
        <hr>
        <div class="menuStyle1">
          <span class="spanLeft1 color_gray">创建时间：</span>
          <span class="spanRight1 color_gray"><?php echo date("Y-m-d H:i:s",$orderInfo['create_time']) ?></span>
        </div>
        <hr>
        <div class="menuStyle1">
          <span class="spanLeft1 color_gray">数量：<?php echo number_format($orderInfo['number'],2); ?> * 单价<?php echo number_format($orderInfo['price'],2); ?></span>
          <span class="spanRight1 color_red">总额：<?php echo number_format($orderInfo['price']*$orderInfo['number'],2)?></span>
        </div>
      </div>
      <div >
        <p class="word">请选择以下方式给卖家打款</p>
        <?php foreach($payInfo as $value){ ?>
        <div class="detail1" style="height: 80px;padding: 3px;margin-bottom: 2px;">
          <div class="spanLeft1 color_gray" style="width:50%;float:left;">
            <span style="display: block;">姓名：李三</span>
            <span style="display: block;">支付宝账号：<?php echo $value['account'] ?></span>
            <span style="display: block;">不要备注如何信息</span>
          </div>
          <div class="spanRight1" style="width: 25%;float:right;text-align: center;">
            <span style="width: 50px;height: 50px;margin:0 auto;display: block; background-size: 100%; background-image:url(<?php echo $payType[$value['type']]['logo']; ?>);"></span>
            <span class="color_black">查看二维码</span>
          </div>
        </div>
        <?php } ?>
      </div>
      <br/>
      <div class="detail1">
        <div style="display: block;padding:10px;" class="color_gray">
          <span style="border:1px solid #c5c3c3;width: 80px;padding:5px;margin:5px;">申述</span>
          <span style="border:1px solid #c5c3c3;width: 80px;padding:5px;margin:5px;">取消订单</span>
        </div>
        <span style="padding: 10px;height: 34px;width: 90%; display: block;color:red">未打款并点击付款付款完成，经核实，将会暂停账号功能</span>
      </div>
      <br/>
      <?php if($orderInfo['buy_id'] == $userId && in_array($orderInfo['status'], ['0'])){ ?>
        <span class="color_black" style="width: 85%;text-align:center;padding:8px;margin:3px auto;border-radius:5px;border:1px solid #01AAED;display: block;">我已付款</span>
      <?php }else if($orderInfo['sell_id'] == $userId && in_array($orderInfo['status'], ['3'])){ ?>
        <span class="color_black" style="width: 85%;text-align:center;padding:8px;margin:3px auto;border-radius:5px;border:1px solid #01AAED;display: block;">我已转账</span>
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
        layer.load();
        var orderId = "<?php echo $orderInfo['id'] ?>";
        var data = {"orderId" : orderId, "type" : "confirmTran"};
        $.post("./card_orderDetail.php",data,function(result){
          console.log(result);
          layer.closeAll("loading");
          if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            window.location.reload(true);
          }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
          }
        },"json");
      })
    })
    $("#payMoeny").bind("click",function(){
      layer.confirm("确定已经付款了吗？",function(){
        layer.load()
        var orderId = "<?php echo $orderInfo['id'] ?>";
        var data = {'orderId':orderId,"type":"payMoeny"}
        $.post("./card_orderDetail.php",data,function(result){
          console.log(result);
          layer.closeAll("loading");
          if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            window.location.reload(true);
          }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
          }
        },"json");
      });

    })
    $("[id^=revokeOrder_]").bind("click",function(){
      layer.load();
      var idStr = $(this).attr("id");
      var orderId = idStr.substring(idStr.indexOf("_")+1);
      var data = {"orderId":orderId,"type":"revokeOrder"};
      $.post("./card_orderDetail.php",data,function(result){
        console.log(result);
        if(!result.res){
          layer.msg(result.msg,{icon:1,skin:"demo-class"});
          window.location.reload(true);
        }else{
          layer.msg(result.msg,{icon:5,skin:"demo-class"});
        }
      },"json");

    })
  })
</script>

</html>
