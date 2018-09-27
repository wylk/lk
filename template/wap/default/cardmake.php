<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>LUploader/css/LUploader.css?r=2321">
    <script src="<?php echo STATIC_URL;?>LUploader/js/LUploader.js?r=32443345"></script>
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
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">发卡</h1>
</header>
<div class="lk-content">
<form class="layui-form" action="">
    <input type="hidden" name="contract" value="<?php echo $contract; ?>">
    <div class="input-m"><?php echo $html;?></div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="add">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary" >重置</button>
    </div>
  </div>
</form>
</div>
   
  	<?php include display('public_menu');?>
</body>
</html>

 <script>
    [].slice.call(document.querySelectorAll('input[data-LUploader]')).forEach(function(el) {
        new LUploader(el, {
            url: './upload.php',//post请求地址
            multiple: false,//是否一次上传多个文件 默认false
            maxsize: 102400,//忽略压缩操作的文件体积上限 默认100kb
            accept: 'image/*',//可上传的图片类型
            quality: 0.5,//压缩比 默认0.1  范围0.1-1.0 越小压缩率越大
            //showsize:true//是否显示原始文件大小 默认false
        });
    });
    </script>
