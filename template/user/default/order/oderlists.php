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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js ?>" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      .layui-input-inline img{width: 95%; margin:4%; padding:1%; border:1px solid #e0e0e0; border-radius: 5px;}
      .layui-form-item{border-bottom:1px solid #e0e0e0;}
      .layui-input-inline{top:8px;color:#2fd05a;}
    </style>
  </head>

  <body>
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>卖家名称
              </label>
              <div class="layui-input-inline" style="margin-top: 30px;">

                <?php if($sell_name['name']==''){?>
                   <?= $sell_name['phone'] ?>
                <?php }else{?>
                   <?= $sell_name['name'] ?>
                <?php } ?>
              </div>
          </div>
           <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>买家名称
              </label>
             <div class="layui-input-inline" style="margin-top: 30px;">

                <?php if($buy_name['name']==''){?>
                   <?= $buy_name['phone'] ?>
                <?php }else{?>
                      <?= $buy_name['name'] ?>
                <?php } ?>
              </div>
          </div>

    </div>

  </body>


</html>
