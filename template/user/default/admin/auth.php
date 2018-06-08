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
    <script type="text/javascript" src="<?php echo TPL_URL;?>/js/admin_auth.js?r=<?php echo time();?>"></script>
  </head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素88</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-form-pane">
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="权限名称" name="name" lay-verify="name">
          </div>
          <div class="layui-input-inline">
            <select name="pid">
              <option value="0">父类</option>
              <option value="1">会员管理</option>
              <option value="2">订单管理</option>
            </select>
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="请求控制器" name="auth_c" lay-verify="auth_c">
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="请求方法" name="auth_a" lay-verify="auth_a">
          </div>
          <div class="layui-input-inline">
            <select name="is_show">
              <option value="0">不显示</option>
              <option value="1">显示</option>
            </select>
          </div>
          <input class="layui-input" placeholder="图标" name="icon" lay-verify="icon">
          <button class="layui-btn"  lay-submit="" lay-filter="add" ><i class="layui-icon"></i>增加</button>
        </form>

      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>权限名称</th>
            <th>请求控制器</th>
            <th>请求方法</th>
            <th>是否显示</th>
            <th>操作</th>
        </thead>
        <tbody>
          <?php foreach ($auth as $k => $v){?>
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td><?php echo $v['id'];?></td>
            <td><?php echo $v['name'];?></td>
            <td><?php echo $v['auth_c'];?></td>
            <td><?php echo $v['auth_a'];?></td>
            <td><?php echo $v['is_show']=='1'?'显示':'不显示';?></td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','xxx.html')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          <?php }?>
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