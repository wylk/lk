<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-collapse">
        <div class="layui-colla-item" >
            <center class="layui-colla-title" >王先生</center>
            <center class="layui-colla-title"><?php echo $phone; ?></center>
        </div>
        <div style="height:20px"></div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./my.php?pagetype=purse">钱包</a></h2>
        </div>
        <div style="height:15px"></div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./my.php?pagetype=postcard">身份证</a></h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./cardType.php">发卡</a></h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./my.php?pagetype=cardList">卡/券/库</a></h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">API接口</h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">店员管理</h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./my.php?pagetype=bill">账单明细</a></h2>
        </div>
        <div style="height:5px"></div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title"><a href="./my.php?pagetype=setup">设置</a></h2>
        </div>
</div>
</div>

  	<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
	layui.use(['form', 'layer'],function(){
		form = layui.form;
        var element = layui.element;
        layer = layui.layer;
	})
</script>
