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
    <div class="x-body">

          <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label" >
                  <span class="x-red">*</span>登录名
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="name" required="" lay-verify="required"
                  autocomplete="off" value="" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
                <div class="layui-form-item">
              <label for="phone" class="layui-form-label">
                  <span class="x-red">*</span>登录密码
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="" id="upwd"  required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="phone" class="layui-form-label">
                  <span class="x-red">*</span>手机
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="" id="phone"  required="" lay-verify="phone"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>邮箱
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="" id="email"  required="" lay-verify="email"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>角色
              </label>
              <div class="layui-input-inline">
                  <select id="role_name" lay-verify="required" lay-search="" >
                    <option value="">请选择</option>
                    <?php foreach($role as $k=>$v){ ?>
                    <option value="<?= $v['id'] ?>"><?= $v['role_name'] ?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" id="admin">
                 添加
              </button>
          </div>

    </div>
  </body>
</html>
<script type="text/javascript" src="<?php echo TPL_URL;?>/js/admin_edit.js?r=<?php echo time();?>"></script>
<script type="text/javascript">
   $('#admin').click(function(){
    var name=$('#name').val();
    var upwd=$('#upwd').val();
    var phone=$('#phone').val();
    var email=$('#email').val();
    var role_name=$('#role_name').val();
    if(name.length < 5){
        return alert('昵称至少得5个字符啊');
    }
    if(upwd.length < 6){
       return alert('请输入6-12位密码');
    }else if(upwd.length >12){
       return alert('密码格式错误');
    }
    var phoneReg = /^1([0-9]{10})$/;
    if(!phoneReg.test(phone)){
        return alert('请输入正确的手机号');
    }
    var emailReg = /^[a-zA-Z0-9]{1,10}@[a-zA-Z0-9]{1,5}\.[a-zA-Z0-9]{1,5}$/;
    if(!emailReg.test(email)){
        return alert('请输入正确的邮箱');
    }
    if(role_name==0){
        return alert('请选择角色');
    }
   $.post("?c=admin&a=adminAdd",{name:name,upwd:upwd,phone:phone,email:email,role_name:role_name},function(data){
   if(data.status==0){
   alert(data.msg);
   }else{
    alert(data.msg);
   }

   },'json')

   })

</script>

