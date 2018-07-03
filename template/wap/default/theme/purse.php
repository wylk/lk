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
    <div class="layui-main" style="height:20px;width:100%;"><a href="./my.php">返回</a></div>
	<div class="layui-main" style="height:20px;width:100%;"><i class="layui-icon layui-icon-rmb"></i>余额</div>
	<div class="layui-main layui-bg-green" style="height:120px;line-height:120px;">
		<font style="font-size:25px;"><?php echo $pointBalance?></font>
	</div>
	<div style="width:100%;height:65px;margin:10px;padding:auto 150px;">
		<a href="javascript:;" class="layui-btn">充值</a>
		<a href="javascript:;" class="layui-btn">提现</a>
	</div>
	<div class="layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">
                <span style="width: 50px;margin: 0 30px;" onclick="deposit()">提现账单</span>
                <span style="width: 50px;margin: 0 30px;" onclick="recharge()">充值账单</span>
            </h2>
        </div>
        <div id="deposit">
            <?php foreach($deposit as $key=>$value){?>
            <div class="layui-colla-item" style="background-color: #f2f2f2;">
                <h2 class="layui-colla-title">提现</h2>
                <i style='position: relative; top:-13px;left:30px;color: #c2c2c2; font-size:12px;'><?php echo date("Y-m-d H:i:s",$value['time']) ?></i>
                <i style='position: relative; top:-23px;right:30px;color: red; font-size:15px;float: right;'>-<?php echo $value['money'] ?></i>
            </div>
            <?php } ?> 
        </div>      
        <div id="recharge" style="display: none;">
            <?php foreach($recharge as $key=>$value){?>
            <div class="layui-colla-item" style="background-color: #f2f2f2;">
                <h2 class="layui-colla-title">提现</h2>
                <i style='position: relative; top:-13px;left:30px;color: #c2c2c2; font-size:12px;'><?php echo date("Y-m-d H:i:s",$value['time']) ?></i>
                <i style='position: relative; top:-23px;right:30px;color: red; font-size:15px;float: right;'>+<?php echo $value['money'] ?></i>
            </div>
            <?php } ?>  
        </div>      
    </div>
</body>
</html>
<script type="text/javascript">
	layui.use(['form', 'layer'],function(){
		form = layui.form;
        var element = layui.element;
        layer = layui.layer;
	})
function recharge(){
    $("#deposit").hide();
    $("#recharge").show();
}
function deposit(){
    $("#recharge").hide();
    $("#deposit").show();
}
</script>