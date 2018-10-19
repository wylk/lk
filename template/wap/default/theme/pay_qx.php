
<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>支付密码</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lines{width: 90%;margin: 50px auto;}
        h6{color: red;margin-top: 26px;font-size: 16px;margin-left: 23px;}
        h3{font-size: 17px;margin-top: 29px;margin-left: 39px;}
        .pwd{font-size: 17px;margin-top: 29px;margin-left: 39px;}
        h4{color: red;margin-top: 73px;text-align: center;font-size: 16px;}
        h5{color: red;margin-top: 73px;text-align: center;font-size: 16px;}
        button{font-size: 19px;color: #1d0b03f2;width: 94%;height: 46px;margin-left: 2%;margin-top: 37px;background-color: #fdd261;border-radius: 8px;}
        .button{font-size: 15px;color: #1d0b03f2;width: 26%;height: 32px;margin-left: -2%;margin-top: 5px;background-color: #f39208;border-radius: 8px;}
        .uploadImg img{width: 86%;margin-left: -39px;}
        #upload_1{border: 1px solid #ec4104;background-color: #fff;color: #f77b0e;margin-left: 47px;}
        .zf{border: 1px solid #efd115;width: 53%;margin-left: 37px;height: 38px;}
        .phone{border: 1px solid #efd115;width: 53%;margin-left: 70px;height: 38px;}
        .psd{border: 1px solid #efd115;width: 53%;margin-left: 45px;height: 38px;}
        .password{border: 1px solid #efd115;width: 53%;margin-left: 21px;height: 38px;}

    </style>
     <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
     <script type="text/javascript">
        $(function(){
            lk.is_weixin() && function(){
                $('.lk-bar-nav').css('display','none');
                $('.lk-content').css({"padding":"0px"});
            }()
        })
    </script>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">
        <?php if($tex=='1'){?>修改银行卡
        <?php }else if($tex=='2'){?>
             修改支付宝
        <?php }else{?>
             修改微信
        <?php } ?>
        </h1>
    </header>
<div class="lk-content">
            <?php if($tex=='1'){?>
                   <h6>必须是本人的银行卡</h6>
            <?php }else if($tex=='2'){?>
                  <h6>必须是本人的支付宝账号</h6>
            <?php }else{?>
                  <h6>必须是本人的微信账号</h6>
            <?php } ?>
            <div class="num">
                <?php if($tex=='1'){?>
                       <h3>银行卡卡号:<input type="text" value=""></h3>
                <?php }else if($tex=='2'){?>
                      <h3>支付宝账号:<input type="text" value="" class="zf"></h3>
                <?php }else{?>
                      <h3>微信账号:<input type="text" value=""></h3>
                <?php } ?>
            </div>
       <!--  <div class="pwd">手机号:<input type="text" value="" class="phone"></div>
        <div class="pwd">
            <button class="button" id="getVerify">获取验证码</button>
            <input type="" name="" class="psd">
        </div> -->
        <div class="pwd">乐卡支付密码:<input type="password" class="password"></div>
        <h4>点击下方上传收款二维码</h4>
        <div class="wrapper">
            <div class="layui-input-block img-block">
                <a href="javascript:;" type="button" class="layui-btn layui-btn-primary upload" id="upload_1">
                <i class="layui-icon">&#xe654;</i>
                </a>
                <div id="uploadImg_1" class='uploadImg'>
                     <img src="" />
                </div>
            </div>
        </div>
        <div>
              <h1 class="lk-title">
                <?php if($tex=='1'){?>
                      <h5>请拍摄银行卡正面,必须是能看清卡号的哦~上传即可</h5>
                <?php }else if($tex=='2'){?>
                     <h5>打开支付宝app,在首页打开收钱，打开个人收款二维码,保存图片上传即可</h5>
                <?php }else{?>
                      <h5>打开微信app,点击+号,打开收付款,选择收款,保存图片上传即可</h5>
                <?php } ?>
              </h1>

        </div>
                <button  class="sub">提交</button>
</div>
    <?php include display('public_menu');?>
</body>


</html>
<script type="text/javascript">
    $('.sub').click(function(){
        var pay_num=$('.zf').val();
        var password=$('.password').val();
         $.post("./pay_xq.php",{pay_num:pay_num,password:password}, function(res) {
         console.log(res)
         if(res.res == 0){
            alert(res.msg)
            window.location.href = "http://lk.com/wap/my.php";
          }else{
            alert(res.msg)
          }
        },'json');
    })
        // 获取验证码
        $("#getVerify").bind("click", function() {
            var phone = $(".phone").val();
            phoneReg = /^1([0-9]{10})$/;
            if (!phoneReg.test(phone)) {
                alert("请正确填写手机号");
                return ;
            }
            alert("验证密码已发送");
            var data = { phone: phone, type: "code" }
            $.post("./pay_xq.php", data, function(data) {
                console.log(data)
            },'json');
        })
        layui.use(["element", "upload", "layer", 'form'], function() {
                var element = layui.element;
                var upload = layui.upload;
                var layer = layui.layer;
                var form = layui.form;
                var uploadInst1 = upload.render({
                elem: "#upload_1",
                url: "pay_xq.php?type=uploadFile",
                before: function() {
                    layer.load();
                },
                done: function(res, index, upload) {
                    layer.closeAll("loading");
                    console.log(index);
                    console.log(upload);
                    if (!res.res) {
                        $("#uploadImg_1 img").attr("src", res.msg);
                        $("#uploadImg_1 input").val(res.msg);
                        $("#uploadImg_1").show();
                    }
                },
                error: function() {}
            });

        })

</script>
