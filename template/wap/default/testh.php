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
       .platform{border:1px solid red;width: 90%; margin: auto;border-radius: 5px;}
       .platform h3{text-align: center;margin:20px;}
       .platform input{width: 70%;}
       .layui-form-block{text-align: center;}
       .platform button{width: 40%;}
    </style>
</head>
<body>

<div class="lk-content">
  <div class="layui-form platform">
    <h3>平台支付</h3>
    <div class="layui-form-item">
      <label class="layui-form-label">密码：</label>
      <div class="layui-input-block">
        <input type="password" name="pwd" value="" class="layui-input">
      </div>
      <!-- 密码：<input type="" name=""> -->
    </div>
    <div class="layui-form-item">
      <div class="layui-form-block">
        <button class="layui-btn layui-btn-primary">取消</button>
        <button class="layui-btn" lay-submit lay-filter="formDemo">确认</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script type="text/javascript">
layui.use(['form', 'layer'],function() {
    layer = layui.layer;


});
</script>
