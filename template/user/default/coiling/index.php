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
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/index.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
  </head>
  <body>

    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="?c=coiling&a=index">卡券首页</a>
      </span>
      <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新" style="margin-left: 870px;">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="layui-container">
    <div class="layui-row">
    <div class="x-body">
    <div class="flex-direction" style="margin-left: -105px;width: 1129px;height: 480px;">
        <div class="layui-row">
        <ul class="layui-row layui-col-space10 layui-this" style="padding-top: 35px;padding-left:58px;">

          <?php foreach ($contract as $key => $value) { ?>
          <li class="layui-col-xs2" style="height: 220px;">
            <img src="http://lk.com/upload/images/000/000/001/201806/5b32f7ecc1ab4.jpg">
              <span><?= $value['contract_name'] ?></span>
                <h2 style="color:red"><?= number_format($contractInfo[$value['contract_title']]['sum'],2) ?></h2>
              <ul>
                <li title="<?= number_format($contractInfo[$value['contract_title']]['sum'],2) ?>">发布卡数量：<?= number_format($contractInfo[$value['contract_title']]['sum'],2) ?></li>
                <li title="<?= number_format($contractInfo[$value['contract_title']]['num'],0) ?>">发布店铺：<?= number_format($contractInfo[$value['contract_title']]['num'],0) ?></li>
              </ul>
              <ul style="margin-left: 145px;margin-top: -69px;">
                <li title="<?= number_format($contractInfo[$value['contract_title']]['tranNum'],2) ?>">交易量：<?= number_format($contractInfo[$value['contract_title']]['tranNum'],2) ?></li>
                <li title="<?= number_format($contractInfo[$value['contract_title']]['userNum'],0) ?>">用户数量：<?= number_format($contractInfo[$value['contract_title']]['userNum'],0) ?></li>
              </ul>
              <a class="layui-btn layui-btn-primary layui-btn-lg" href="?c=coiling&a=cards&type=<?= $value['contract_title'] ?>">详情</a>
          </li>
          <?php } ?>

           <!--  <li class="layui-col-xs2" style="height: 220px;">
            <img src="http://lk.com/upload/images/000/000/001/201806/5b32f7ecc1ab4.jpg">
              <span>积分会员卡</span>
                <h2 style="color:red">0</h2>
              <ul>
                <li>发布卡数量：0</li>
                <li>发布店铺：0</li>
              </ul>
              <ul style="margin-left: 145px;margin-top: -69px;">
                <li>交易量：0</li>
                <li>用户数量：0</li>
              </ul>
              <a class="layui-btn layui-btn-primary layui-btn-lg" href="">详情123</a>
          </li> -->
          </ul>
        </div>
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

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }

          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
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
