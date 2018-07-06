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
        <form class="layui-form layui-col-md12 x-so">
          <input type="text" name="username"  placeholder="请输入姓名" autocomplete="off" class="layui-input">
          <input type="text" name="username"  placeholder="请输入身份证号" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','./member-add.html',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th style="width:17px;">ID</th>
            <th>姓名</th>
            <th>身份证号</th>
            <th>图片</th>
            <th>提交时间</th>
            <th>审核时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>

        <?php foreach($arr as $k=>$v){
          if(!$v['isdelete']==3){
        ?>
        <tbody>
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td><?= $v['id'] ?></td>
            <td><?= $v['name'] ?></td>
            <td><?= $v['postcards'] ?></td>
            <td>
              <img src="<?= $v['img_just'] ?>" style="width:47px" onclick="previewImg(this,'<?= $v['img_just'] ?>')" >
              <img src="<?= $v['img_back'] ?>" style="width:47px" onclick="previewImg(this,'<?= $v['img_just'] ?>')" >
              <img src="<?= $v['img_oneself'] ?>" style="width:47px" onclick="previewImg(this,'<?= $v['img_just'] ?>')" >
            </td>
            <td><?= date('Y-m-d H:i:s',$v['careat_time']); ?></td>
            <td><?= date('Y-m-d H:i:s',$v['update_time']); ?></td>
            <td>
              <?php if($v['status']==0){
                      echo '待审核';
                    }elseif($v['status']==1){
                      echo '审核通过';
                    }else{
                      echo '审核不通过';
                    }
              ?>
            </td>
            <td class="td-manage">
                  <a title="详情"  onclick="x_admin_show('详情','?c=UserAudit&a=plists&id=<?= $v['id'] ?>',700)" href="javascript:;">
                    <i class="layui-icon">&#xe705;</i>
                  </a>
              <?php if($v['status']==0 || $v['status']==2){ ?>
                  <a onclick="member_stop(this,'<?= $v['id'] ?>')" href="javascript:;"  title="审核通过">
                  <i class="layui-icon">&#x1005;</i>
                  </a>
                  <a onclick="x_admin_show('驳回申请','?c=userAudit&a=feedback&id=<?= $v['id'] ?>&status=<?= $v['status'] ?>',600,400)" title="驳回申请" href="javascript:;">
                    <i class="layui-icon">&#x1007;</i>
                  </a>
              <?php } ?>
              <a title="删除" onclick="member_del(this,'<?= $v['id'] ?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
        </tbody>

        <?php }} ?>

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
      //图片展示
      function previewImg(obj) {
             var img = new Image();
             img.src = obj.src;
             var imgHtml = "<img src='" + obj.src + "' />";
            //捕获页
             layer.open({
                 type: 1,
                 shade: false,
                title: false, //不显示标题
                //area:['600px','500px'],
               area: [600+'px', 480+'px'],
                 content: imgHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                 cancel: function () {
                    //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                 }
           });
         }


       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要审核吗？',function(index){
           $.post('?c=UserAudit&a=pchange',{id:id},function(res){
            console.log(res);
            if(res.error == 0){
                layer.msg(res.msg,{icon:1,time:2000});
                window.location.replace(location.href);
              }else{
                layer.msg(res.msg,{icon:4,time:2000});
              }
           },'json')
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
         layer.confirm('确认要删除吗？',function(index){
              $.post('?c=UserAudit&a=delete',{id:id},function(res){
                console.log(res);
                if(res.error == 0){
                  $(obj).parents("tr").remove();
                  layer.msg(res.msg,{icon:1,time:1000});
                }else{
                  layer.msg(res.msg,{icon:4,time:1000});
                }
              },'json');
          });
      }

      function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }

    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>
