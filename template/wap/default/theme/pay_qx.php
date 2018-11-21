<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>支付绑定</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>LUploader/css/LUploader.css?r=2321">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <script src="<?php echo STATIC_URL;?>LUploader/js/LUploader.js?r=32443345"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style type="text/css">
        *{
            margin: 0px;
            padding: 0px;
        }
        html,body{
           /*  height: 100%; */
            background-color:#f2f2f2;
            color: #999;
        }
        .line{margin: 5px 15px;}
        input[type=text],input[type=password]{
            width: 60%;
            line-height: 21px;
            height: 40px;
            border: 1px solid rgba(0, 0, 0, .2);
            outline: 0;
            border:0;
            -webkit-appearance: none;
            margin: 0px;
            font-size: 14px;
        }
        .line-head{
            background-color: #fff;
            padding-bottom: 15px;
        }
        .pay_type{
            margin: 0px 15px;
            border-bottom: 1px solid #f0f0f0;
            line-height: 45px;
            color: #333;
        }
        .wrapper{
            background-color: #fff;
            height: 155px;
            margin-top: 10px;
        }
        h5{color: #333;text-align: center;font-size: 14px;line-height: 30px;}
        .wrapper_cent{height:100px;width: 65%;margin: 5px auto;}
        .foot{
            height: 80px;
            width: 100%;
            margin-top: 20px;
            background: #fff;
        }
        button{
            font-size: 18px;
            color: #29aee7;
            width: 90%;
            height: 40px;
            border-radius: 5px;
            border: 1px solid #29aee7;
            margin: 20px;
        }
        
      
    </style>
</head>

<body>
<div class="content">
    <div class="line" style="font-size: 14px;">必须是本人的<?php echo ($tex=='2')?'支付宝':'微信';?>账号</div>
    <div class="line-head">
         <div class="pay_type">真实姓名:<input name="name" type="text" value="<?php echo $pay_img["name"];?>" placeholder="请输入真实姓名"></div>
        <div class="pay_type">     
            <?php if($tex=='2'){?>
                  支付宝号:<input id="zf" type="text" value="<?php if($post_type=='save'){echo $pay_img["account"];} ?>"  placeholder="请输入支付宝账号">
            <?php }else{?>
                  微信账号:<input id="zf" type="text" value="<?php if($post_type=='save'){echo $pay_img["account"];} ?>"  placeholder="请输入微信账号">
            <?php } ?>
        </div>
        <div class="pay_type">支付密码:<input id="paw" type="password" value="" placeholder="请输入支付密码"></div>
    </div>

    
    <div class="wrapper">
        <h5>收款二维码</h5>
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
    <div class="foot">
        
        <button  class="sub">提交</button>
    </div>
</div>
    <?php //include display('public_menu');?>
</body>


</html>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
    var type=<?php echo $tex ?>;
    var post_type = '<?=$post_type;?>';
    if(post_type  == 'save'){
        var id = '<?=$pay_img['id'];?>'
    }

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
        var pay_num=$('#zf').val();
        var password=$('#paw').val();
        var pay_img=$("input[name='up_img']").val();
        var name=$("input[name='name']").val();
        if(pay_num.length < 1){
            mui.toast('请输入真实姓名');return;
        }
        if(pay_num.length < 5){
            mui.toast('请输入正确的账号');return;
        }
        if(password.length != 6){
            mui.toast('请输入正确支付密码');return;
        }

        if(pay_img.length < 1){
            mui.toast('请上传收款二维码！');return;
        }
        var data = {}
        data.pay_num = pay_num;
        data.password = password;
        data.type = type;
        data.pay_img = pay_img;
        data.name = name;
        data.post_type = post_type;
        if(post_type == 'save'){
            data.id = id;
        }

        $.post("./pay_xq.php",data, function(res) {
            console.log(res)
            if(res.res == 0){ 
                mui.toast(res.msg);
                setTimeout(function(){
                    window.history.go(-3);
                },2000);
            }else if(res.res == 3){
                mui.toast(res.msg);
                setTimeout(function(){
                    window.location.href = "<?=$referer_url;?>";
                },2000)
            }else{
                mui.toast(res.msg);
            }
        },'json');
    });
</script>
