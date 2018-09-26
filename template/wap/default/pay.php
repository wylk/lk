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
        .card-logo{
            border: 1px solid #f0f0f0;
            height: 200px;
        }
        .card-img{
            width: 90%;
            height: 90%;
            margin: 10px auto;
        }
        .card{
            height: 120px;
            border-bottom:1px solid #f0f0f0;
        }
         .layui-btn-primary{
            border: 1px solid #5fb878;
            color: #5fb878;
            height: 45px;
            width: 60%;
            line-height: 45px;
            font-size: 18px;
        }
        .card-info{
            display: flex;
            justify-content:space-around;
        }
        .card-info-row{
            width: 30%;
            height: 50px;
            line-height: 50px;
        }
        .card-data{
            height: 37px;
            width: 85%;
            margin: 0 auto;
            line-height: 37px;
        }
        .card-data-style{
            color: rgb(37, 155, 36);
            font-size: 12px;
        }
        .layui-input{
            display:inline;
            width: 26%;
            border: 1px solid #fff;
            border-bottom: 0.5px solid #000;
        }
        .paySelect{position: relative;bottom: 0px;left: 0px;font-size:15px;margin-left: 10px;/*display: none;*/}
        /*.paySelect p{margin: 5px;}*/
        .paySelect div{border: 1px solid green;height: 45px; display: block;margin-top:3px;}
        .paySelect img{height: 37px;margin: 5px;}
        .paySelect span{float: right;margin-right: 30px; line-height: 45px; font-size: 25px;}
        .platformPay{border:1px solid red;height: 80px;position: absolute;left: 10%;top: 200px;width: 80%;background-color: #f0f9f3; border-radius: 10px;display: flex;flex-direction:column;}
        .platformPay div{height: 20px;}
        .platformBtn{display: flex;flex-direction: row;}
        /*.platformPay label{font-size: 14px;line-height: 80px;}*/
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
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">支付页面</h1>
</header>
<div class="lk-content">
  <div class="paySelect">
    <!-- <p>支付方式：</p> -->
      <div id="platform_pay"><img src="<?php echo STATIC_URL;?>images/wx_logo.png" />微信支付<span class="layui-icon" style="color: #fb113c;">&#x1005;</span></div>
      <div id="weixin_pay"><img src="<?php echo STATIC_URL;?>images/wx_logo.png" />微信支付<span class="layui-icon" style="color:#cac3c3">&#x1005;</span></div>
      <!-- <a class="layui-btn layui-btn-primary" id="platform_pay">平台币支付</a> -->
      <!-- <a class="layui-btn layui-btn-primary" id="weixin_pay" >微信支付</a> -->
  </div>
 <div class='platformPay'>
   <div>平台支付密码：<input type="pwd" name="platform" value=""></div>
   <div class="platformBtn">
     <div>取消</div>
     <div>确定</div>
   </div>
 </div>
</div>
  	<?php include display('public_menu');?>
</body>
</html>

<script type="text/javascript">
layui.use(['form', 'layer'],function() {
    layer = layui.layer;

    var text = parseFloat($(".card-data-style i").eq(0).text());
    var num = parseFloat($(".card-data-style i").eq(1).text());
    var price = $(".card-data-style i").eq(2).text();

     $("input[name='number']").bind('input',function(){
         $("input[name='prices']").val(price*parseFloat($(this).val()));

      });
     $("input[name='prices']").bind('input',function(){
         $("input[name='number']").val(parseFloat($(this).val())/price);
      });

    $(".layui-btn-primary").click(function(){
      var number = $("input[name='number']").val();
      if(number < text || number>num){
        layer.msg('输入购买数不合法！',{icon: 5,time:1000},function(){
            $("input[name='prices']").val('');
            $("input[name='number']").val('');
            $("input[name='number']").focus();
        });
        return false;
      }
      $(".paySelect").show();
    });

    $(".layui-btn-primary_").click(function(){
    // $("[id$=_pay]").bind('click',function(){
      

      var paydata={};
      // 支付类型
      var idStr = $(this).attr('id');
      paydata.payType = idStr.substring(0,idStr.indexOf("_"));

      var data = {}
        data.number = $("input[name='number']").val();
        data.prices = $("input[name='prices']").val();
        data.card_id = "<?php echo $UserAud['card_id'] ?>";
        data.sell_id = "<?php echo $_GET['uid'] ?>";
        data.quantity = "<?php echo floatval($UserAud['num']) ?>";
        data.tranId = "<?php echo floatval($UserAud['id']) ?>";
        data.price = price;

        if(data.number < text || data.number>num){
          layer.msg('输入购买数不合法！',{icon: 5,time:1000},function(){
              $("input[name='prices']").val('');
              $("input[name='number']").val('');
              $("input[name='number']").focus();
          });
          return false;
        }
        layer.load();
        $.ajaxSettings.async = false;
        // 支付数据处理
        $.post('./receive.php',data,function(data){
            if(data.error==0) paydata.orderId = data.orderId;
            // if(data.error==0){
            //     //此处演示关闭
                layer.closeAll('loading');
            //     layer.msg(data.msg,{icon: 1,time:1000});
            //     // window.location.href = './success.php?id='+data.orderId;
            // }else{
            //     //此处演示关闭
            //     layer.closeAll('loading');
            //     layer.msg(data.msg,{icon: 5,time:1000});
            //     if(data.referer){
            //       // window.location.href = data.referer;
            //     }
            // }
        },'json');
        // 调取支付接口
        console.log(paydata);
        $.post("./pay.php",paydata,function(payinfo){
          console.log(payinfo);
        },'json');
        $.ajaxSettings.async = true;

    });
    $("[id$=_pay]").bind('click',function(){
      $(this).find('span').css('color','#fb113c');
      $(this).siblings().find('span').css('color','#cac3c3');
      var idStr = $(this).attr('id');
      var payType = idStr.substring(0,idStr.indexOf("_"));   
      if(payType == 'platform'){
        console.log('platform pay');
      }
    })
});
</script>
