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
	* { padding: 0; margin: 0; }
body { font: 12px "微软雅黑", Arial; background: #efeff4; min-width: 320px; max-width: 640px; color: #000; }
a { text-decoration: none; color: #666666; }
a, img { border: none; }
img { vertical-align: middle; }
ul, li { list-style: none; }
em, i { font-style: normal; }
.clear { clear: both }
.clear_wl:after { content: "."; height: 0; visibility: hidden; display: block; clear: both; }
.fl { float: left }
.fr { float: right }
.all_w { width: 91.3%; margin: 0 auto; }
/*基础字体属性*/
.f10 { font-size: 10px }
.f11 { font-size: 11px }
.f12 { font-size: 12px }
.f14 { font-size: 14px }
.f13 { font-size: 13px }
.f16 { font-size: 16px }
.f18 { font-size: 18px }
.f20 { font-size: 20px }
.f22 { font-size: 22px }
.f24 { font-size: 24px }
.f26 { font-size: 26px }
.f28 { font-size: 28px }
.f32 { font-size: 32px }
.fb { font-weight: bold }
/********/
.header { background: #393a3e; color: #f5f7f6; height: auto; overflow: hidden; }
.gofh { float: left; height: 45px; display: -webkit-box; -webkit-box-orient: horizontal; -webkit-box-pack: center; -webkit-box-align: center; }
.gofh a { padding-right: 10px; border-right: 1px solid #2e2f33; }
.gofh a img { width: 40%; }
.wenx_xx { text-align: center; font-size: 16px; padding: 18px 0; }
.wenx_xx .zhifu_price { font-size: 45px; }
.ljzf_but { border-radius: 3px; height: 45px; line-height: 45px; background: #44bf16; display: block; text-align: center; font-size: 16px; margin-top: 14px; color: #fff; }
/*浮动层*/
.ftc_wzsf { display:none; width: 100%; height: 100%; position: fixed; z-index: 999; top: 0; left: 0; min-width: 320px; max-width: 640px;}
.ftc_wzsf .hbbj { width: 100%; height: 100%; position: absolute; z-index: 8; background: #000; opacity: 0.4; top: 0; left: 0; }
.ftc_wzsf .srzfmm_box { position: absolute; z-index: 10; background: #f8f8f8; width: 88%; left: 50%; margin-left: -44%; top: 20%; }
.qsrzfmm_bt { font-size: 16px; border-bottom: 1px solid #c9daca; overflow: hidden; }
.qsrzfmm_bt a { display: block; width: 10%; padding: 10px 0; text-align: center; }
.qsrzfmm_bt img.tx { width: 10%; padding: 10px 0; }
.qsrzfmm_bt span { padding: 15px 5px; }
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
</head>
<body>
	<!-- <script src="/demos/googlegg.js"></script>     -->
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">付款页面</h1>
</header>
<div class="lk-content">
    <div class="wenx_xx">
        <div class="mz">乐卡支付</div>
        <div class="zhifu_price">
        	<?php echo number_format($orderInfo['prices'],2); ?>
        </div>
    </div>
    <a href="javascript:void(0);" class="ljzf_but all_w">立即支付</a>
    <!--浮动层-->
    <div class="ftc_wzsf">
        <div class="srzfmm_box">
            <div class="qsrzfmm_bt clear_wl">
                <img src="<?php echo STATIC_URL;?>/images/xx_03.jpg" class="tx close fl">
                <img src="<?php echo STATIC_URL;?>/images/jftc_03.png" class="tx fl">
                <span class="fl">请输入支付密码</span></div>
            <div class="zfmmxx_shop">
                <div class="mz">测试商品</div>
                <div class="zhifu_price"> <?php echo number_format($orderInfo['prices'],2) ?>  </div></div>
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
</div>
<script type="text/javascript">
	layui.use(['layer'],function(){

	$(function(){
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
					var data = "";
						$(".mm_box li").each(function(){
						data += $(this).attr("data");
					});
				var arr = {'payPwd':data,"orderId":"<?php echo $id; ?>"}
				$.post("./success.php",arr,function(data){
					console.log(data);
						if(!data.res){
							layer.closeAll('loading');
							layer.msg(data.msg,{icon:1,skin:"demo-class"});
							window.location.href = "./orderDetail.php?id="+data.orderId;
						}else{
							layer.closeAll('loading');
							layer.msg(data.msg,{icon:5,skin:"demo-class"});
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
});
</script>
</body>
</html>
