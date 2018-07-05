<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
</head>
<body>

<form class="layui-form" action="./login.php">
  <div class="layui-form-item">
    <label class="layui-form-label">手机号</label>
    <div class="layui-input-block">
      <input type="text" name="phone" id="phone" required  lay-verify="required" placeholder="手机号" autocomplete="off" class="layui-input">
      <div class="layui-form-mid layui-word-aux" id="phoneCheck"></div>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">验证码</label>
    <div class="layui-input-inline">
      <input type="text" name="code" required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">只能使用手机验证</div>
  </div>
 
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <input type="hidden" name="logintype" value='register' />
      <button type="reset" class="layui-btn layui-btn-primary">重置</button> 
      <button type="button" name="getVerify" id="getVerify" class="layui-btn">获取验证码</button>
    </div>
  </div>
</form>
 
<script>
$("#phone").blur(function(){
  var phone = $("#phone").val();
  var reg = /^1([0-9]{10})$/;
  if(!reg.test(phone)) {
    $("#phoneCheck").val("请输入正确的手机号");
    return;
  }
  var data = {phone:phone,type:"check"}
  $.post("./login.php",data,function(result){
    console.log(result);
    var jsonres = JSON.parse(result);
    console.log(jsonres);
    console.log(jsonres.res);
    if(result.res){
      $("#phoneCheck").html("该手机号可以注册");
      $("#getVerify").attr("disabled",false);
    }else{
      $("#phoneCheck").html("该手机号已经被注册");
      $("#getVerify").attr("disabled",true);
    }
  })
});
$("#getVerify").bind("click",getVerify);
function getVerify(){
    var phone = $("#phone").val();
    phone = phone.replace(/(^\s+)|(\s+)|(\s+$)/g,"");
    if(!phone) {
        alert("请输入手机号");
        return;
    }
    var reg = /^1([0-9]{10})$/;
    if(!reg.test(phone)) return ;
    var data = {phone:phone,type : "code"}
    $.post("./login.php",data,function(result){
        // console.log("res:",result);
        countDown = 60;
        setTime();
    })
}
var countDown;
function setTime(){
    // alert("dff");
    if(countDown == 0){
        $("#getVerify").html("获取验证码");
        $("#getVerify").attr("disabled",false);
    }else{
        $("#getVerify").html("重新发送"+countDown);
        $("#getVerify").attr("disabled",true);
        countDown--;
        setTimeout(function(){
            setTime();
        },1000);
    }
}
</script>

</body>
</html>