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
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>LUploader/css/LUploader.css?r=2321">
    <script src="<?php echo STATIC_URL;?>LUploader/js/LUploader.js?r=32443345"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        body{background: white}
        .lines{width: 90%;margin: 50px auto;}
        h6{color:#737e82;margin-top: 26px;font-size: 16px;margin-left: 23px;}
        h3{font-size: 17px;margin-top: 29px;margin-left: 30px;}
        h4{color: #737e82;;margin-top: 25px;text-align: center;font-size: 16px;}
        button{font-size: 19px;color: white;width: 94%;height: 46px;margin-left: 2%;margin-top: 51px;background-color: #168fbb;border-radius: 8px;border:0px;}
        .uploadImg img{width: 23%;margin-left: 48px;width: 40%;height: 100px;border:1px solid #000;}
        #upload_1{border: 4px solid  #168fbb;background-color: #fff;color: #06179c;margin-left: 47px;}
        .wrapper_cent{height:100px;width: 230px;margin: 14px auto;}

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
                       <h3>银行卡卡号:<input type="text" value="" style="border-style: none;border-bottom-style: solid;border-bottom-width: 2px;border-bottom-color: #168fbb;height: 47px;margin-left: 19px;width: 54%;"></h3>
                <?php }else if($tex=='2'){?>
                      <h3>支付宝账号:<input type="text" value="" class="zf" style="border-style: none;border-bottom-style: solid;border-bottom-width: 2px;border-bottom-color: #168fbb;height: 47px;margin-left: 19px;width: 54%;"></h3>
                <?php }else{?>
                      <h3>微信账号:<input type="text" value="" style="border-style: none;border-bottom-style: solid;border-bottom-width: 2px;border-bottom-color: #168fbb;height: 47px;margin-left: 19px;width: 54%;"></h3>
                <?php } ?>
            </div>
        <div><h3>乐卡支付密码:<input type="password" class="password" style="border-style: none;border-bottom-style: solid;border-bottom-width: 2px;border-bottom-color: #168fbb;height: 47px;margin-left: 2px;width: 54%;"></h3></div>
        <h4>收款二维码</h4>
        <div class="wrapper">
            <div class="wrapper_cent">
                <div class="LUploader" id="up_img">
                    <div class="LUploader-container">
                        <input data-LUploader="up_img" data-form-file='basestr' data-upload-type='front' type="file" />
                        <ul class="LUploader-list"></ul>
                    </div>
                    <div>
                        <div class="icon icon-camera font20"></div>
                        <p>单击上传</p>
                    </div>
                </div>
            </div>
        </div>
                <button  class="sub">提交</button>
</div>
    <?php include display('public_menu');?>
</body>


</html>
<script type="text/javascript">

 [].slice.call(document.querySelectorAll('input[data-LUploader]')).forEach(function(el) {
        new LUploader(el, {
            url: './upload.php',//post请求地址
            multiple: false,//是否一次上传多个文件 默认false
            maxsize: 102400,//忽略压缩操作的文件体积上限 默认100kb
            accept: 'image/*',//可上传的图片类型
            quality: 0.5,//压缩比 默认0.1  范围0.1-1.0 越小压缩率越大
            //showsize:true//是否显示原始文件大小 默认false
        });
    });

   $('.sub').click(function(){
        var pay_num=$('.zf').val();
        var type=<?php echo $tex ?>;
        var password=$('.password').val();
        var pay_img=$("input[name='up_img']").val();
         $.post("./pay_xq.php",{pay_num:pay_num,password:password,type:type,pay_img:pay_img}, function(res) {
         console.log(res)
         if(res.res == 0){
            alert(res.msg)
<<<<<<< HEAD
            window.location.href = "http://lk.com/wap/my.php";
=======
            window.location.href = "<?php echo $config['site_url']?>/wap/my.php";
          }else{
            alert(res.msg)
>>>>>>> 32c5ff56cc2c8d7663de30dd1e87fc4f4b1ee396
          }
        },'json');
    });
</script>
