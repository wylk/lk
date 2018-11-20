<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <title>交易</title>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <!--  <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css"> -->
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">

    <style type="text/css">
        html body{
            margin:0;
            padding: 0;
            height: 100%;
            width: 100%;
           /*  background-color: #fff; */
        }

        .shop_headlines{
            height: 120px;
            width: 98%;
            margin:0px auto 0px;
            border-radius: 5px;
            background-image: url('../template/wap/default/images/home_head.png');
            background-repeat:no-repeat;
            background-size:100% 100%;
            -moz-background-size:100% 100%;
           display: flex;
           align-items: flex-end;
           justify-content: center;
        }
        .shop_infos{
            line-height: 35px;
            width: 35%;

        }
        .shop_info{
            width: 100%;
            text-align: center;
        }
        .shop_headline{
            height: 75px;
            width: 30%;
            text-align: center;
            position: absolute;
            top: 72.5px;
            /* left: 0%; */
            right: -10px;
            /* margin-left: auto; */
            /* margin-right: auto; */
        }
        .shop_head_img{
            height: 65px;
            width: 65px;
            margin:0px auto;
        }
        .shop_headline img{
            height:100%;
            width: 100%;
            border-radius: 2px;
        }
        .flex-g>p:first-child{
            line-height: 20px;
            color: #999;
            font-size: 12px;
        }
        .plugin-title{
            border-bottom: 1px solid #e6e6e6;
            height: 50px;
            width: 100%;
            margin: 0px auto 5px;
            color: #999;
            background: #fff;
            display: flex;
            align-items: flex-end;

        }
        .plugin-title div{
            line-height: 30px;
        }
        .plugin-title span{
            color: rgb(160, 124, 124);
        }
        .pull{
            height: 100%;
            width: 100%;
        }
        .home-plugin-info{
            background: #fff;
            margin-top: 5px;
            min-height: 100px;
        }
        .home-plugin-info-row{
            height: 60px;
            display: flex;
            justify-content: space-between;
            color: #999;
        }

        .home-plugin-info-row-card{
            display: flex;
            align-items: center;
        }
        .line-heights{
            line-height: 55px;
        }

        .line-width1{
            width: 17%;
        }
        .line-width3{
            width: 20%;
        }
        .row-card2{
           flex-grow: 1;
        }
        .back{
            color: #333;
        }

        .font-max{
            font-size: 18px;
        }

        .font-16{
            font-size: 16px;
        }

        .home-plugin-info-row-card-img{
            width: 45px;
            height: 45px;
        }
        .layui-btn-primary{
            border: 1px solid #999;
            color: #999;
            height: 30px;
            line-height: 30px;
            border-radius: 5px;
        }
        .card-3{
            text-align: center;
        }
        .layui-badge{
            margin-left: 5px;
        }
        .home-plugin-info-row, hr{
          width: 95%;
          margin: 0px auto;
        }

        /* 弹框 */
        #up-div{
            position:absolute;
            top: 0;
            left: 0;
            margin: 0;
            z-index:1101;
            background-color:rgba(12, 12, 12, 0.58);
            display: none;
        }
        #up-index{
            height: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            background-color: rgba(0,0,0,0.3);
            z-index: 1000;
            transition: none 0.2s ease 0s;
            opacity: 1;
        }
        .receivea{
            height: 210px;
            width: 100%;
            background-color: #fff;
            position:absolute;left;0;bottom:0;
        }
        .card{
            height: 120px;
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

        }
        .tips{
            line-height: 37px;
            display: flex;
            justify-content: space-between;
        }
        .card-data-style{
            color: #999;
            font-size: 12px;
        }
        input[type=text]{
            width: 26%;
            border: 0;
            display:inline;
            height: 30px;
            width: 26%;
            border: 0;
            border-radius: 0px;
            border-bottom: 1px solid #999;
        }
        .card-buy{
            text-align: center;
            line-height: 70px;
        }
        #buy{
            width: 80%;
            background-color: #fff;
            border:1px solid #29aee7;
            border-radius: 5px;
            height: 35px;
            line-height: 35px;
        }
        .lk-content{
            margin-bottom: 0px;
            padding: 0px;
        }
        p{
            color: #999;
        }
        /* end */
    </style>

</head>
<body >
<div id="pullrefreshs" style="touch-action: none;" class="mui-content mui-scroll-wrapper">
<div>
<div class="lk-content">
    <div class="shop_headlines">
        
        <div class="shop_infos">
            <div class="shop_info font-max" ><?php echo $store['enterprise'];?></div>
        </div>
        <div class="shop_headline">
            <div class="shop_head_img"><img src="<?php echo (!empty($store['logo']))?$store['logo']:'../template/wap/default/images/default_home_user.png"';?>"/></div>
            <div class="flex-g">
                <p>信用:9分</p>
            </div>
        </div>
    </div>

    <div class="plugin-title">
        <div>

            &nbsp;&nbsp; <span>抵现卡</span> &nbsp;&nbsp;| &nbsp;&nbsp; 积分卡
        </div>
    </div>
  
            <div class="home-plugin-info" >

            </div>
           
        </div>
    </div>
