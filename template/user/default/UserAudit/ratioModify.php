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
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      /*.layui-input-inline img{width: 95%; margin:4%; padding:1%; border:1px solid #e0e0e0; border-radius: 5px;}
      .layui-form-item{border-bottom:1px solid #e0e0e0;}*/
      .radio{width: 300px;}
      .radio input{length: 280px;}
    </style>
  </head>

  <body>
    <div class="x-body radio">
        <form class="layui-form " action="javascript:;">
          <div class="layui-form-item">
              <label class="layui-form-label">
                  <span class="x-red">*</span>押金比例
              </label>
              <div class="layui-input-block" style="margin-top: 10px;">
                <input type="text" name="ratio" id="ratio" class="layui-input" value="<?php echo substr($ratioRes['ratio'],0,-1); ?>" />
              </div>
          </div>
          <div class="layui-form-item">
            <input type="hidden" name="auditId" id='auditId' value="<?php echo $_GET['id']; ?>">
            <!-- <center><button class="layui-btn" layui-submit lay-filter="ratio" >确定</button></center> -->
            <center><a class="layui-btn" onclick="modify()" href="javascript:;">确定</a></center>
          </div>
          
      </form>
    </div>
<script type="text/javascript">
  var layer;
  layui.use(['layer'],function(){
    layer = layui.layer;
  });
function modify(){
  var ratio = $("#ratio").val();
  var auditId = $("#auditId").val();
  var data = {ratio:ratio,auditId:auditId};
  console.log(data);
  $.post('?c=UserAudit&a=ratioModify',data,function(res){
    console.log(res);
    if(!res.res){
      layer.msg(res.msg,{icon:1,time:2000});
    }else{
      layer.msg(res.msg,{icon:5,time:2000});
    }
  },'json');
}
</script>
  </body>
</html>
