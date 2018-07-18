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
        .lk-titles{
          border-bottom: 1px solid #f0f0f0;
          height: 40px;
          display: flex;
        }
        .lk-ti{
          width: 25%;
          line-height: 40px;
          text-align: center;
        }
        .action{
          color: red;
        }
        .stores{
          border: 1px solid red;
          margin: 0 auto;
          text-align: center;
          width: 95%;
        }
        .store{
          margin-top:10px;
          display: flex;
          line-height: 50px;
        }
        .img{
          border: 1px solid red;
          width: 20%;
        }
        .price{
           border: 1px solid red;
           width: 45%;
        }
        .num{
           border: 1px solid red;
           width: 40%;
        }
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">首页</h1>
</header>
<div class="lk-content">
<div class="lk-titles">
  <div class="lk-ti action">抵现卡</div>
  <div class="lk-ti">积分卡</div>
  <div class="lk-ti">投票卡</div>
  <div class="lk-ti">自选</div>
</div>
<div class="stores">
    <?php foreach ($storeInfo as $k => $v) { ?>
      <div class="store">
        <div class="img"><img src="<?php echo $value['img_oneself']?>" style="width: 100%;height: 100%;"></div>
        <div class="price"><?php echo $value['enterprise'] ?></div>
        <div class="num"><a href="./home.php?shoreUid=<?php echo $value['uid'] ?>" class="layui-btn">交易</a></div>
      </div>
    <?php } ?>
</div>

<!-- <div class="store">
<?php foreach ($storeInfo as $key => $value) { ?>
         <div class="">
                <span  class="beatBtn"><div style="height: 30px;width: 30px;"><img src="<?php echo $value['img_oneself']?>" style="width: 100%;height: 100%;"></div></span>
                <span class="beatBtn"><?php echo $value['enterprise'] ?></span>
                <a href="./home.php?shoreUid=<?php echo $value['uid'] ?>" class="beatBtn">购买</a>
         </div>
         <hr>
<?php } ?>
</div> -->
</div>


  	<?php include display('public_menu');?>
</body>
</html>
