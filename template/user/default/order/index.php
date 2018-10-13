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
    <style>
      .layui-input{width: 25%;float: left;}
    </style>
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
      <!--   <form class="layui-form layui-col-md12 x-so"> -->
       <div class="layui-input-inline">
            <select name="num" class="num">
              <option value="">购买数量</option>
              <option value="1">小于50</option>
              <option value="2">大于50</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="pice" class="pice">
              <option value="">成交金额</option>
              <option value="3">小于50</option>
              <option value="4">大于50</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="status" class="select">
              <option value="">订单状态</option>
              <option value="0">待付款</option>
              <option value="1">已付款</option>
              <option value="2">已作废</option>
            </select>
          </div>
          <input type="text" name="onumber"  placeholder="请输入订单号" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon" id="set">&#xe615;</i></button>
       <!--  </form> -->
      </div>
     <!--  <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','?c=order&a=add')"><i class="layui-icon"></i>添加</button> -->
        <span class="x-right" style="line-height:40px">共有数据：<?php  echo $num ?>条</span>

      <table class="layui-table">
        <thead>
          <tr>
            <th>订单编号</th>
            <th>购买数量</th>
            <th>成交金额</th>
            <th>订单状态</th>
            <th>下单时间</th>
            <th>交易详情</th>
            </tr>
        </thead>
        <tbody id="box">
          <?php foreach($order as $k=>$v){ ?>
        <tr>
            <td><?= $v['onumber'] ?></td>
            <td><?= $v['number'] ?></td>
            <td><?= $v['prices'] ?></td>
            <td><?php
              if($v['status']==0){
                echo '待付款';
              }elseif($v['status']==1){
                echo '已完成';
              }elseif($v['status']==2){
                echo '已作废';
              }
            ?></td>

            <td><?= date('Y-m-d H:i:s',$v['create_time']) ?></td>
            <td>  <a title="更多"  onclick="x_admin_show('详情','?c=order&a=oderlists&id=<?= $v['id'] ?>',350,350)" href="javascript:;">
                <i class="layui-icon">&#xe705;</i>
              </a></td>
          </tr>

          <?php } ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <?php  echo $page; ?>
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


      //搜索
         $('#set').click(function(){
         var onumber=$('.layui-input').val();
         var status=$('.select').val();
         var pice =$('.pice').val();
         var num =$('.num').val();
         $.post('?c=order&a=index_to',{onumber:onumber,status:status,pice:pice,num:num}, function(res) {
         if(res.error == 0){
            $('#box').empty();
            var str = "<tr><td>"+res['data']['onumber']+"</td><td>"+res['data']['number']+"</td><td>"+res['data']['prices']+"</td><td>";
              if(res['data']['status'] == 0) str += '代付款';
              if(res['data']['status'] == 1) str += '已完成';
              if(res['data']['status'] == 2) str += '已作废';
              str += "</td><td>";
              str += res['data']['create_time'];
              str +="</td></tr>";
              $('#box').append(str);
         }else if(res.error ==2){
              console.log(res);
              $('#box').empty();
              var str = '';
              for(var item in res['data']){
                str += "<tr><td>"+res['data'][item]['onumber']+"</td><td>"+res['data'][item]['number']+"</td><td>"+res['data'][item]['prices']+"</td><td>";
                if(res['data'][item]['status'] == 0) str += '代付款';
                if(res['data'][item]['status'] == 1) str += '已完成';
                if(res['data'][item]['status'] == 2) str += '已作废';
                str += "</td><td>"+res['data'][item]['create_time']+"</td></tr>";
                $('#box').html(str);
              }
        }else if(res.error ==3){
               console.log(res);
              $('#box').empty();
              var str = '';
              for(var item in res['data']){
                str += "<tr><td>"+res['data'][item]['onumber']+"</td><td>"+res['data'][item]['number']+"</td><td>"+res['data'][item]['prices']+"</td><td>";
                if(res['data'][item]['status'] == 0) str += '代付款';
                if(res['data'][item]['status'] == 1) str += '已完成';
                if(res['data'][item]['status'] == 2) str += '已作废';
                str += "</td><td>"+res['data'][item]['create_time']+"</td></tr>";
                $('#box').html(str);
              }

        }else if(res.error ==4){
               console.log(res);
              $('#box').empty();
              var str = '';
              for(var item in res['data']){
                str += "<tr><td>"+res['data'][item]['onumber']+"</td><td>"+res['data'][item]['number']+"</td><td>"+res['data'][item]['prices']+"</td><td>";
                if(res['data'][item]['status'] == 0) str += '代付款';
                if(res['data'][item]['status'] == 1) str += '已完成';
                if(res['data'][item]['status'] == 2) str += '已作废';
                str += "</td><td>"+res['data'][item]['create_time']+"</td></tr>";
                $('#box').html(str);
              }

        }else{

          alert(res.msg);
        }

      },'json')
  })

function getTime(){
  // console.log(time);
  var date = new Date();
  // console.log(date);
  // var date = time;
  // date.setTime(time * 1000);
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  m = m < 10 ? ("0"+m) : m;
  var d = date.getDate();
  d = d < 10 ? ("0" + d) : d;
  var h = date.getHours();
  h = h < 10 ? ("0" + h) : h;
  var i = date.getMinutes();
  i = i < 10 ? ("0" + i) : i;
  var s = date.getSeconds();
  s = s < 10 ? ("0" + s) : s;
  // console.log(time,time,y,m,d,h,s);
  return y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
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
