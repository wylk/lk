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
       <!--  <form class="layui-form layui-col-md12 x-so"> -->
          <input type="text" name="username"  placeholder="请输入企业名称" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon" id="set">&#xe615;</i></button>
       <!--  </form> -->
      </div>
        <span class="x-right" style="line-height:40px">共有数据: <?php echo $num?> 条</span>
      <table class="layui-table">
        <thead>
          <tr>
            <th>姓名</th>
            <th>企业名称</th>
            <th>营业执照编号</th>
            <th>身份证</th>
            <th>营业执照</th>
            <th>提交时间</th>
            <th>审核时间</th>
            <th>比例</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>

        <tbody id="box">
        <?php foreach($res as $k=>$v){
          if(!$v['isdelete']==3){
        ?>
          <tr>
            <!-- <td><?= $v['id'] ?></td> -->
            <td title="<?= $v['name'] ?>"><?= $v['name'] ?></td>
            <td title="<?= $v['enterprise'] ?>"><?= mb_substr($v['enterprise'],0,4,'utf-8') ?></td>
            <td title="<?= $v['business_license'] ?>"><?= mb_substr($v['business_license'],0,6); ?></td>
            <td><img src="<?= $v['img_oneself'] ?>" onclick="previewImg(this,'<?= $v['img_just'] ?>')"></td>
            <td><img src="<?= $v['business_img'] ?>" onclick="previewImg(this,'<?= $v['img_just'] ?>')"></td>
            <td><?= date('Y-m-d H:i:s',$v['create_time']); ?></td>
            <td><?= date('Y-m-d H:i:s',$v['update_time']); ?></td>
            <td><?= $v['ratio'] ?><br/>
              <a title="修改" onclick="x_admin_show('修改','?c=UserAudit&a=ratioModify&id=<?= $v['id'] ?>',400,300)" href="javascript:;">修改</a>
            </td>
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
              <a title="详情"  onclick="x_admin_show('详情','?c=UserAudit&a=lists&id=<?= $v['id'] ?>',1000)" href="javascript:;">
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

      //图片展示
      function previewImg(obj) {
             var img = new Image();
             img.src = obj.src;
             var imgHtml = "<img style='width: 500px; margin:4%; padding:1%; border:1px solid #e0e0e0; border-radius: 5px;' src='" + obj.src + "' />";
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
           $.post('?c=UserAudit&a=change',{id:id},function(res){
            console.log(res);
            if(res.error == 0){
                layer.msg(res.msg,{icon:1,time:2000});
                window.location.replace(location.href);
              }else{
                layer.msg(res.msg,{icon:4,time:2000});
              }
           },'json')
              // if($(obj).attr('title')=='启用'){
              //   //发异步把用户状态进行更改
              //   $(obj).attr('title','停用')
              //   $(obj).find('i').html('&#xe62f;');

              //   $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
              //   layer.msg('已停用!',{icon: 5,time:1000});

              // }else{
              //   $(obj).attr('title','启用')
              //   $(obj).find('i').html('&#xe601;');

              //   $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
              //   layer.msg('已启用!',{icon: 5,time:1000});
              // }

          });
      }
       $('#set').click(function(){
               var enterprise=$('.layui-input').val();
               $.post('?c=UserAudit&a=index_to',{enterprise:enterprise}, function(res) {
               console.log(res);
               if(res.error == 0){
                  $('#box').empty();
                    var str = "<tr><td>"+res['data']['name']+"</td><td>"+res['data']['enterprise']+"</td><td>"+res['data']['business_license']+"</td><td>";
                    str +="<img src="+res['data']['img_oneself']+" onclick=\"previewImg(this,"+res['data']['img_just']+")\">";
                    str +="</td><td>";
                     str +="<img src="+res['data']['business_img']+" onclick=\"previewImg(this,"+res['data']['img_just']+")\">";
                    str +="</td><td>";
                    str += res['data']['create_time'];
                    str +="</td><td>";
                    str += res['data']['update_time'];
                    str +="</td><td>";
                    str += res['data']['ratio'];
                    str +="<br/><a title='修改'' onclick=\"x_admin_show('修改','?c=UserAudit&a=ratioModify&id="+res['data']['id']+"',400,300)\" href='javascript:;'>修改</a>";
                    str +="</td><td>";
                    if(res['data']['status'] == 0) str += '待审核';
                    if(res['data']['status'] == 1) str += '审核通过';
                    if(res['data']['status'] == 2) str += '审核不通过';
                    str +="</td><td class='td-manage'><a title='详情''  onclick=\"x_admin_show('详情','?c=UserAudit&a=lists&id="+res['data']['id']+"',1000)\" href='javascript:;'><i class='layui-icon'>&#xe705;</i></a>";

               if(res['data']['status']==0 || res['data']['status']==2) str+= "<a onclick=\"member_stop(this,'"+res['data']['id']+"')\" href='javascript:;'  title='审核通过'><i class='layui-icon'>&#x1005;</i></a><a onclick=\"x_admin_show('驳回申请','?c=userAudit&a=feedback&id="+res['data']['id']+" ?>&status="+res['data']['status']+",600,400)\" title='驳回申请' href='javascript:;'><i class='layui-icon'>&#x1007;</i></a><a title='删除' onclick=\"member_del(this,"+res['data']['id']+")\" href='javascript:;'><i class='layui-icon'>&#xe640;</i></a>"
                str +="</td></tr>";

                $('#box').append(str);
               }else{
                alert(res.msg);
              }



               },'json')
             })





























      function member_ratio_modify(obj,id){

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
