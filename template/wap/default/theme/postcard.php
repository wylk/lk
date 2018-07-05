<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .uploadImg {display:none;float:right;margin-right:24px}
        .uploadImg img{width:62px}
        .layui-form-label{width:95px;}
        .layui-input-block{width:200px;margin-left: 130px;}
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i class="iconfont" style="font-size: 30px;">&#xe697;</i>
    <h1 class="lk-title">导航栏</h1>
</header>
<div class="lk-content">
    <span><i>注</i>普通用户无需认证 发VIP1/VIP2请完成认证</span>
<<<<<<< HEAD
<div class="layui-tab layui-tab-card" lay-filter>
    <ul class="layui-tab-title">
        <li class="layui-this">个人认证</li>
        <li>企业认证</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <form class="layui-form">
                <input type="hidden" name="type" value="0">
                <div class='layui-form-item'>
                    <label class="layui-form-label">姓名：</label>
                    <div class="layui-input-block">
                    <input type="text" class='layui-input' name="name" required lay-verify='required' value="" placeholder="真实姓名" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">身份证号：</label>
                    <div class="layui-input-block">
                    <input type="text" class='layui-input' name="postcard" required lay-verify='required|number' value="" placeholder="身份证号" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">身份证正面：</label>
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn upload" id="upload_1">
                        <i class="layui-icon">&#xe67c;</i>
                    </button>
                    <div id="uploadImg_1" class='uploadImg' >
                        <img  src="" />
                        <input type="hidden" name="uploadImg_1" value="">
                    </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">身份证反面：</label>
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn upload" id="upload_2">
                        <i class="layui-icon">&#xe67c;</i>
                    </button>
                    <div id="uploadImg_2" class='uploadImg' >
                        <img  src="" />
                        <input type="hidden" name="uploadImg_2" value="">
                    </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">手持身份证：</label>
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn upload" id="upload_3">
                        <i class="layui-icon">&#xe67c;</i>
                    </button>
                    <div id="uploadImg_3" class='uploadImg' >
                        <img  src="" />
                        <input type="hidden" name="uploadImg_3" value="">
                    </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <div class="layui-input-block">
                        <button type="submit" lay-submit class='layui-btn' lay-filter="formPerson">提交</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="layui-tab-item">
            <form class="layui-form">
                <input type="hidden" name="type" value="1">
                <div class='layui-form-item'>
                    <label class="layui-form-label">企业名称：</label>
                    <div class="layui-input-block">
                    <input type="text" class='layui-input' name="enterprise" required lay-verify='required' value="" placeholder="企业名称" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">法人姓名：</label>
                    <div class="layui-input-block">
                    <input type="text" class='layui-input' name="name" required lay-verify='required' value="" placeholder="法人姓名" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">营业执照号：</label>
                    <div class="layui-input-block">
                    <input type="text" class='layui-input' name="businessLicense" required lay-verify='required|number' value="" placeholder="营业执照号" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">营业执照：</label>
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn" id="upload_business">
                        <i class="layui-icon">&#xe67c;</i>
                    </button>
                    <div id="uploadBusiness" class='uploadImg' >
                        <img  src="" />
                        <input type="hidden" name="uploadBusiness" value="">
                    </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <div class="layui-input-block">
                        <button type="submit" lay-submit class='layui-btn' lay-filter="formBusiness">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
=======
<form class="layui-form" action="">
    <input type="hidden" name="pagetype" value="<?php echo $pagetype; ?>">
    <div class="input-m"><?php echo $htmlRes;?></div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="add">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary" >重置</button>
    </div>
  </div>
</form>
>>>>>>> b241a5d90bfacebcbbd571fcdce6b513f619d0e2
</div>
   
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
    layui.use(["element","upload","layer",'form'],function(){
        var element = layui.element;
        var upload = layui.upload;
        var layer = layui.layer;
        var form = layui.form;

        var uploadInst1 = upload.render({
            elem : "#upload_1",
            url : "my.php?type=uploadFile",
            before :  function(){
                layer.load();
            },
            done : function(res,index,upload){
                layer.closeAll("loading");
                console.log(index);
                console.log(upload);
                if(!res.res){
                    $("#uploadImg_1 img").attr("src",res.msg);
                    $("#uploadImg_1 input").val(res.msg);
                    $("#uploadImg_1").show();
                }
            },
            error:function(){
            }
        });
        var uploadInst2 = upload.render({
            elem : "#upload_2",
            url : "my.php?type=uploadFile",
            before :  function(){
                layer.load();
            },
            done : function(res,index,upload){
                layer.closeAll("loading");
                console.log(res);
                console.log(res.res);
                if(!res.res){
                    $("#uploadImg_2 img").attr("src",res.msg);
                    $("#uploadImg_2 input").val(res.msg);
                    $("#uploadImg_2").show();
                }
            },
            error:function(){
            }
        });
        var uploadInst3 = upload.render({
            elem : "#upload_3",
            url : "my.php?type=uploadFile",
            before :  function(){
                layer.load();
            },
            done : function(res,index,upload){
                layer.closeAll("loading");
                console.log(res);
                if(!res.res){
                    $("#uploadImg_3 img").attr("src",res.msg);
                    $("#uploadImg_3 input").val(res.msg);
                    $("#uploadImg_3").show();
                }
            },
            error:function(){
            }
        });
        var uploadInst3 = upload.render({
            elem : "#upload_business",
            url : "my.php?type=uploadFile",
            before :  function(){
                layer.load();
            },
            done : function(res,index,upload){
                layer.closeAll("loading");
                console.log(res);
                if(!res.res){
                    $("#uploadBusiness img").attr("src",res.msg);
                    $("#uploadBusiness input").val(res.msg);
                    $("#uploadBusiness").show();
                }
            },
            error:function(){
            }
        });
        form.on("submit(formPerson)",function(data){
            console.log(data);
            $.post("./my.php?pagetype=postcardBackstage",data.field,function(result){
                console.log(result);
                if(!result.res){
                    layer.msg(result.msg,{icon:1,skin:"demo-class"})
                }else{
                    layer.msg(result.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
            return false;
        })
    })
</script>
</html>
