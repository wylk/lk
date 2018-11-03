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
        .container{flex-direction:column;text-align:center;line-height:30px;background-color: white;margin-top:50px; }
        .paySelect{position: relative;bottom: 0px;left: 0px;font-size:15px;margin-left: 10px;/*display: none;*/margin-top: 40px;}
        /*.paySelect p{margin: 5px;}*/
        .paySelect div{height: 45px; display: block;margin-top:3px;text-align: center;}
        .paySelect img{height: 37px;margin: 5px;}
        .paySelect span{float: right;margin-right: 30px; line-height: 45px; font-size: 25px;}
        .paySelect button{width: 200px;border-radius: 4px;}
        /*.platformPay{border:1px solid red;height: 180px;position: absolute;left: 10%;top: 200px;width: 80%;background-color: #f0f9f3; border-radius: 10px;display: flex;flex-direction:column;}*/
        /*.platformPay div{width: 100%; text-align: center; background-color: white; border: 1px solid #daf3e2; border-radius: 10px; line-height: 40px; height: 40px;}*/
        /*.platformPwd{height:140px;flex-direction: column;display: flex;align-items: center}
        .platformPwd input{height: 20px; width: 167px;}
        .platformBtn div{width: 100%; text-align: center; background-color: #4ad053; border: 1px solid #daf3e2; border-radius: 10px; line-height: 40px; height: 40px;}
        .platformBtn{display: flex;flex-direction: row;}*/
        /*.platformPay label{font-size: 14px;line-height: 80px;}*/
        .platform{border: 1px solid #4ea9a0;width: 80%;border-radius: 5px;position: absolute;left: 10%;top: 200px;background-color: white;display: none;}
       .platform h3{text-align: center;margin:20px;}
       .platform input{width: 70%;}
       .layui-form-block{text-align: center;}
       .platform button{width: 40%;}
       .payBtnColor{background-color:white;}
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
<body style="background-color: white;">
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">支付页面</h1>
</header>
<div class="lk-content">
  <div class="container">
      <p>数量:<?php echo number_format($orderinfo['number'],2); ?>&nbsp;&nbsp;  * &nbsp;&nbsp;  单价:<?php echo number_format($orderinfo['price'],2) ?></p>
      <p class="sum">实付：¥<?php echo number_format($orderinfo['prices'],2)?></p>
  </div>
  <div class="paySelect">
    <input type="hidden" name="orderId" value="<?php echo $orderId ?>" />
    <!-- <p>支付方式：</p> -->
      <div id="platform_pay">
        <!-- <img src="<?php echo STATIC_URL;?>images/wx_logo.png" />平台币支付 -->
        <!-- <span class="layui-icon" style="color: #fb113c;">&#x1005;</span> -->
        <button class="layui-btn layui-btn-normal">平台币支付</button>
      </div>
      <div id="weixin_pay">
        <!-- <img src="<?php echo STATIC_URL;?>images/wx_logo.png" />微信支付 -->
        <!-- <span class="layui-icon" style="color:#cac3c3">&#x1005;</span> -->
        <button class="layui-btn layui-btn-normal">微信支付</button>
      </div>
  </div>
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
