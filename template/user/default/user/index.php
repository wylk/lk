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

  <body class="layui-anim layui-anim-up">
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
        <form class="layui-form layui-col-md12 x-so layui-form-pane" action="?c=user&a=index" method="post">
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="手机号" name="phone" lay-verify="name">
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="shows" ><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      <table class="layui-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>手机</th>
            <th>认证类型</th>
            <th>操作</th></tr>
        </thead>
        <tbody>

          <?php
            foreach($user as $k=>$v){
            if(!$v['isdelete']==3){
          ?>

          <tr>
            <td><?= $v["id"] ?></td>
            <td><?= $v["name"] ?></td>
            <td><?= $v["phone"] ?></td>
            <td>
              <?php
                if($v['status']==0){
                  echo '未认证';
                }elseif($v['status']==1){
                  echo '个人认证';
                }elseif($v['status']==2){
                  echo '企业认证';
                }
              ?>
            </td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','?c=user&a=edit&id=<?= $v['id'] ?>',550,200)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,'<?= $v['id'] ?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>

          <?php }} ?>

        </tbody>
      </table>
      <div class="page">
        <div>
          <?php echo $page ?>
        </div>
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

      //监听提交
      form.on('submit(shows)', function(data) {
          console.log(data.field);
          $.post(authUrl, data.field, function(res) {
              console.log(res);
              // if(res.error == 0){
              //     swal("友情提示！", res.msg,"success",false);
              //     setTimeout(function(){
              //         window.location.replace(location.href);
              //     },2000)
              // }else{
              //     swal("友情提示！", res.msg,"error");
              // }
          },'json');
          return false;
      });

      //禁用 启用
        $('.member_stop').click(function(){
            var data = {}
            data.id = $(this).data('id');
            data.status = $(this).data('status');
            $.get('?c=user&a=change',data,function(res){
                console.log(res);
                if(res.status == 0){
                    alert(res.msg);
                    window.location.replace(location.href);
                }else{
                    alert(res.msg);
                }
            },'json')
        })


      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
            $.post("?c=user&a=delete",{id:id},function(data){
              console.log(data);
              if(data.status==0){
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!',{icon:1,time:1000});
              }else{
                layer.msg('删除失败!',{icon:1,time:1000});
              }
            },'json')

          });
      }

      function selects(obj,id){
            $.get("?c=user&a=index",{name:name},function(data){
              console.log(data);
              // if(data.status==0){
              //   //发异步删除数据
              //   $(obj).parents("tr").remove();
              //   layer.msg('已删除!',{icon:1,time:1000});
              // }else{
              //   layer.msg('删除失败!',{icon:1,time:1000});
              // }
            },'json')

      }
      // function delAll (argument) {

      //   var data = tableCheck.getData();

      //   layer.confirm('确认要删除吗？'+data,function(index){
      //       //捉到所有被选中的，发异步进行删除
      //       layer.msg('删除成功', {icon: 1});
      //       $(".layui-form-checked").not('.header').parents('tr').remove();
      //   });
      // }
    </script>
  </body>

</html>
