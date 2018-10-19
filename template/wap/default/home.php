<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <title>交易</title>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <style type="text/css">
        #label-form{
            width:40px;
            overflow:visible;
        }
        #input-bloc{
            margin-left:90px;
        }
        .input-m{
            width: 85%;
            margin: 30px auto;
        }
        .home-plugin{
             background: #fff;
            margin-top: 10px;
            display:flex;
            justify-content: space-around;
        }
        .home-plugin-menu{
            border: 1px solid #259B24;
            border-radius: 5%;
            height: 100px;
            width: 25%;
            text-align: center;

        }

        .home-plugin-menu-img{
            height: 60%;
            margin: 0px auto 5px;
        }
        .home-plugin-menu-title{
            margin: 0px auto 5px;
            width: 90%;
        }

         .home-plugin-info{
            background: #fff;
            margin-top: 5px;
            min-height: 100px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .home-plugin-info-row{
            height: 80px;
            display: flex;
            justify-content: space-between;
        }
        .line-heights{
            width: 20%;
            line-height: 80px;
        }
        .row-card2{
           flex-grow: 1;
           display: flex;
           align-items:center;

        }

        .home-plugin-info-row-card-img{
            width: 50px;
            height: 50px;
            border-radius: 20%;
            margin: 2px auto;
        }
        .layui-btn-primary{
            border: 1px solid #f1cd1f;
            color: #f1cd1f;
            height: 30px;
            line-height: 30px;
            border-radius: 5px;
        }
        .card-3{
            text-align: center;
            line-height: 65px;
        }
        .layui-badge{
            margin-left: 5px;
        }
        .home-plugin-info-row, hr{
          width: 97%;
          margin: 0px auto;
        }
        .plugins{   
            height: 60px;
            display: flex;
            justify-content:space-around;
        }

        .plugin{
            width: 40%;
           /*  background: #f1cd1f; */
            border:1px solid #9a9393;
            color: #9a9393; 
            line-height: 30px;
            margin: auto auto;
            border-radius: 30px;
            text-align: center;
            font-size: 18px;
            font-weight:bold;
        }
        .offset_action{
           color: #f1cd1f;
           border:1px solid #f1cd1f; 
        }
        .layui-badge{
            background-color: #cc6600;
        } 

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
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
            transition: none 0.2s ease 0s;
            opacity: 1;
        }
        .receivea{
            height: 210px; 
            background-color: #fff;
            position:absolute;left;0;bottom:0;
        }
    </style>
    <script type="text/javascript">
        var type = "<?php echo $type;?>";
        var card_id = "<?php echo $card_id;?>";
        $(function(){
            lk.is_weixin() && function(){
                $('.lk-bar-nav').css('display','none');
                $('.lk-content').css({"padding":"0px"});
            }()
        })
    </script>
</head>
<body >
<div id="pullrefreshs" style="touch-action: none;">
<div>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont"  style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">交易</h1>
</header>
<div class="lk-content" style="background: #f0f0f0;margin-bottom:10px;" >
    <div style="background: #fff;border-radius: 0px 0px 10px 10px;">
        <div style="width: 100%;margin: 0px auto;border-radius: 5%;">
            <div class="layui-carousel" id="test1" style="width: 80%">
                <div carousel-item>
                    <div><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1539002871374&di=b35bcf931ee46cac6811da452f692e15&imgtype=0&src=http%3A%2F%2Fhao.qudao.com%2Fupload%2Farticle%2F20150514%2F82458704441431567671.jpg" style="height: 100%;width: 100%"></div>
                    <div><img src="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=2498859936,599523319&fm=26&gp=0.jpg" style="height: 100%;width: 100%"></div>
                    
                </div>
            </div>
        </div>
        <div class="plugins">
            <div class="plugin offset_action">抵现卡</div>
            <div class="plugin">积分卡</div>
        </div>
    </div>
    <div class="home-plugin-info" >
    
    </div>
   
</div>
</div>
</div>
<style type="text/css">
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
            line-height: 37px;
        }
        .card-data-style{
            color: rgb(37, 155, 36);
            font-size: 12px;
        }
        .layui-input{
            display:inline;
            width: 26%;
        }
</style>
  	<?php include display('public_menu');?>
    <div id="up-div">
        <div id="up-index"> 
            <div class="receivea">
                <form>
                   <div class="card card-num">
                       <div class="card-data" style="width:95%;display: flex;justify-content: space-between;">你想买多少<a href="img-xx"><div><img src="../static/images/xx_03.jpg"/></div></a></div>

                       <div class="card-data card-data-style">交易限制:<i id="limit"><?= floatval($UserAud['limit']) ?></i>-<i id="num"><?= floatval($UserAud['num']) ?></i> 单价:<i id="price"><?= floatval($UserAud['price']) ?></i></div>
                       <div class="card-data">购买量:

                        <input type="text" name="number" required  lay-verify="required" autocomplete="off" class="layui-input number">
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                   <div class="card" style="text-align: center;line-height: 120px;">
                        <p class="layui-btn" id="buy" style="width: 60%;background-color: #efc914;color: #000;">购买</p>
                   </div>
                  
                 </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
layui.use('carousel', function(){
    var carousel = layui.carousel;
    //建造实例
    carousel.render({
        elem: '#test1'
        ,width: '100%' //设置容器宽度
        ,height:100
        //,arrow: 'always' //始终显示箭头
        //,anim: 'updown' //切换动画方式
    });
});

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
        i = 1;//当前页码数
        setTimeout(function() {
            //mui('#pullrefreshs').pullRefresh().endPulldownToRefresh(); //refresh completed
            //mui('#pullrefreshs').pullRefresh().refresh(true); //激活上拉加载
            window.location.reload();
        }, 1500);
    }


    document.getElementById('pullrefreshs').addEventListener("swiperight",function() {
           document.location.href='./index.php';
  });
    mui('body').on('tap','a',function(){
        var url = this.href;
        if(url.indexOf("img-xx") != -1 ){
            $('#up-div').css('display','none');
        }else if(url.indexOf("click-buy") != -1 ){
            var id = this.getAttribute("data-id");
            var uid = this.getAttribute("data-uid");
            $('#up-div').css('display','block');
            $.get('receive.php',{id:id,uid:uid},function(re){
                if(re.error == 0){
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
                window.location.href = './pay.php?id='+data.orderId;
            }else{
                //此处演示关闭
                layer.closeAll('loading');
                layer.msg(data.msg,{icon: 5,time:1000});
                if(data.referer){
                  window.location.href = data.referer;
                }
            }
        },'json');
    });
});
</script>