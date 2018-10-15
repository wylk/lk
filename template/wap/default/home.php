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
            background: #f1cd1f;
            border:1px solid #f1cd1f; 
            line-height: 30px;
            margin: auto auto;
            border-radius: 30px;
            text-align: center;
            font-size: 18px;
            font-weight:bold;
        }
        /* .offset_card{
            background: url("../static/images/039.png")no-repeat;
            background-size:100%100%;
        } */
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
    <div style="background: #fff;">
        <div style="width: 100%;margin: 0px auto;border-radius: 5%;">
            <div class="layui-carousel" id="test1" style="width: 80%">
                <div carousel-item>
                    <div><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1539002871374&di=b35bcf931ee46cac6811da452f692e15&imgtype=0&src=http%3A%2F%2Fhao.qudao.com%2Fupload%2Farticle%2F20150514%2F82458704441431567671.jpg" style="height: 100%;width: 100%"></div>
                    <div><img src="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=2498859936,599523319&fm=26&gp=0.jpg" style="height: 100%;width: 100%"></div>
                    <div><img src="https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=2297859767,3222081788&fm=26&gp=0.jpg" style="height: 100%;width: 100%"></div>
                </div>
            </div>
        </div>
        <div class="plugins">
            <div class="plugin offset_card">抵现卡</div>
            <div class="plugin">积分卡</div>
        </div>
    </div>
    <div class="home-plugin-info" >
    
    </div>
   
</div>
</div>
</div>
  	<?php include display('public_menu');?>
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
    mui('body').on('tap','a',function(){document.location.href=this.href;});
</script>
