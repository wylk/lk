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
        <form class="layui-form layui-col-md12 x-so">
          <div class="layui-input-inline">
            <input type="text" name="username"  placeholder="发卡用户" autocomplete="off" class="layui-input">
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach" ><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      <table class="layui-table">
        <thead>
          <tr>
            <th>用户ID</th>
            <th>合约名</th>
            <th>价格</th>
            <th>量</th>
            <th>组</th>
            <th>logo</th>
            <th>描述</th>
            <th>操作</th>
        </thead>
        <tbody>

          <?php foreach($cards as $k=>$v){ ?>
          <tr>
            <td><?= $v['uid'] ?></td>
            <td><?= $v['name'] ?></td>
            <td><?= $v['price'] ?></td>
            <td><?= $v['sum'] ?></td>
            <td><?= $v['group'] ?></td>
            <td><img src="<?= $v['card_log'] ?>"></td>
            <td><?= $v['describe'] ?></td>
            <td>
              <button class="layui-btn layui-bg-red" onclick="x_admin_show('交易信息','?c=coiling&a=lists&uid=<?= $v['uid'] ?>&card_id=<?= $v['card_id'] ?>',600,400)" style="height:44px"><i class="layui-icon"></i>交易信息</button>
            </td>
          </tr>

        <?php } ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <a class="prev" href="">&lt;&lt;</a>
          <a class="num" href="">1</a>
          <span class="current">2</span>
          <a class="num" href="">3</a>
          <a class="num" href="">489</a>
          <a class="next" href="">&gt;&gt;</a>
        </div>
      </div>

    </div>
  </body>

</html>
