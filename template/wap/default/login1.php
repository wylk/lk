<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
      .check_wrapper,.login_wrapper{margin: 40px 5px;padding: 10px;background: white; border-radius: 4px;padding-bottom: 35px;}
      /*输入框*/
      .login_block{height:100px;border:1px solid #d2d2d2;background-color: white;display: flex;flex-direction: column;justify-content: center;border-radius:4px;margin-bottom: 50px;}
      .login_input{height: 48%;/*border:1px solid red;*/display: flex;flex-direction: row;justify-content: center;margin:0 10px;}
      .login_line{margin:0px;padding: 0px;background:#d2d2d2;height: 1px;}
      .login_input span{display: flex;align-items: center;width: 110px;flex-direction: column;justify-content: center;}
      .login_input input{border:0px; font-size:14px;height: 100%;}
      .login_input img{height: 80%;border-radius:4px;width: 100%;}
      /*点击按钮*/
      .btn_block{margin:10px;}
      .btn{border:1px solid #29aee7;height: 30px;background: #f2f2f2;width: 100%;font-size:15px;color: #333;border-radius:3px;height: 38px;}

      .btn_action{background: #a9e6ef;}
      /*短信获取按钮*/
      .check_phone{width: 165px;align-items: flex-start;}
      .btn_msg{border:0px;width: 100%;font-size: 12px;background: white;color:#29aee7;}
      .notice{margin:10px;padding-left:10px;}
      .notice span{margin-left:5px;}
      .notice i{color:#29aee7;}
      .img1{margin: 0 auto; display: block;/* position: relative;top: -80px;*/ width: 70%;}
      .mui-bar{background: #a9e6ef;}
      .notice a{color:#29aee7;}
      .mui-content-padded,.mui-title{color: #333;}
    </style>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
    <script type="text/javascript"></script>
</head>

<body style="background-color: #ececec;overflow: hidden;">
  <div class="check_wrapper">
    <!-- <div class="title" ></div> -->
    <div style="height: 100px;display: flex; justify-content: center;background-image: url(../template/wap/default/images/logo.png);background-size: 60%;background-repeat: no-repeat;    background-position: center; margin-bottom: 17px;">
      <!-- <img class="img1" src="../template/wap/default/images/logo.png"> -->
    </div>
    <div class="login_block">
      <div class="login_input">
        <input type="text" name="phone" placeholder="请输入手机号">
      </div>
      <hr class="login_line" />
      <div class="login_input">
        <input type="text" name="check" placeholder="请输入验证码">
        <span>
          <img onclick="this.src='login.php?action=check&'+Math.random();" src="./login.php?action=check"  />
        </span>
      </div>
    </div>
    <div class="btn_block">
      <button id="btn_next" class="btn">下一步</button>
    </div>
  </div>
  <div class="login_wrapper" style="display: none;">
    <div style="height: 100px;display: flex; justify-content: center;background-image: url(../template/wap/default/images/logo.png);background-size: 60%;background-repeat: no-repeat;    background-position: center; margin-bottom: 17px;"></div>
    <div class="login_block">
      <div class="login_input">
        <span class="check_phone" style="width: 180px;align-items: flex-start;"></span>
        <span><!-- 手机号： --></span>
      </div>
      <hr class="login_line" />
      <div class="login_input">
        <input type="text" name="msg_code" placeholder="请输入手机验证码">
        <span>
          <button class="btn_msg">获取验证码</button>
        </span>
      </div>
    </div>
    <div class="btn_block">
      <button id="btn_login" class="btn">登录</button>
    </div>
    <div class="notice">
      <input type="checkbox" id="checkbox" name="checkbox" value="dd">
      <span>同意
        <a href="#modal">《服务条款》</a>
      </span>
    </div>
  </div>
<!-- 同意条款 -->
<div id="modal" class="mui-modal">
  <header class="mui-bar mui-bar-nav">
    <a class="mui-icon mui-icon-close mui-pull-right" href="#modal"></a>
    <h1 class="mui-title">《服务条款》</h1>
  </header>
  <div class="mui-content" style="height: 100%;overflow: scroll;background-color: #f2f2f2;">
    <p class="mui-content-padded"><?php echo $config['reg_readme_content'];?></p>
  </div>
</div>
</body>

</html>
<script type="text/javascript">

var phone_status = check_code_status = msg_code_status= checkbox_status = 0;
var phone = "";
var check_code="";
  $("#btn_next").bind("click",function(){
    if(phone_status != 1 || check_code_status != 1) return;
    phone = $("[name=phone]").val();
    var phoneReg = /^1([0-9]{10})$/;
    if(!phoneReg.test(phone)){
      console.log("请输入正确的手机号");
      mui.toast("请输入正确的手机号");
      return;
    }
    // check_code = $("[name=check]").val();
    if(phone.length != 11 || check_code.length != 4){
      console.log("请检查手机号或者验证码是否正确填写");
      mui.toast("请检查手机号或者验证码是否正确填写");
      return;
    }
    //检测手机号、验证码
    var data = {phone:phone,type:"check",check_code:check_code}
    console.log(data);
    $.post("./login.php",data,function(res){
      console.log(res);
      if(res.res){
        var check_phone = phone.substr(0,3)+"****"+phone.substr(7);
        $(".check_phone").html(check_phone);
        $(".check_wrapper").hide();
        $(".login_wrapper").show();
      }else{
        console.log(res.msg);
        mui.toast(res.msg);
      }
    },"json");
  })
  // 控制输入框数量
  $("[name=phone]").bind("keyup",function(){
    var phone = $(this).val();
    if(phone.length>=11){
      $(this).val(phone.substr(0,11));
      // 验证手机号
      var phoneReg = /^1([0-9]{10})$/;
      if(!phoneReg.test(phone)){
        $(this).css("border","1px solid red");
        return;
      }
      phone_status = 1;
      $(this).css("border","0px");
      if(phone_status == 1 && check_code_status == 1){
        $("#btn_next").css("background-color","white");
      }
    }else{
      phone_status = 0;
      $("#btn_next").css("background-color","#f2f2f2");
      $(this).css("border","1px solid red");
    }
  });
  $("[name=check]").bind("keyup",function(){
    check_code = $(this).val();
    if(check_code.length>=4){
      check_code = check_code.substr(0,4);
      $(this).val(check_code);
      check_code_status = 1;
      $(this).css("border","0px");
      if(phone_status == 1 && check_code_status == 1){
        $("#btn_next").css("background","white");
      }
    }else{
      check_code_status = 0;
      $("#btn_next").css("background","#f2f2f2");
      $(this).css("border","1px solid red");
    }
  });
  $("[name=msg_code]").bind("keyup",function(){
    var msg_code = $(this).val();
    if(msg_code.length>=6){
      $(this).val(msg_code.substr(0,6));
      msg_code_status = 1;
      $(this).css("border","0px");
      if(msg_code_status == 1 && checkbox_status == 1)
        $("#btn_login").css("background","white");
    }else{
      msg_code_status = 0;
      $("#btn_login").css("background","#f2f2f2");
      $(this).css("border","1px solid red");
    }
  });
  // 获取验证码
  $(".btn_msg").bind("click",function(){
    var data = {phone:phone,type:"code",check_code:check_code};
    $.post("./login.php",data,function(res){
      console.log(res);
      if(res['result'] == 1){
        console.log(res['msg']);
        mui.toast(res['msg']);
      }
      if(res['result']['result']['success']){
        console.log("验证码发送成功");
        mui.toast("验证码发送成功");
      }else{
        console.log("验证码发送失败");
        mui.toast("验证码发送失败");
      }
    },"json");
  });
  // 注意选项勾选
  $("#checkbox").bind("click",function(){
    if($(this).is(":checked")){
      checkbox_status = 1;
      if(checkbox_status == 1 && msg_code_status == 1)
        $("#btn_login").css("background","white");
    }else{
      checkbox_status = 0;
      $("#btn_login").css("background","#f2f2f2");
    }
  });
  // 登录
  $("#btn_login").bind("click",function(){
    if(msg_code_status != 1 || checkbox_status != 1) return;
    var msg_code = $("[name=msg_code]").val();
    var data = {phone:phone,logintype:"checkAccount",msg_code:msg_code};
    $.post("./login.php",data,function(res){
      console.log(res);
      if(!res['res']){
        window.location.href =  "<?php echo $referer ? $referer : './my.php'; ?>";
      }else{
        console.log(res['msg']);
        mui.toast(res['msg']);
      }
    },"json");
  });
</script>