</div>
  	<?php //include display('public_menu');?>
    <div id="up-div">
        <div id="up-index">
            <div class="receivea">
                <form>
                   <div class="card card-num">
                       <div class="card-data tips">你想买多少<a href="img-xx"><div><img src="../static/images/xx_03.jpg"/></div></a></div>

                        <div class="card-data card-data-style">
                        交易限制:<i id="limit"></i>-<i id="num"></i> 单价:<i id="price"></i>
                         </div>
                        <div class="card-data">购买量:
                            <input type="text" name="number" required  lay-verify="required" autocomplete="off" class="layui-input number">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="prices" required  lay-verify="required" autocomplete="off" class="layui-input prices" >
                        CNY
                    </div>
                    <input type="hidden" id="card_id" value="">
                    <input type="hidden" id="c_id" value="">
                    <input type="hidden" id="c_num" value="">
                    <input type="hidden" id="c_uid" value="">
                    <input type="hidden" id="c_price" value="">
                    <input type="hidden" id="c_limit" value="">
                   </div>
                   <div class="card card-buy">
                        <p class="layui-btn back" id="buy">购买</p>
                   </div>

                 </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
</html>
<script type="text/javascript">
    var layer = false;
    var type = "<?php echo $type;?>";
    var card_id = "<?php echo $card_id;?>";
    var referer = './login.php?referer=<?=urlencode($_SERVER['REQUEST_URI']); ?>';
    $(function(){
        lk.is_weixin() && function(){
            $('.lk-bar-nav').css('display','none');
            $('.lk-content').css({"padding":"0px"});
            $('.shop_headline').css({"top":"72.5px"});
        }()
    })
</script>
<script>
    var i = 1;
    mui.init({
        pullRefresh : {
            container:'#pullrefreshs',
            down: {
                callback: pulldownRefresh
            },
            up : {
                height:50,
                auto:true,
                contentrefresh : "正在加载...",
                contentnomore:'没有更多数据了',
                callback :pullupRefresh
            }
        }
    });

    function data(){
        $.post('home_ajax.php',{i:i,plugin:type,card_id:card_id},function(re){
            ++i;
            if(re.error == 0){
                $('.home-plugin-info').append(re.msg);
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
            }else{
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
            }
        },'json');
    }

    function pullupRefresh(){
        setTimeout(function() {
            data();
        },1000);
        mui.init();
    }

    function pulldownRefresh() {
       // i = 1;//当前页码数
        setTimeout(function() {
            mui('#pullrefreshs').pullRefresh().endPulldownToRefresh(); //refresh completed
            mui('#pullrefreshs').pullRefresh().refresh(true); //激活上拉加载
            //window.location.reload();
        }, 1500);
    }


    document.getElementById('pullrefreshs').addEventListener("swiperight",function() {
           document.location.href='./index.php';
  });
    mui('body').on('tap','a',function(){
        var url = this.href;
        if(url.indexOf("img-xx") != -1 ){
            $("input[name='number']").val('');
            $("input[name='prices']").val('');
            $('#up-div').css('display','none');
        }else if(url.indexOf("click-buy") != -1 ){
            var id = this.getAttribute("data-id");
            var uid = this.getAttribute("data-uid");
            var index_layer = layer.load(0, {shade: false});
            $.get('receive.php',{id:id,uid:uid},function(re){
                layer.close(index_layer);
                if(re.error == 0){
                    $('#up-div').css('display','block');
                    $('#limit').html(re.msg.limit);
                    $('#num').html(re.msg.num);
                    $('#price').html(re.msg.price);

                    $('#card_id').val(re.msg.card_id);
                    $('#c_id').val(re.msg.id);
                    $('#c_num').val(re.msg.num);
                    $('#c_uid').val(uid);
                    $('#c_price').val(re.msg.price);
                    $('#c_limit').val(re.msg.limit);

                }else{
                    layer.msg(re.msg);
                    if(re.error == 9){
                        setTimeout(function(){
                            window.location.href = referer;
                        },2000);
                    }

                }

            },'json');
        }else{
            document.location.href=this.href;
        }
    });

</script>
<script type="text/javascript">
layui.use(['form', 'layer'],function() {
    layer = layui.layer;



     $("input[name='number']").bind('input',function(){
        var price = $("#c_price").val();
         $("input[name='prices']").val(price*parseFloat($(this).val()));

      });
     $("input[name='prices']").bind('input',function(){
        var price = $("#c_price").val();
        $("input[name='number']").val(parseFloat($(this).val())/price);
      });
    $("#buy").click(function(){
        var text = parseFloat($("#c_limit").val());
        var num = parseFloat($("#c_num").val());
        var price = parseFloat($("#c_price").val());
        var data = {}
        data.number = $("input[name='number']").val();
        data.prices = $("input[name='prices']").val();
        data.card_id = $('#card_id').val();
        data.tranId = $('#c_id').val();
        data.quantity = $('#c_num').val();
        data.sell_id  = $('#c_uid').val();
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
        //console.log(data);
        //return;
        // 支付数据处理
        $.post('./receive.php',data,function(data){
            // if(data.error==0) paydata.orderId = data.orderId;
            if(data.error==0){
            //     //此处演示关闭
                layer.closeAll('loading');
                layer.msg(data.msg,{icon: 1,time:1000});
                setTimeout(function(){
                    window.location.href = './pay.php?id='+data.orderId;
                },2000);
            }else{
                //此处演示关闭
                layer.closeAll('loading');
                layer.msg(data.msg,{icon: 5,time:1000});
                if(data.error == 9){
                    setTimeout(function(){
                        window.location.href = referer;
                    },2000);
                }
            }
        },'json');
    });
});
</script>
