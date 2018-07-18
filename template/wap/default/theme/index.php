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
           /*  border: 1px solid red; */
        }
        .beatBtn{width:120px;height: 30px;text-align: center;display: block;float: left;}
        .store{width:100%;}
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">首页</h1>
</header>
<div class="lk-content">
<form class="layui-form" action="">
    <div class="input-m"></div>
  <div class="layui-form-item">
    <div class="layui-input-block">
    </div>
  </div>
</form>
<div class="store">
<?php foreach ($storeInfo as $key => $value) { ?>
         <div class="">
                <span  class="beatBtn"><?php echo $value['name'] ?></span>
                <span class="beatBtn"><?php echo $value['enterprise'] ?></span>
                <a href="./home.php?shoreUid=<?php echo $value['uid'] ?>" class="beatBtn">购买</a>
         </div>
         <hr>
<?php } ?>
</div>
</div>


  	<?php include display('public_menu');?>
</body>
</html>
