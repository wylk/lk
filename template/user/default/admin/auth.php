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
      var delAuthUrl = "<?php dourl('delAuth');?>";
      var authUrl = "<?php dourl('auth');?>";
    </script>
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
        <a href="">管理员管理</a>
        <a>
          <cite>菜单管理</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-  form-pane">
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="权限名称" name="name" lay-verify="name">
          </div>
          <div class="layui-input-inline">
            <select name="pid">
              <option value="0">父类</option>
              <?php foreach($pids as $kk => $vv){?>
                <option value="<?php echo $vv['id']?>"><?php echo $vv['name']?></option>
              <?php }?>
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
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      <table class="layui-table">
        <thead>
          <tr>
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
            <td><?php echo $v['id'];?></td>
            <td><?php echo $v['name'];?></td>
            <td><?php echo $v['auth_c'];?></td>
            <td><?php echo $v['auth_a'];?></td>
            <td><?php echo $v['is_show']=='1'?'显示':'不显示';?></td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','?c=admin&a=authEdit&id=<?php echo $v['id'];?>',600,500)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,'<?= $v['id'] ?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
             <!--  <a title="删除" onclick="member_del(this,'<?php echo $v['id'];?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a> -->
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </body>
</html>
<script type="text/javascript">
  //菜单删除
       function member_del(obj,id){
          layer.confirm('确定删除吗？',function(index){
              //发异步删除数据
                $.post("?c=admin&a=delAuth",{id:id},function(data){
                  if(data.error==0){
                     $(obj).parents("tr").remove();
                     layer.msg('已删除!',{icon:1,time:1000});
                  }else{
                     alert(layer.msg);
                  }

               },'json')

          });
      }



      //      function member_del(obj,id){
      //     layer.confirm('确认要删除吗？',function(index){
      //       $.post("?c=user&a=delete",{id:id},function(data){
      //         console.log(data);
      //         if(data.status==0){
      //           //发异步删除数据
      //           $(obj).parents("tr").remove();
      //           layer.msg('已删除!',{icon:1,time:1000});
      //         }else{
      //           layer.msg('删除失败!',{icon:1,time:1000});
      //         }
      //       },'json')

      //     });
      // }





</script>
