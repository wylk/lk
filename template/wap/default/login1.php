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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
    body{
       background: -webkit-linear-gradient(#70d1f5, #48bee9);
    }
      .check_wrapper, .login_wrapper {
            padding: 10px;
            background: white;
            border-radius: 5px;
            height: 250px;
            margin: -4px 38px 0px;
        }
      /*输入框*/
    
      .login_input{display: flex;padding: 25px 15px 0px;}
      .login_line{border-bottom: 2px solid #d2d2d2;}
      .login_input span{display: flex;align-items: center;width: 110px;flex-direction: column;justify-content: center;}
      .login_input input{    
            border: 0px;
            font-size: 14px;
            margin:0px;
            padding: 10px 5px;
        }
      .login_input img{height: 70%;border-radius:4px;width: 100%;}
      /*点击按钮*/
      .btn {
            border: 1px solid #f8fcfd;
            height: 30px;
            background: white;
            width: 100%;
            font-size: 15px;
            color: #4fc2eb;
            border-radius: 5px;
            height: 38px;
        }
      .btn_action{background: #a9e6ef;}
      /*短信获取按钮*/
      .check_phone{width: 165px;align-items: flex-start;}
      .btn_msg{border:0px;width: 100%;font-size: 12px;background: white;color:#6dd0f4;}
      .notice {text-align: center;padding: 40px 0px;font-size: 14px;}
      .notice span{margin-left:5px;}
      .notice i{color:#29aee7;}
      .img1{margin: 0 auto; display: block;/* position: relative;top: -80px;*/ width: 70%;}
      .mui-bar{background: #a9e6ef;}
      .notice a{color:white;}
      .mui-content-padded,.mui-title{color: #333;}
      .mui-table-view-cell:after {
            left: 10px;
            right: 10px;
        }
      .mui-table-view-cell:last-child:after, .mui-table-view-cell:last-child:before {
            height: 1px;
        }

    </style>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
    <script type="text/javascript"></script>
</head>

<body style="background-color: #ececec;overflow: hidden;">
 <div style="padding: 25% 25.8px 0px">
    <img src="../template/wap/default/images/11.png" style="width: 100%;height: 15px;">
 </div>
   
  <div class="login_wrapper" >
    <div class="login_block">
        <div class="login_input mui-table-view-cell" >
          <input type="number" name="phone" placeholder="手机号">
        </div>
        <div class="login_input mui-table-view-cell">
          <input type="text" name="check" placeholder="验证码">
          <span>
            <img onclick="this.src='login.php?action=check&'+Math.random();" src="./login.php?action=check"  />
          </span>
        </div>
        <div class="login_input mui-table-view-cell">
          <input type="number" name="msg_code" placeholder="短信验证码">
          <span>
            <button class="btn_msg">获取验证码</button>
          </span>
        </div>
    </div>

  </div>
     <div style="padding: 15px 38px;">
      <button id="btn_login" class="btn">登录</button>
    </div>
    <div class="notice">
      <!-- <input type="checkbox" id="checkbox" name="checkbox" value="dd">
      <span>同意 
        <a href="#modal">乐卡网</a>-->
      </span>
    </div>
</body>

</html>
<script type="text/javascript">

var phone_status = check_code_status = msg_code_status= checkbox_status = 0;
var phone = "";
var check_code="";
  // 控制输入框数量
  $("[name=phone]").bind("keyup",function(){
    var phone = $(this).val();
    if(phone.length>=11){
      $(this).val(phone.substr(0,11));
      // 验证手机号
      var phoneReg = /^1([0-9]{10})$/;
      if(!phoneReg.test(phone)){
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
    }
  });
  // 获取验证码
  $(".btn_msg").bind("click",function(){
    phone = $("[name=phone]").val();
    var phoneReg = /^1([0-9]{10})$/;
    if(!phoneReg.test(phone)){
      mui.toast("请输入正确的手机号"); return;
    }
    check_code = $("[name=check]").val();
    if(check_code.length != 4){
      mui.toast("验证码不正确");return;
    }

    var data = {phone:phone,type:"code",check_code:check_code};
    $.post("./login.php",data,function(res){
      console.log(res);
      if(res['result'] == 1){
        console.log(res['msg']);
        mui.toast(res['msg']);
      }
      if(res['result']['result']['success']){
        countDown = 60;
        setTime();
        console.log("验证码发送成功");
        mui.toast("验证码发送成功");
      }else{
        console.log("验证码发送失败");
        mui.toast("验证码发送失败");
      }
    },"json");
  });
  
  // 登录
  $("#btn_login").bind("click",function(){
    //console.log(msg_code_status);
    //if(msg_code_status != 1 || checkbox_status != 1) return;
    phone = $("[name=phone]").val();
    var phoneReg = /^1([0-9]{10})$/;
    if(!phoneReg.test(phone)){
      mui.toast("请输入正确的手机号");return;
    }
    var msg_code = $("[name=msg_code]").val();

    if(msg_code.length != 6){
         mui.toast("请输入正确的验证码");return;
    }
    
    var data = {phone:phone,logintype:"checkAccount",msg_code:msg_code};
    $.post("./login.php",data,function(res){
      if(!res['res']){
        mui.toast(res['msg']);
        setTimeout(function(){
            window.location.href =  "<?php echo $referer ? $referer : './my.php'; ?>";
        },1000)
      }else{
        
        mui.toast(res['msg']);
      }
    },"json");
  });
function setTime() {
        // alert("dff");
        if (countDown == 0) {
            $(".btn_msg").html("获取验证码");
            $(".btn_msg").attr("disabled", false);
        } else {
            $(".btn_msg").html("重新发送" + countDown);
            $(".btn_msg").attr("disabled", true);
            countDown--;
            setTimeout(function() {
                setTime();
            }, 1000);
        }
    }
</script>
