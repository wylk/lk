<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>认证</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
    html,body{
        background-color: #fff;
    }
/*     .layui-container p{ line-height: 35px;} */
    .layui-container p i { color: red; margin-right: 10px;}
    .layui-tab-content { height: auto}
    .uploadImg { position: absolute; top:0;right: 0;width: 150px;  height: 95px; overflow: hidden;}
    .layui-btn {width:40px; height:40px;line-height:40px; border:1px dashed;padding:0;}
    .layui-btn .layui-icon{font-size:22px;}
    .uploadImg img {width: 100%; height:100%;}
    .layui-form-item .layui-form-label{position: relative;width: 84px; padding-right: 8px}
    .layui-btn-warm{
        width:100%;
        height:35px;
        line-height: 35px;
        border:0; 
        position: relative;
        left: -45px;
        background: #fff;
        color: #00adff;
        border: 1px solid #00adff;
        border-radius: 5px;
     }
    .layui-input-block { width: 200px; margin-left: 110px;}
    .hidden { display: none;}
    .cardBody { width: 100%; margin-top: 46px; text-align: center;}
    .img-block{height: 95px}
    .layui-tab-brief>.layui-tab-title{
        color: #999;
    }
    .layui-tab-brief>.layui-tab-title .layui-this{
        color: #333;
    }

    .layui-tab-brief>.layui-tab-more li.layui-this:after, .layui-tab-brief>.layui-tab-title .layui-this:after{
        border-bottom: 1px solid #29aee7;
    }
    .lk-content{
        color: #555;
        margin-bottom: 0px;
    }
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
        <h1 class="lk-title">认 证</h1>
    </header>
    <div class="lk-content">
        <?php if(empty($type)){?>
        <div class="layui-container">
            <p style="font-size: 12px;margin-top: 8px;"><i>注:</i>普通用户无需认证 发VIP1/VIP2请完成认证</p>
            <hr>
        </div>
        <?php }?>
        <div class="layui-container">
            <p style="margin-top: 8px;">&nbsp;&nbsp;&nbsp;&nbsp;认证状态：<font style="color: #b37272">
                <?php
                if($audit['status']==1) echo "恭喜您，通过认证";
                elseif($audit['status']==2) echo "未通过，查看驳回原因，修改后重新提交。";
                elseif($audit['status']=="0") echo  "审核中，请耐心等待...";
                else echo "请添加您的信息";
                ?> </font>
            </p>
            <hr>
        </div>
        
        <div class="layui-container">
            <div class="layui-tab layui-tab-brief" lay-filter="aduitTab">
                <ul class="layui-tab-title">
                    <li class="<?php echo ($type==1 || empty($type)) ? "layui-this" : " "?>">个人认证</li>
                    <li class="<?php echo $type==2 ? " layui-this" : " "?>">店铺认证</li>
                    <li class="<?php echo $type==3 ? " layui-this" : " "?>">企业认证</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item <?php echo (empty($type) || $type ==1 )? "layui-show" : ""?>">
                     <?php if(!empty($type) && $type !=1){ echo "<p class='cardBody'>您已选择其他认证，不能再进行个人认证!</p>";}?>
                        <form class='layui-form <?php if( !empty($type) && $type != 1 ){ echo 'hidden';}?>'>
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="status" value="<?php echo isset($audit['status']) ? $audit['status'] : ""?>">
                        <div class='layui-form-item'>
                            <label class="layui-form-label">姓名：</label>
                            <div class="layui-input-block">
                                <input type="text" class='layui-input' name="name" required lay-verify='name' value="<?php echo isset($audit['name']) ? $audit['name'] : " "?>" placeholder="真实姓名" />
                            </div>
                        </div>
                        <div class='layui-form-item'>
                            <label class="layui-form-label">身份证号：</label>
                            <div class="layui-input-block">
                                <input type="text" class='layui-input' name="postcard" required lay-verify='postcard' value="<?php echo isset($audit['postcards']) ? $audit['postcards'] : " "?>" placeholder="身份证号" />
                            </div>
                        </div>

                        <div class='layui-form-item'>
                            <label class="layui-form-label">身份证正面：</label>
                            <div class="layui-input-block img-block">
                                <a href="javascript:;" type="button" class="layui-btn layui-btn-primary upload" id="upload_1">
                                    <i class="layui-icon">&#xe654;</i>
                                </a>
                                <div id="uploadImg_1" class='uploadImg'>
                                    <img src="<?php echo isset($audit['img_just']) ? $audit['img_just'] : " "?>" />
                                    <input type="hidden" name="uploadImg_1" value="<?php echo isset($audit['img_just']) ? $audit['img_just'] : " "?>">
                                </div>
                            </div>
                        </div>
                        <div class='layui-form-item'>
                            <label class="layui-form-label">身份证反面：</label>
                            <div class="layui-input-block img-block">
                                <a href="javascript:;" type="button" class="layui-btn layui-btn-primary upload" id="upload_2">
                                    <i class="layui-icon">&#xe654;</i>
                                </a>
                                <div id="uploadImg_2" class='uploadImg'>
                                    <img src="<?php echo isset($audit['img_back']) ? $audit['img_back'] : " "?>" />
                                    <input type="hidden" name="uploadImg_2" value="<?php echo isset($audit['img_back']) ? $audit['img_back'] : " "?>">
                                </div>
                            </div>
                        </div>
                        <div class='layui-form-item'>
                            <label class="layui-form-label">手持身份证：</label>
                            <div class="layui-input-block img-block">
                                <a href="javascript:;" type="button" class="layui-btn layui-btn-primary upload" id="upload_3">
                                    <i class="layui-icon">&#xe654;</i>
                                </a>
                                <div id="uploadImg_3" class='uploadImg'>
                                    <img src="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>" />
                                    <input type="hidden" name="uploadImg_3" value="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>">
                                </div>
                            </div>
                        </div>
                        <?php echo (isset($audit['status']) && $audit['status'] == 2 ) ? "<div class='layui-form-item'>" : "<div class='layui-form-item hidden'>"?>
                        <label class="layui-form-label">驳回原因：</label>
                        <div class="layui-input-block">
                            <div class="layui-textarea">
                                <?php echo isset($audit['remarks']) ? $audit['remarks'] : ""?>
                            </div>
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <div class="layui-input-block">
                            <button lay-submit class='layui-btn layui-btn-warm ' lay-filter='formPerson'>提交</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php echo ($type ==2 ) ? " layui-show " : " "?>">
                   <?php if(!empty($type) && $type !=2){ echo "<p class='cardBody'>您已选择其他认证，不能再进行个人认证!</p>";}?>
                    <form class='layui-form <?php if( !empty($type) && $type != 2 ){ echo 'hidden';}?>'>
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="status" value="<?php echo isset($audit['status']) ? $audit['status'] : " "?>">
                    <div class='layui-form-item'>
                        <label class="layui-form-label">店铺名称：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="enterprise" required lay-verify='enterprise' value="<?php echo isset($audit['enterprise']) ? $audit['enterprise'] : " "?>" placeholder="店铺名称" />
                        </div>
                    </div>
                    <div class='layui-form-item'>
                            <label class="layui-form-label">店铺类型：</label>
                            <div class="layui-input-block">
                                <?php if($name){?>
                                     <select name="shopclass" >
                                            <option  selected><?php echo  $name ?></option>
                                     </select>
                                <?php }else{?>
                                     <select name="shopclass" >
                                     <option>请选择</option>
                                     <?php foreach ($res as $key => $value) {?>
                                            <option   value="<?php echo $value['id'] ?>"><?php echo  $value['name'] ?></option>
                                    <?php  } ?>

                                 </select>
                                <?php } ?>

                            </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">法人姓名：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="name" required lay-verify='name' value="<?php echo isset($audit['name']) ? $audit['name'] : " "?>" placeholder="法人姓名" />
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">营业执照号：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="businessLicense" required lay-verify='busiNumber' value="<?php echo isset($audit['business_img']) ? $audit['business_license'] : " "?>" placeholder="营业执照号" />
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">店铺logo：</label>
                        <div class="layui-input-block img-block">
                            <a type="button" class="layui-btn layui-btn-primary" id="upload_shop_logo">
                                <i class="layui-icon">&#xe654;</i>
                            </a>
                            <div id="upload_shop_logo" class='uploadImg'>
                                <img src="<?php echo isset($audit['logo']) ? $audit['logo'] : " "?>" />
                                <input type="hidden" name="logo" value="<?php echo isset($audit['logo']) ? $audit['logo'] : " "?>">
                            </div>
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">营业执照：</label>
                        <div class="layui-input-block img-block">
                            <a type="button" class="layui-btn layui-btn-primary" id="upload_business">
                                <i class="layui-icon">&#xe654;</i>
                            </a>
                            <div id="uploadBusiness" class='uploadImg'>
                                <img src="<?php echo isset($audit['business_img']) ? $audit['business_img'] : " "?>" />
                                <input type="hidden" name="uploadBusiness" value="<?php echo isset($audit['business_img']) ? $audit['business_img'] : " "?>">
                            </div>
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">手持身份证：</label>
                        <div class="layui-input-block img-block">
                            <a type="button" class="layui-btn layui-btn-primary" id="upload_oneself">
                                <i class="layui-icon">&#xe654;</i>
                            </a>
                            <div id="uploadOneself" class='uploadImg'>
                                <img src="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>" />
                                <input type="hidden" name="uploadImg_3" value="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>">
                            </div>
                        </div>
                    </div>

                    <?php echo (isset($audit['status']) && $audit['status'] == 2 ) ? "<div class='layui-form-item'>" : "<div class='layui-form-item hidden'>"?>
                    <label class="layui-form-label">驳回原因：</label>
                    <div class="layui-input-block">
                        <div class="layui-textarea">
                            <?php echo isset($audit['remarks']) ? $audit['remarks'] : ""?>
                        </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <div class="layui-input-block">
                        <button type='submit' lay-submit class='layui-btn layui-btn-warm ' lay-filter='formBusiness'>提交</button>
                    </div>
                </div>
                </form>

            </div>
            <!-- 企业 -->
             <div class="layui-tab-item <?php echo ( $type ==3 ) ? " layui-show " : " "?>">
                <?php if(!empty($type) && $type !=3){ echo "<p class='cardBody'>您已选择其他认证，不能再进行个人认证!</p>";}?>
              <form class='layui-form <?php if(!empty($type) && $type != 3){ echo 'hidden';}?>'>
                <input type="hidden" name="type" value="3">
                <input type="hidden" name="status" value="<?php echo isset($audit['status']) ? $audit['status'] : " "?>">
                <div class='layui-form-item'>
                    <label class="layui-form-label">企业名称：</label>
                    <div class="layui-input-block">
                        <input type="text" class='layui-input' name="enterprise" required lay-verify='enterprise' value="<?php echo isset($audit['enterprise']) ? $audit['enterprise'] : " "?>" placeholder="企业名称" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">法人姓名：</label>
                    <div class="layui-input-block">
                        <input type="text" class='layui-input' name="name" required lay-verify='name' value="<?php echo isset($audit['name']) ? $audit['name'] : " "?>" placeholder="法人姓名" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">营业执照号：</label>
                    <div class="layui-input-block">
                        <input type="text" class='layui-input' name="businessLicense" required lay-verify='busiNumber' value="<?php echo isset($audit['business_img']) ? $audit['business_license'] : " "?>" placeholder="营业执照号" />
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">营业执照：</label>
                    <div class="layui-input-block img-block">
                        <a type="button" class="layui-btn layui-btn-primary" id="upload_busine">
                            <i class="layui-icon">&#xe654;</i>
                        </a>
                        <div id="uploadBusine" class='uploadImg'>
                            <img src="<?php echo isset($audit['business_img']) ? $audit['business_img'] : " "?>" />
                            <input type="hidden" name="uploadBusiness" value="<?php echo isset($audit['business_img']) ? $audit['business_img'] : " "?>">
                        </div>
                    </div>
                </div>
                <div class='layui-form-item'>
                    <label class="layui-form-label">手持身份证：</label>
                    <div class="layui-input-block img-block">
                        <a type="button" class="layui-btn layui-btn-primary" id="upload_oneselfs">
                            <i class="layui-icon">&#xe654;</i>
                        </a>
                        <div id="uploadOneselfs" class='uploadImg'>
                            <img src="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>" />
                            <input type="hidden" name="uploadImg_3" value="<?php echo isset($audit['img_oneself']) ? $audit['img_oneself'] : " "?>">
                        </div>
                    </div>
                </div>

                <?php echo (isset($audit['status']) && $audit['status'] == 2 ) ? "<div class='layui-form-item'>" : "<div class='layui-form-item hidden'>"?>
                <label class="layui-form-label">驳回原因：</label>
                <div class="layui-input-block">
                    <div class="layui-textarea">
                        <?php echo isset($audit['remarks']) ? $audit['remarks'] : ""?>
                    </div>
                </div>
            </div>
            <div class='layui-form-item'>
                <div class="layui-input-block">
                    <button type='submit' lay-submit class='layui-btn layui-btn-warm ' lay-filter='formBusiness'>提交</button>
                </div>
            </div>
            <!-- end -->
        </div>
    </div>
    </div>
    </div>
    <?php //include display('public_menu');?>
