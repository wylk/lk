<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>支付</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=1">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        body{
            min-height: 0px;
            background-color: #f2f2f2;

        }
        .content{
            background-color: #fff;
            margin: 15px 15px 0px;
            border-radius: 3px;
            border-color: #f0f0f0;
            color: #999;
        }

        .title{
            height: 120px;
            padding-top: 10px;
        }
        .title p{
            width: 50%;
            text-align: center;
            margin: 5px auto;
        }
        .title p:first-child{
            font-size: 18px;
            margin-bottom: 15px; 
            color: #333;
        }
        .sum span{
           font-size: 20px;
        }
        .paySelect{
            height: 145PX;
           padding-top: 20px;
        }
        .paySelect div{
            text-align: center;
            margin-top: 8px;
        }
        .layui-btn-normal{
            /* height: 30px;
            line-height: 30px; */
            background-color: #FFF;
            border: 1px solid #259B24;
            color: #999;
        }
        .layui-btn:hover{
            color: #999;
        }
        .btn-theme{
            border-color: #29AEE7;
        }
        .paySelect button{
            width: 82%;
            border-radius: 5px;
            margin-top: 10px; 
        }

      

        /* 支付弹框 */
        .platform{border: 1px solid #4ea9a0;width: 80%;border-radius: 5px;position: absolute;left: 10%;top: 200px;background-color: white;display: none;}
       .platform h3{text-align: center;margin:20px;}
       .platform input{width: 70%;}
       .layui-form-block{text-align: center;}
       .platform button{width: 40%;}
       .payBtnColor{background-color:white;}
    </style>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script> 
</head>
<body>

<div class="content">
  <div class="title">
        <p><?php echo (!empty($store_name))?$store_name:'呷哺呷哺';?>抵现卡</p>
        <p class="sum" style="margin-bottom: 8px;margin-top: 33px;color: #333;">实付：¥&nbsp;<span><?php echo number_format($orderinfo['prices'],2)?></span></p>
        <p style="font-size: 12px;">数量：<?php echo number_format($orderinfo['number'],2); ?>&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;  单价：<?php echo number_format($orderinfo['price'],2) ?></p>
  </div>
  <div class="paySelect">
    <input type="hidden" name="orderId" value="<?php echo $orderId ?>" />
        <div id="weixin_pay">
            <button class="layui-btn layui-btn-normal">微信支付</button>
        </div>
        <div id="platform_pay">
            <button class="layui-btn layui-btn-normal btn-theme">平台币支付</button>
        </div>
  </div>

</div>
<!-- 支付弹框 -->
 <div class="layui-form platform">
    <h3>平台支付</h3>
    <div class="layui-form-item">
      <label class="layui-form-label">密码：</label>
      <div class="layui-input-block">
        <input type="password" name="pwd" value="" placeholder="请输入密码" class="layui-input">
      </div>
      <!-- 密码：<input type="" name=""> -->
    </div>
    <div class="layui-form-item">
      <div class="layui-form-block">
        <button class="layui-btn layui-btn-primary">取消</button>
        <button class="layui-btn" id='submit' lay-filter="formDemo">确认</button>
      </div>
    </div>
  </div>
  	<?php //include display('public_menu');?>
</body>
</html>

<script type="text/javascript">
layui.use(['form', 'layer'],function() {
    layer = layui.layer;
    $(".layui-btn-primary").click(function(){
      $(".platform").hide();
       $("[name=pwd]").val('');
    })
    // 调取支付接口
    function payRequest(paydata){
        console.log(paydata);
        // paydata.payType = payType;
        $.post("./pay.php",paydata,function(payinfo){
          console.log(payinfo);
          if(payinfo.res){
            alert(payinfo.msg);
            return;
          }
          window.WeixinJSBridge.invoke("getBrandWCPayRequest",payinfo.data,function(res1){
            if(res1.err_msg=="get_brand_wcpay_request:ok"){
               setTimeout(function(){
                    window.location.href = './orderDetail.php?id='+paydata.orderId;
                },1000)
            }else{
              alert("支付失败");
            }
          })
        },'json');
        // $.ajaxSettings.async = true;

    }
    $("[id$=_pay]").bind('click',function(){
      // $(this).find('span').css('color','#fb113c');
      // $(this).siblings().find('span').css('color','#cac3c3');
      
      var paydata={};
      var idStr = $(this).attr('id');
      var payType = idStr.substring(0,idStr.indexOf("_"));
      paydata.payType = payType;
      paydata.orderId = $('[name=orderId]').val();   
    
      if(payType == 'platform'){
        // console.log('platform pay');
        // 判断是否存在平台支付密码
        // console.log(paydata.orderId);
        $.post('./pay.php',{'payType':'platform_pass','orderId':paydata.orderId},function(res){
          console.log(res);
          if(res.res == 2){
            window.location.href = './orderDetail.php?id='+paydata.orderId;
            return;
          }
          if(res.res == 1) {
            window.location.href = './pay_pw.php';
            return;
          }
          $(".platform").show();
        },'json');
        return;
      }
      // console.log(paydata);
      payRequest(paydata);
    });
    // 平台币支付
    $("#submit").click(function(){
      var payPwd = $("[name=pwd]").val();
      if(payPwd.length==0) {
        $("[name=pwd]").focus();
        return;
      }
      $(".platform").hide();
      $("[name=pwd]").val('');
      var paydata = {};
      paydata.payType = 'platform';
      paydata.payPwd = payPwd;
      paydata.orderId = $('[name=orderId]').val();
      console.log(paydata);
      layer.load();
      // 平台币支付请求
      $.post("./pay.php",paydata,function(payinfo){
          console.log(payinfo);
          layer.closeAll("loading");
          if(!payinfo.res){
            layer.msg(payinfo.msg,{icon:1,skin:"demo-class"});
            window.location.href = "./orderDetail.php?id="+paydata.orderId;
          }else{
            layer.msg(payinfo.msg,{icon: 5,skin:"demo-class"});
          }
        },'json');
    })

});
</script>
