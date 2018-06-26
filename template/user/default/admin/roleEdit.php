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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/js/common.js?r=<?php echo time();?>"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
                <input type="hidden" name="ids" value="<?= $role['id'] ?>" >
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="role_name" required="" lay-verify="required" value="<?= $role['role_name'] ?>"

                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            <?php foreach($lk_auth as $k=>$v){ ?>
                            <tr>
                                <?php if($v['pid'] == 0){ ?>
                                <td>
                                    <input type="checkbox" name="auth_id" lay-skin="primary" title="<?= $v['name'] ?>" value="<?= $v['id'] ?>" lay-filter="allChoose" <?php foreach($arr as $key=>$value){ if($value['name']==$v['name']){echo 'checked';} } ?> >
                                </td>
                                <td>
                                    <?php foreach($lk_auth as $kk=>$vv){
                                    ?>
                                    <?php if($vv['pid'] == $v['id']  ){ ?>
                                    <div class="layui-input-block" style="float: left;">
                                        <input name="auth_id" lay-skin="primary" type="checkbox" title="<?= $vv['name'] ?>" value="<?= $vv['id'] ?>" lay-filter="allChoose" <?php foreach($arr as $key=>$value){ if($value['name']==$v['name']){echo 'checked';} } ?>  >
                                    </div>

                                     <?php }} ?>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="edit">修改</button>
              </div>
            </form>
    </div>
    <script type="text/javascript">
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;

          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
          });

          form.on('checkbox(allChoose)', function(data){
              var child = $(data.elem).parent().next().find('input[type="checkbox"]');
              child.each(function(index, item){
                item.checked = data.elem.checked;
              });
              form.render('checkbox');
          });


          //监听提交
          form.on('submit(edit)', function(data){
            data.field.auth_id = lk.checkbox_val('auth_id');
            $.post('?c=admin&a=roleEdit',data.field,function(res){
                if(res.error==0){
                    layer.alert(res.msg, {icon: 1,},function () {
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                    });
                }else{
                    layer.alert(res.msg, {icon: 2,time:1000},function () {
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                    });
                }
            },'json');

            return false;
          });
 });
    </script>
  </body>
</html>
