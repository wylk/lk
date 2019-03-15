<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>lib/layui/css/layui.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
      .func_block{border:1px solid #e6e6e6;border-bottom: 0px;margin:30px 25px;}
      .layui-row{display: flex;text-align: center;border-bottom:1px solid #e6e6e6;min-height: 45px;}
      .layui-row .layui-col-xs4{align-self: center;}
      .layui-col-xs4 img{max-width: 25%;}
    </style>
  </head>

  <body>
  <div class="func_block">
      <div class="layui-row">
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">类别</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md8">内容</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md2">图片</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">时间</div>
      </div>
      <?php foreach($info as $key=>$val){ ?>
      <div class="layui-row">
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">
            <?php echo empty($val['fid']) ? "主贴" : "留言" ?>
          </div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md8">
            <?php echo $val['content']; ?>
          </div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md2">
            <?php if(!empty($val['img'])){ ?>
              <img src="<?php echo $val['img'] ?>">
            <?php } ?>
          </div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">
            <?php echo date("Y-m-d H:s:i",$val['createtime']) ?>
          </div>
      </div>
      <?php } ?>
  </div>
  </body>
</html>
