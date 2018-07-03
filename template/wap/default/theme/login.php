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
    <style type="text/css">
      .layui-input-block{margin-right: 50px;}
      .layui-input{border:0;}
      .layui-form-item .layui-input-inline.us-input-inline{display: inline-block; float: none; left: 0;  width: auto; margin: 0; padding: 10px 0 10px 31px;}
      .layui-form-item{margin: 0; line-height: 45px;}
      .us-btn{background-color: #FFF; color:#FF5722; font-weight: 500}
      .layui-form-item .layui-form-label{margin-top:10px;}
      .layui-row{border-radius: 3px;}
    </style>
</head>

<body style="background-color: rgba(240,240,240,.3);margin-top:155px">
  <div class="layui-container">
    <form class="layui-form" action="./login.php">
  <div class="layui-row" style="border:1px solid #d2d2d2; background-color: #FFF; margin-bottom:15px;">
    <div class="layui-col-xs12">
        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                <input type="text" name="phone" id="phone" required lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item"  style="border-top:1px solid #F0F0F0">
          <div class="layui-input-inline us-input-inline" style=" border-right:1px solid #F0F0F0">
                <input type="text" name="password" required lay-verify="required" placeholder="请输入手机验证码" autocomplete="off" class="layui-input">
          </div>
            <button type="button" name="getVerify" id="getVerify" class="layui-btn us-btn">获取验证码</button>
        </div>
  </div>
</div>
<div class="layui-row">
<button class="layui-btn" lay-submit lay-filter="formDemo" style="width:100%; background-color: #FF5722;">登 陆</button>
<input type="hidden" name="logintype" value='login' />
</div>
</form>
</div>
    <!-- <div id="pwdLogin">
        <form class="layui-form" action="./login.php">
            <div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" id="phone" required lay-verify="required" placeholder="手机号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                    <input type="text" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">也可以用微信、支付宝登录</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">登录</button>
                    <input type="hidden" name="login" value='1' />
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
                <div class="layui-input-block">
                    <button class="layui-btn" lay-filter="formDemo">忘记密码</button>
                    <span type="button" class="layui-btn" id="showShortLogin">短信登录</span>
                    <input type="hidden" name="logintype" value='login' />
                    <a type="reset" class="layui-btn layui-btn-primary" href="./login.php?pagetype=register">注册</a>
                </div>
            </div>
        </form>
    </div> -->
    <div id="shortLogin" style="display: none;">
        <form class="layui-form" action="./login.php">
            <div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" id="shortPhone" required lay-verify="required" placeholder="手机号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                    <input type="text" name="code" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">登录</button>
                    <input type="hidden" name="login" value='1' />
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <button type="button" name="getVerify" id="getVerify" class="layui-btn">获取验证码</button>
                </div>
                <div class="layui-input-block">
                    <button class="layui-btn" lay-filter="formDemo" id="showPwdLogin">密码登录</button>
                    <input type="hidden" name="logintype" value='shortLogin' />
                    <a type="reset" class="layui-btn layui-btn-primary" href="./login.php?pagetype=register">注册</a>
                </div>
            </div>
        </form>
    </div>
    <script>
    $("#showPwdLogin").bind("click", function() {
        $("#shortLogin").hide();
        $("#pwdLogin").show()();
    })
    $("#showShortLogin").bind("click", function() {
        $("#shortLogin").show();
        $("#pwdLogin").hide();
    })
    $("#getVerify").bind("click", function() {
        var phone = $("#shortPhone").val();
        phone = phone.replace(/(^\s+)|(\s+)|(\s+$)/g, "");
        if (!phone) {
            alert("请填写手机号");
            return;
        }
        var data = { phone: phone, type: "code" }
        $.post("./login.php", data, function(result) {
            console.log(result);
            countDown = 60;
            setTime();
        })
    })
    var countDown;

    function setTime() {
        // alert("dff");
        if (countDown == 0) {
            $("#getVerify").html("获取验证码");
            $("#getVerify").attr("disabled", false);
        } else {
            $("#getVerify").html("重新发送" + countDown);
            $("#getVerify").attr("disabled", true);
            countDown--;
            setTimeout(function() {
                setTime();
            }, 1000);
        }
    }
    </script>
</body>

</html>