</body>
<script type="text/javascript">
<?php if($audit['status'] == 1 || $audit['status'] == "0"){ ?>
    $(".uploadImg").css('left','0');
    $('button[lay-submit]').css('display','none');
    $('input[type="text"]').attr('disabled','disabled');
<?php } ?>
layui.use(["element", "upload", "layer", 'form'], function() {
    var element = layui.element;
    var upload = layui.upload;
    var layer = layui.layer;
    var form = layui.form;
    // element.on("tab(aduitTab)", function() {
    //     element
    // })
    form.verify({
        name : function(value){
            value = $.trim(value);
            var nameReg = /^[\u4e00-\u9fa5]+$/;
            if(!nameReg.test(value)){
                return "姓名只允许输入汉字";
            }
        },
        postcard : function(value){
            value = $.trim(value);
            var num = /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
            if(!num.test(value) || value == ""){
                return "请输入正确的身份证号";
            }
        },
        enterprise : function(value){
            value = $.trim(value);
            var entrReg = /^[\u4E00-\u9FA5\uF900-\uFA2D\w]+$/;
            if(!entrReg.test(value)){
                return "企业名称不能有特殊字符";
            }
        },
        busiNumber : function(value){
            value = $.trim(value);
            if(value.length != 18 && value.length != 15){
                return "营业执照号长度不符";
            }
            var reg = /^([0-9ABCDEFGHJKLMNPQRTUWXY]{2})([0-9]{6})([0-9ABCDEFGHJKLMNPQRTUWXY]{9})([0-9Y])$/;
            if(!reg.test(value)){
                return "营业执照号输入错误";
            }
            // var num = /^[0-9]*$/;
            // if(!num.test(value) || value == ""){
            //     return "营业执照只能为数字";
            // }
        }

    });

    var uploadInst1 = upload.render({
        elem: "#upload_1",
        url: "postcard.php?type=uploadFile",
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
    var uploadInst2 = upload.render({
        elem: "#upload_2",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            console.log(res.res);
            if (!res.res) {
                $("#uploadImg_2 img").attr("src", res.msg);
                $("#uploadImg_2 input").val(res.msg);
                $("#uploadImg_2").show();
            }
        },
        error: function() {}
    });
    var uploadInst3 = upload.render({
        elem: "#upload_3",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#uploadImg_3 img").attr("src", res.msg);
                $("#uploadImg_3 input").val(res.msg);
                $("#uploadImg_3").show();
            }
        },
        error: function() {}
    });
    var uploadInst3 = upload.render({
        elem: "#upload_business",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#uploadBusiness img").attr("src", res.msg);
                $("#uploadBusiness input").val(res.msg);
                $("#uploadBusiness").show();
            }
        },
        error: function() {}
    });

     var uploadInst3 = upload.render({
        elem: "#upload_busine",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#uploadBusine img").attr("src", res.msg);
                $("#uploadBusine input").val(res.msg);
                $("#uploadBusine").show();
            }
        },
        error: function() {}
    });

     var uploadInst4 = upload.render({
        elem: "#upload_shop_logo",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#upload_shop_logo img").attr("src", res.msg);
                $("#upload_shop_logo input").val(res.msg);
                $("#upload_shop_logo").show();
            }
        },
        error: function() {}
    });
    var uploadInst3 = upload.render({
        elem: "#upload_oneself",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#uploadOneself img").attr("src", res.msg);
                $("#uploadOneself input").val(res.msg);
                $("#uploadOneself").show();
            }
        },
        error: function() {}
    });

     var uploadInst3 = upload.render({
        elem: "#upload_oneselfs",
        url: "postcard.php?type=uploadFile",
        before: function() {
            layer.load();
        },
        done: function(res, index, upload) {
            layer.closeAll("loading");
            console.log(res);
            if (!res.res) {
                $("#uploadOneselfs img").attr("src", res.msg);
                $("#uploadOneselfs input").val(res.msg);
                $("#uploadOneselfs").show();
            }
        },
        error: function() {}
    });
    var beatCount = 0;
    form.on("submit(formPerson)", function(data) {
        console.log(data);
        if (beatCount >= 1) {
            layer.msg(beatCount + "只能提交一次", { icon: 5, skin: "demo-class" });
            return false;
        }
        // console.log(data.field.status == "0");
        if (data.field.status == "0" || data.field.status == '1') {
            layer.msg(data.field.status + "此状态不可更改", { icon: 5, skin: "demo-class" });
            return false;
        }
        if(data.field.uploadImg_1 == " " || data.field.uploadImg_2 == " " || data.field.uploadImg_3 == " "){
            layer.msg("身份证正反面照片，以及手持照片都需正确上传",{ icon: 5, skin: "demo-class" });
            return false;
        }
        beatCount++;
        layer.load();
        $.post("./postcard.php?pagetype=postcardBackstage", data.field, function(result) {
            console.log(result);
            layer.closeAll("loading");
            if (!result.res) {
                // window.location.href = "./postcard.php?pagetype=postcard";
                layer.msg(result.msg, { icon: 1, skin: "demo-class" }, function() {
                    // window.location.href = "./postcard.php";
                })
            } else {
                layer.msg(result.msg, { icon: 5, skin: "demo-class" });
            }
        }, "json");
        return false;
    });
    form.on("submit(formBusiness)", function(data) {
        console.log(data.field);
        if (beatCount >= 1) {
            layer.msg(beatCount + "只能提交一次", { icon: 5, skin: "demo-class" });
            return false;
        }
        if (data.field.status == '0' || data.field.status == '1') {
            layer.msg(data.field.status + "此状态不可更改", { icon: 5, skin: "demo-class" });
            return false;
        }
        if(data.field.uploadBusiness == " " || data.field.uploadImg_3 == " "){
            layer.msg("请您上传营业执照或者手持身份证照片",{ icon: 5, skin: "demo-class" });
            return false;
        }
        beatCount++;
        layer.load();
        $.post("./postcard.php?pagetype=postcardBackstage", data.field, function(result) {
            console.log(result);
            layer.closeAll("loading");
            if (!result.res) {
                layer.msg(result.msg, { icon: 1, skin: "demo-class" }, function() {
                    window.location.href = './postcard.php';
                })
            } else {
                layer.msg(result.msg, { icon: 5, skin: "demo-class" });
            }
        }, "json");
        return false;
    })
})


</script>

</html>
