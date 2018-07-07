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
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
  <style type="text/css">
  	.form{width: 80%;margin-top:80px;}
  </style>
  
</head>
<body>
<div class="form">
	<div style="text-align: center;margin:10px;"><?php echo $cardId; ?></div>
	<form class="layui-form">
		
		<div class='layui-form-item'>
			<label class="layui-form-label">交易数量：</label>
			<div class="layui-input-block">
				<input class="layui-input" type="text" name="num" value="" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">单价：</label>
			<div class="layui-input-block">
				<input class="layui-input" type="text" name="price" value="" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">最低额度：</label>
			<div class="layui-input-block">
				<input class="layui-input" type="text" name="limit" value="" />
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" name="type" value="transaction" />
				<input type="hidden" name="cardId" value="<?php echo $cardId; ?>" />
				<button class="layui-btn" lay-submit name="submit" lay-filter="formDemo" >提交</button>
			</div>
		</div>
	</form>
</div>
 
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
	layui.use(['form','layer'],function(){
		var form = layui.form;
		var layer = layui.layer;
		form.on("submit(formDemo)",function(data){
			layer.load();
			console.log(data);
			$.post("./transaction.php",data.field,function(res){
				console.log(res);
				if(res.res){
					layer.msg(res.msg,{icon:1,skin:"demo-class"},function(){
						layer.colseAll("loading");
						// window.location.href = ""
					})
				}else{
					layer.msg(res.msg,{icon:5,skin:'demo-class'});
				}
			},"json");
			return false;
		});
	})

</script>