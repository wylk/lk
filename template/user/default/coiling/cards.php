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
    <style type="text/css">
      .layui-input{width: 100%;}
    </style>
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="?c=coiling&a=index">卡券首页</a>
        <a>
          <cite><?php echo $cardName['contract_name'] ?><span id="type" style="display: none;"><?php echo $cardName['type'] ?></span></cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
     <!--    <form class="layui-form layui-col-md12 x-so"> -->
          <div class="layui-input-inline">
            <input type="text" id="username"  placeholder="发卡用户" autocomplete="off" class="layui-input">
          </div>
          <button class="layui-btn" ><i class="layui-icon" id="set">&#xe615;</i></button>
  <!--       </form> -->
      </div>
        <span class="x-right" style="line-height:40px">共有数据：<?php  echo $count ?> 条</span>
      <table class="layui-table">
        <thead>
          <tr>
            <th>用户名</th>
            <th>店铺名称</th>
            <th>合约名</th>
            <th>量</th>
            <th>logo</th>
            <th>描述</th>
            <th>保证金比例</th>
            <th>操作</th>
        </thead>
        <tbody>

          <?php foreach($cards as $k=>$v){ ?>
          <tr>
            <td id="name_<?php echo $v['uid'] ?>"><?= $user[$v['uid']]['name']; ?></td>
            <td><?= $user[$v['uid']]['enterprise'] ?></td>
            <td><?= $v['name'] ?></td>
            <td><?= $v['sum'] ?></td>
            <td><img src="<?= $v['card_log'] ?>"></td>
            <td><?= $v['describe'] ?></td>
            <td align="center" ><input id="ratio_<?php echo $v['uid'] ?>" class="layui-input" type="text" name="ratio" value="<?php echo $ratio[$v['uid']] ?>" style="width: 50px;" /></td>
            <td>
              <button class="layui-btn layui-bg-red" onclick="x_admin_show('交易信息','?c=coiling&a=lists&uid=<?= $v['uid'] ?>&card_id=<?= $v['card_id'] ?>',600,400)" style="height:44px"><i class="layui-icon"></i>交易信息</button>
            </td>
          </tr>

        <?php } ?>
        </tbody>
      </table>
      <div class="page">
        <div>
         <?php echo $page ?>
        </div>
      </div>

    </div>
  </body>

</html>
<script type="text/javascript">
  layui.use(['layer'],function(){
    $("[id^=ratio_]").bind("change",function(){
      var ratio = $(this).val();
      var type = $("#type").html();
      var idStr = $(this).attr('id');
      var uid = idStr.substring(idStr.indexOf('_')+1);
      var name = $("#name_"+uid).html();
      layer.confirm("确定要修改“"+name+"”的保证金数据吗？",function(){
        var data = {uid:uid,ratio:ratio,type:type};
        console.log(data);
        layer.load();
        $.post("?c=coiling&a=editRatio",data,function(result){
          layer.closeAll();
          // console.log(result);
          if(!result['res']){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            window.location.reload(true);
          }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
          }
        },"json");
      },function(){
        window.location.reload(true);
      });
    });
  });



  $("#set").click(function(){
    var username=$("#username").val();
   $.post('?c=coiling&a=index_to',{username:username}, function(res) {
      console.log(res);
   },'json')
  })
</script>
