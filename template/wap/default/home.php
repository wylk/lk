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
            margin-top: 10px;
            min-height: 100px;
        }
        .home-plugin-info-row{
            height: 65px;
            display: flex;
            justify-content: space-between;
        }
        .line-heights{
            width: 22%;
            line-height: 65px;
        }
        .row-card2{
           flex-grow: 1;
           display: flex;
           align-items:center;

        }

        .home-plugin-info-row-card-img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 2px auto;
        }
        .layui-btn-primary{
            border: 1px solid #5fb878;
            color: #5fb878;
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
          width: 95%;
          margin: 0px auto;
        }
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont"  style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">店铺</h1>
</header>
<div class="lk-content" style="background: #f0f0f0">
    <div class="layui-carousel" id="test1">
        <div carousel-item>
            <div><img src="https://free.modao.cc/uploads3/images/1907/19079076/raw_1523959218.jpeg"></div>
            <div><img src="https://free.modao.cc/uploads3/images/1907/19079076/raw_1523959218.jpeg"></div>
            <div><img src="https://free.modao.cc/uploads3/images/1907/19079076/raw_1523959218.jpeg"></div>
            <div><img src="https://free.modao.cc/uploads3/images/1907/19079076/raw_1523959218.jpeg"></div>
        </div>
    </div>
   <!--  <div class="home-plugin">
       <div class="home-plugin-menu">
           <div class="home-plugin-menu-img">
               <img src="http://img4.imgtn.bdimg.com/it/u=1036044083,1484439347&fm=200&gp=0.jpg" style="height: 100%;width: 100%">
           </div>
           <div class="home-plugin-menu-title">
               购买会员卡进店打折消费
           </div>
       </div>
       <div class="home-plugin-menu">
           <div class="home-plugin-menu-img">
               <img src="https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=734478096,1857645267&fm=27&gp=0.jpg" style="height: 100%;width: 100%">
           </div>
           <div class="home-plugin-menu-title">
               购买会员卡进店打折消费
           </div>
       </div>
       <div class="home-plugin-menu">
           <div class="home-plugin-menu-img">
               <img src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=681084461,1770331422&fm=200&gp=0.jpg" style="height: 100%;width: 100%">
           </div>
           <div class="home-plugin-menu-title">
               购买会员卡进店打折消费
           </div>
       </div>

   </div> -->
    <div class="home-plugin-info">
      <hr>
        <?php foreach ($UserAud as $key => $value) {
          foreach ($value as $k => $v) {
         ?>
         <div class="home-plugin-info-row">
             <div class="home-plugin-info-row-card line-heights">
                <div class="home-plugin-info-row-card-img">
                    <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg" style="height:100%;width:100%;border-radius: 50%;">
                </div>
             </div>
             <div class="home-plugin-info-row-card row-card2">
                <div style="height: 40px;line-height: 21px">
               <p><span style="font-weight: bold"><?= $v['name'] ?></span><span class="layui-badge layui-bg-orange">
                <?php if($v['type']==1){
                      echo '个人认证';
                    }elseif($v['type']==2){
                      echo '店铺认证';
                    }
                 ?>
               </span></p>
               <p>单价:<?=  floatval($v['price']) ?>CNY 限制<?= floatval($v['limit']) ?>-<?= floatval($v['num']) ?></p>
               </div>
             </div>
             <div class="home-plugin-info-row-card card-3 line-heights" >
                <a href="./receive.php" class="layui-btn layui-btn-primary">购买</a>
             </div>
         </div>
         <hr>
        <?php }} ?>
         <!-- <div class="home-plugin-info-row">
             <div class="home-plugin-info-row-card line-heights">
                <div class="home-plugin-info-row-card-img">
                    <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg" style="height:100%;width:100%;border-radius: 50%;">
                </div>
             </div>
             <div class="home-plugin-info-row-card row-card2">
              <div style="height: 40px;line-height: 21px">
                 <p><span style="font-weight: bold">老文</span><span class="layui-badge layui-bg-orange">V2 个人认证</span></p>
                 <p>单价:0.92CNY 限制1-100</p>
               </div>
             </div>
             <div class="home-plugin-info-row-card card-3 line-heights">
                 <a href="./receive.php" class="layui-btn layui-btn-primary">购买</a>
             </div>
         </div>
          <hr> -->
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
    ,height:180
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
});
</script>
