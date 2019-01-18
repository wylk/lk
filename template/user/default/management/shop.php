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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
      .list_body,.list_title,.list_content{border:1px solid #d0cfcf;border-radius: 4px;}
      .list_body{background-color: #f2f2f2;width: 100%;/*height: 200px;*/padding-bottom:15px;}
      .list_title{background: white;width: 95%;margin:0 auto;text-align: center;margin-top: 15px;height: 30px;line-height: 30px;}
      .list_head{width: 16%;display: block;float:left;}
      
      .list_content{background: white;width: 95%;margin:0 auto;text-align: center;margin-top:6px;height: 60px;}
      .rows{width: 16%;display: block;height:60px;float:left;}
      .rows_content{line-height:60px;}
      .row{width: 16%;display: inline-block;}
      .row_content{line-height: 30px;width:100%;display: inline-block;}

      .rows_line{border-right: 1px solid #cecdcd;}
      .cols_line{border-bottom: 1px solid #cecdcd;}
    </style>
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">应用</a>
        <a><cite>店铺管理</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body" >
      <div class="layui-row" ></div>
        <span class="x-right" style="line-height:40px;">共有数据：100 条</span>
      <div style="clear:both;"></div>
      <div class="list_body">
        <div class="list_title">
          <span class="list_head rows_line">店铺名称</span>
          <span class="list_head rows_line">平台</span>
          <span class="list_head rows_line">调用接口</span>
          <span class="list_head rows_line">调用次数</span>
          <span class="list_head rows_line">支付总额</span>
          <span class="list_head">状态</span>
        </div>
        <?php for($i=1;$i<5;$i++){ ?>
        <div class="list_content">
          <span class="rows rows_content rows_line">芝芸花艺</span>
          <span class="rows rows_content rows_line">壹商城</span>
          <span class="rows rows_line">
            <span class="row_content cols_line">组合支付</span>
            <span class="row_content">余额支付</span>
          </span>
          <span class="rows rows_line">
            <span class="row_content cols_line">34</span>
            <span class="row_content">34</span>
          </span>
          <span class="rows rows_line">
            <span class="row_content cols_line">123.45</span>
            <span class="row_content">123.45</span>
          </span>
          <span class="rows rows_content">开关</span>
          <div style="clear:both;"></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>

