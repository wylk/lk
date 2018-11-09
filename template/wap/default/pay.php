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

      
      

/*浮动层*/
.ftc_wzsf { display:none; width: 100%; height: 100%; position: fixed; z-index: 999; top: 0; left: 0; min-width: 320px; max-width: 640px;}
.ftc_wzsf .hbbj { width: 100%; height: 100%; position: absolute; z-index: 8; background: #000; opacity: 0.4; top: 0; left: 0; }
.ftc_wzsf .srzfmm_box { position: absolute; z-index: 10; background: #f8f8f8; width: 88%; left: 50%; margin-left: -44%; top: 20%; }
.qsrzfmm_bt { font-size: 16px; border-bottom: 1px solid #c9daca; overflow: hidden; }
.qsrzfmm_bt a { display: block; width: 10%; padding: 10px 0; text-align: center; }
.qsrzfmm_bt img.tx { width: 10%; padding: 10px 0; }
.qsrzfmm_bt span { padding: 15px 5px; color: #999}
.zfmmxx_shop { text-align: center; font-size: 12px; padding: 10px 0; overflow: hidden; }
.zfmmxx_shop .mz { font-size: 14px; float: left; width: 100%; }
.zfmmxx_shop .zhifu_price { font-size: 24px; float: left; width: 100%; }
.ml5 { margin-left: 5px; }
.mm_box { width: 89%; margin: 10px auto; height: 40px; overflow: hidden; border: 1px solid #bebebe; }
.mm_box li { border-right: 1px solid #efefef; height: 40px; float: left; width: 16.3%; background: #FFF; }
.mm_box li.mmdd{ background:#FFF url(<?php echo STATIC_URL;?>/images/dd_03.jpg) center no-repeat ; background-size:25%;}
.mm_box li:last-child { border-right: none; }
.xiaq_tb { padding: 5px 0; text-align: center; border-top: 1px solid #dadada; }
.numb_box { position: absolute; z-index: 10; background: #f5f5f5; width: 100%; bottom: 0px; }
.nub_ggg { border: 1px solid #dadada; overflow: hidden; border-bottom: none; }
.nub_ggg li { width: 33.3333%; border-bottom: 1px solid #dadada; float: left; text-align: center; font-size: 22px; }
.nub_ggg li a { display: block; color: #000; height: 50px; line-height: 50px; overflow: hidden; }
.nub_ggg li a:active  { background: #e0e0e0;}
.nub_ggg li a.zj_x { border-left: 1px solid #dadada; border-right: 1px solid #dadada; }
.nub_ggg li span { display: block; color: #e0e0e0; background: #e0e0e0; height: 50px; line-height: 50px; overflow: hidden; }
.nub_ggg li span.del img { width: 30%; }

.fh_but{ position:absolute; right:0px; top:12px; font-size:14px; color:#20d81f;}
.spxx_shop{ background:#FFF; margin-left:4.35%; border-top:1px solid #dfdfdd; padding:10px 0; }
.spxx_shop td{ color:#7b7b7b; font-size:14px; padding:10px 0;}
.mlr_pm{margin-right:4.35%;}
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
<div class="ftc_wzsf">
        <div class="srzfmm_box">
            <div class="qsrzfmm_bt clear_wl">
                <img src="<?php echo STATIC_URL;?>/images/xx_03.jpg" class="tx close fl">
               <!--  <img src="<?php echo STATIC_URL;?>/images/jftc_03.png" class="tx fl"> -->
                <span class="fl">请输入支付密码</span></div>
            <div class="zfmmxx_shop">
                <div class="mz"><?php echo (!empty($store_name))?$store_name:'呷哺呷哺';?>抵现卡</div>
                <div class="zhifu_price"> <?php echo number_format($orderinfo['prices'],2)?>  </div></div>
            <ul class="mm_box">
                <li></li><li></li><li></li><li></li><li></li><li></li>
            </ul>
        </div>
        <div class="numb_box">
            <div class="xiaq_tb layui-icon">&#xe61a;</div>
            <ul class="nub_ggg">
                <li><a href="javascript:void(0);" class="zf_num">1</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">2</a></li>
                <li><a href="javascript:void(0);" class="zf_num">3</a></li>
                <li><a href="javascript:void(0);" class="zf_num">4</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">5</a></li>
                <li><a href="javascript:void(0);" class="zf_num">6</a></li>
                <li><a href="javascript:void(0);" class="zf_num">7</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">8</a></li>
                <li><a href="javascript:void(0);" class="zf_num">9</a></li>
                <li><a href="javascript:void(0);" class="zf_empty">清空</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">0</a></li>
                <li><a href="javascript:void(0);" class="zf_del">删除</a></li>
            </ul>
        </div>
        <div class="hbbj"></div>
    </div>
 <!--  end -->
 
  	<?php //include display('public_menu');?>
</body>
</html>

<script type="text/javascript">
var layer;
layui.use(['form', 'layer'],function() {
    layer = layui.layer;
});   
    // 调取支付接口

$(function(){
    $("[id$=_pay]").bind('click',function(){
        var paydata={};
        var idStr = $(this).attr('id');
        var payType = idStr.substring(0,idStr.indexOf("_"));
        paydata.payType = payType;
        paydata.orderId = $('[name=orderId]').val();   
    
        if(payType == 'platform'){
            // 判断是否存在平台支付密码
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
                //$(".platform").show();
                $(".ftc_wzsf").show();
            },'json'); return;
        }
      // console.log(paydata);
      payRequest(paydata);
    });
  
        //出现浮动层
        $(".ljzf_but").click(function(){
            $(".ftc_wzsf").show();
        });
        //关闭浮动
        $(".close").click(function(){
            $(".ftc_wzsf").hide();
            $(".mm_box li").removeClass("mmdd");
            $(".mm_box li").attr("data","");
            i = 0;
        });
            //数字显示隐藏
        $(".xiaq_tb").click(function(){
            $(".numb_box").slideUp(500);
        });
        $(".mm_box").click(function(){
            $(".numb_box").slideDown(500);
        });
            //----
        var i = 0;
        $(".nub_ggg li .zf_num").click(function(){
                
            if(i<6){
                $(".mm_box li").eq(i).addClass("mmdd");
                $(".mm_box li").eq(i).attr("data",$(this).text());
                i++
                if (i==6) {
                    layer.load();
                        setTimeout(function(){
                        var payPwd = "";
                            $(".mm_box li").each(function(){
                            payPwd += $(this).attr("data");
                        });
                        var paydata = {};
                        paydata.payType = 'platform';
                        paydata.payPwd = payPwd;
                        paydata.orderId = $('[name=orderId]').val();
                        $.post("./pay.php",paydata,function(res){
                            console.log(res);
                            layer.closeAll("loading");
                            if(!res.res){
                                layer.msg(res.msg,{icon:1,skin:"demo-class"});
                                window.location.href = "./orderDetail.php?id="+paydata.orderId;
                            }else{
                                $(".mm_box li").removeClass("mmdd");
                                $(".mm_box li").attr("data","");
                                i = 0;
                                layer.msg(res.msg,{icon: 5,skin:"demo-class"});

                            }
                        },"json");
                    },100);
                };
            } 
        });
            
        $(".nub_ggg li .zf_del").click(function(){
            if(i>0){
                i--
                $(".mm_box li").eq(i).removeClass("mmdd");
                $(".mm_box li").eq(i).attr("data","");
            }
        });
    
        $(".nub_ggg li .zf_empty").click(function(){
            $(".mm_box li").removeClass("mmdd");
            $(".mm_box li").attr("data","");
            i = 0;
        });
         
    });
//微信支付
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
</script>
