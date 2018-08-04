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
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      <table class="layui-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>登录名</th>
            <th>手机</th>
            <th>邮箱</th>
            <th>角色</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody>
          <?php foreach($role as $kk=>$vv){
                   
          ?>

          <tr>
            <td><?= $vv['id'] ?></td>
            <td><?= $vv['name'] ?></td>
            <td><?= $vv['phone'] ?></td>
            <td><?= $vv['email'] ?>
            <td><?= $vv['role_name'] ?></td>
            <td class="td-status">
              <?php if($vv['id'] != 1){ ?>
                  <?php if( $vv["status"] == 0){ ?>
                      <button class="layui-btn layui-btn-normal member_stop" data-id="<?= $vv['id'] ?>" data-status="<?= $vv['status'] ?>">已启用</button>
                    <?php }else{ ?>
                      <button class="layui-btn layui-btn-warm member_stop"  data-id="<?= $vv['id'] ?>" data-status=status="<?= $vv['status'] ?>">已禁用</button>
                    <?php } ?>
                <?php }else{ ?>
                  <button class="layui-btn layui-btn-disabled">已启用</button>
                <?php }?>
            </td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','?c=admin&a=edit&id=<?= $vv['id'] ?>',700)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
               <?php if($vv['id'] != 1){ ?>
              <a title="删除" onclick="member_del(this,'<?= $vv['id'] ?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              <?php } ?>
            </td>
          </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </body>
</html>
<script type="text/javascript" src="<?php echo TPL_URL;?>/js/admin_index.js?r=<?php echo time();?>"></script>
