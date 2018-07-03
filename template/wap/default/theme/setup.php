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
        .catalog{margin-left:15px;width:80px;display: block;float:left;}
        .catalogInfo{margin-left:30px;float:left;}
        .changeButton{float: left;margin-left:15px;color:#e44242;font-size:11px;}
        .initial{border:0;margin:0;padding:0;}
        fieldset{width:100%;height:37px;;line-height:37px;border-top: 1px solid #e8e5e5;background-color:#f3e8e8}
        fieldset label{width:87px;display:block;float:left;}
        fieldset input{margin-left:35px;width:130px;border:0;display:block;float:left;margin-top:10px;}
    </style>
</head>
<body>
    <div id="setup" >
        <div class="layui-main" style="height:20px;width:100%;"><a href="./my.php">返回</a></div>
        <div class="layui-colla-item" >
            <div style="height:20px"></div>
            <h2 class="layui-colla-title" onclick="userInfo()">账户安全设置</h2>
        </div>
        <div style="height:60px"></div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">地理位置设置</h2>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">关于我们</h2>
        </div>
        <div style="height:60px"></div>
        <div class="layui-colla-item"> 
            <h2 class="layui-colla-title" id="signOut">退出</h2>
        </div>
    </div>
    <div id="userInfo" style="display: none">
        <div class="layui-main" style="height:20px;width:100%;"><a onclick="setup()">返回</a></div>
        <div class="layui-colla-item" >
            <div style="height:20px"></div>
            <h2 class="layui-colla-title" >账户安全设置</h2>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">昵称：</span>
            <span class="catalogInfo"><?php echo $userInfo['name']?></span>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">手机号：</span>
            <span class="catalogInfo"><?php echo $userInfo['phone']?></span>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">微信号：</span>
            <span class="catalogInfo""><?php echo !empty($userInfo['wx_openid']) ? $userInfo['wx_openid'] : "未绑定微信号"?></span>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">支付宝号：</span>
            <span class="catalogInfo"><?php echo !empty($userInfo['ali_openid']) ? $userInfo['ali_openid'] : "未绑定支付宝"?></span>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">登录密码：</span>
            <span class="catalogInfo"><?php echo !empty($userInfo['upwd']) ? "*****" : "未设置登录密码"?></span>
            <span class="changeButton" id="changePwdButton">修改</span>
        </div>
        <div style="width:100%;height:37px;background-color:#f5f2f2;line-height:37px;border-top: 1px solid #e8e5e5;">
            <span class="catalog">支付密码：</span>
            <span class="catalogInfo"><?php echo !empty($userInfo['pay_password']) ? "*****" : "未设置支付密码"?></span>
            <span class="changeButton" id="changePayButton">修改</span>
        </div>
    </div>
    <div id="changePwd" style="display: none;z-index: 10px;position:fixed;top:40px;">
        <div style="width:350px;height:260px; background-color: #f3e8e8;margin: 100px auto;">
            <form style="width:280px;margin:auto;padding-top:20px;" name="changePwd" action="javascript:;">
                <fieldset class="initial" >
                    <label>手机号：</label>
                    <input type="text" name="phone" id='phone' disabled="disabled" value="<?php echo $phone;?>" />
                </fieldset>
                <fieldset class="initial">
                    <label id='payPwd'>新密码：</label>
                    <input type="password" name="pwd" id="pwd" value="" />
                </fieldset>
                <fieldset class="initial">
                    <label>短信验证码：</label>
                    <input type="text" name="code" id="code" value="" />
                    <span id="check"></span>
                </fieldset>
                <div>
                    <input type="submit" name="submit" value="提交"/>
                    <input type="reset" name="reset" value="重置"/>
                    <input type="button" name="button" id="verify" value="获取验证码"/>
                    <input type="hidden" name="hidden" id="getcode" value=""/>
                    <span id="cancel" style="width:66px;height: 30px;line-height: 30px;text-align: center;background-color:red;display: block;">取消</span>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
function userInfo(){
    $("#setup").hide();
    $("#userInfo").show();
}
function setup(){
    $("#userInfo").hide();
    $("#setup").show();
}
$(function(){
    $("#cancel").bind("click",function(){
        $("#changePwd").hide();
    })
    $("#changePwdButton").bind("click",function(){
        $("#changePwd").show();
    })
    $("#changePayButton").bind("click",function(){
        $("#payPwd").html("支付密码：");
        $("#pwd").attr("name","payPwd");
        $("#changePwd").show();
    })
    // 获取验证码
    $("#verify").bind("click",function(){
        if(!$("#pwd").val()) return;
        var phone = $("#phone").val();
        var data = {phone:phone,type:"verify"}
        $.post("./my.php",data,function(result){
            var result = JSON.parse(result);
            console.log(result);
            if(result['messageRes']){
                alert("验证码已发送");
                $('#getcode').val(result['code']);
            }else{
                alert("请不要频繁操作");
            }
        })
    })
    // 验证码校验
    $("#code").keyup(function(){
        var code = $("#code").val();
        var getCode = $("#getcode").val();
        if(getCode.length == code.length && getCode == code) $("#check").html("正确");
        else $("#check").html("错误");
    })
    // 表单提交
    $("input[name='submit']").bind("click",function(){
        var pwdType = $("#pwd").attr('name');
        var phone = $("#phone").val();
        var pwd = $("#pwd").val();
        var code = $("#code").val();
        if(pwdType == "payPwd") type = "checkPayPwd";
        else type = "checkPwd";
        var data = {phone:phone,pwd:pwd,code:code,type:type};
        $.post("./my.php",data,function(result){
            if(result){
                alert("密码修改成功");
                if(pwdType == "payPwd") $("#changePwd").hide();
                else window.location.href = "./login.php";
            }else{
                alert("密码修改失败");
            }
        })
    });
    //退出登录
    $("#signOut").bind("click",function(){
        var phone = <?php echo $phone;?>;
        $.post("./login.php",{phone:phone,type:"signOut"},function(result){
            if(result){
                window.location.href = "./login.php";
            }
        })
    })
})
</script>