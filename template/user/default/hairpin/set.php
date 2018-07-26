<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
    <script type="text/javascript">
      var delAuthUrl = "<?php dourl('delset');?>";
      var authUrl = "<?php dourl('set');?>";
    </script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
   <!--  <script type="text/javascript" src="<?php echo TPL_URL;?>/js/admin_auth.js?r=<?php echo time();?>"></script> -->
   <style type="text/css">
   	.input-line{
   		width: 85%;
   		margin: 10px auto;

   	}
   </style>
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
       
        <a>
          <cite>平台币设置</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-  form-pane">
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="标题" name="title" lay-verify="title">
          </div>
          <div class="layui-input-inline">
            <select name="type">
              <option value="txt">单行文本</option>
              <?php foreach($inputType as $k => $v){?>
                <option value="<?php echo $v['type']?>"><?php echo $v['title']?></option>
              <?php }?>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="reg">
              <option value="0">无验证</option>
              <?php foreach($regType as $kk => $vv){?>
                <option value="<?php echo $vv['type']?>"><?php echo $vv['title']?></option>
              <?php }?>
            </select>
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="字段name" name="name" lay-verify="name">
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="单选才输入,男,女/验证" name="remark">
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="add" ><i class="layui-icon"></i>增加</button>
        </form>

      </div>
		<div class="lk-content" style="border: 1px solid #e5e5e5;">
			<div class="input-line">
				<form class="layui-form" action="">
				    <div class="input-m"><?php echo $wap;?></div>
				  <div class="layui-form-item">
				    <div class="layui-input-block">
				      <button class="layui-btn" lay-submit lay-filter="edit">立即提交</button>
				      <button type="reset" class="layui-btn layui-btn-primary" >重置</button>
				    </div>
				  </div>
				</form>
			</div>
		</div>
    </div>
  </body>
</html>
<script type="text/javascript">
	layui.use(['form', 'layer'],function() {
    $ = layui.jquery;
    var form = layui.form,
    layer = layui.layer;
    //自定义验证规则
    form.verify({
        title: function(value) {
            if (value.length < 1) {
                return '标题不能为空';
            }
        },
        name:[/[a-zA-Z]/,'name值必须是字母'], 
    });

    //监听提交
    form.on('submit(add)', function(data) {
        console.log(data.field);
        $.post(authUrl, data.field, function(res) {
            console.log(res);
            if(res.error == 0){
            	layer.msg(res.msg,{icon:1,time:2000},function(){
                	window.location.replace(location.href);
              	});
            }else{
               layer.msg(res.msg,{icon:2,time:1000});
            }
        },'json');
        return false;
    });

});
</script>