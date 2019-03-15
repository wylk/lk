<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>lib/layui/css/layui.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
      /*搜索*/
      .func_add_block{margin:30px 25px;}
      .func_add_block .layui-form{border:1px solid #e6e6e6;display: flex;padding-top: 8px;}
      .layui-form .layui-form-item{flex-direction: row;/*border:1px solid red;*/display: flex;}
      .layui-form-item div,.layui-form-item label{align-self: center;/*border:1px solid red;*/}
      .layui-input-block{margin-left: 0px;}
      .layui-textarea{min-height: 60px;}
      .layui-form-select{width: 70%;border:1px solid #e6e6e6;border-radius: 6px}
      .layui-form-select input{border:0;}
      /*列表*/
      .func_block{border:1px solid #e6e6e6;border-bottom: 0px;margin:30px 25px;}
      .layui-row{display: flex;text-align: center;border-bottom:1px solid #e6e6e6;min-height: 45px;}
      .layui-row .layui-col-xs4{align-self: center;}
      .layui-col-xs4 img{max-width: 25%;}
      .layui-col-xs4 .image{max-width: 60%;}

      #image_block {text-align: center;margin:0 auto;}
      #image_block img{max-width: 60%;margin:10px;}
      #page{text-align: center;}
    </style>
  </head>

<body>
  <div class="x-nav">
    <span class="layui-breadcrumb">
      <a href="?c=find&a=index">发现列表</a>
      <a><cite><?php echo $info['name'] ?></cite></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
      <i class="layui-icon" style="line-height:30px">ဂ</i></a>
  </div>
  <?php echo $info['name'] ?>页面 测试
  </body>
</html>
