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
    .layui-container p{ line-height: 35px;}
    .layui-container p i { color: red; margin-right: 10px;}
    .layui-tab-content { height: auto}
    .uploadImg { position: absolute; top:0;right: 0;width: 150px;  height: 95px; overflow: hidden;}
    .layui-btn {width:40px; height:40px;line-height:40px; border:1px dashed;padding:0;}
    .layui-btn .layui-icon{font-size:22px;}
    .uploadImg img {width: 100%; height:100%;}
    .layui-form-item .layui-form-label{position: relative;width: 84px; padding-right: 8px}
    .layui-btn-warm{width:100%;height:50px; line-height: 50px; border:0; position: relative;left: -45px }
    .layui-input-block { width: 200px; margin-left: 110px;}
    .hidden { display: none;}
    .cardBody { width: 100%; margin-top: 46px; text-align: center;}
    .img-block{height: 95px}
    </style>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">认 证</h1>
    </header>
    <div class="lk-content">
        <div class="layui-container">
            <p><i>注:</i>普通用户无需认证 发VIP1/VIP2请完成认证</p>
        </div>
        <hr>
        <div class="layui-container">
            <p>认证状态：<font style="color: red"><?php echo (isset($audit['status'])&&$audit['status']==1) ? "认证通过" : "认证未通过";?></font></p>
        </div>
        <hr>
        <div class="layui-container">
            <div class="layui-tab layui-tab-card" lay-filter="aduitTab">
                <ul class="layui-tab-title">
                    <li class="<?php echo $type==2 ? " layui-btn-disabled " : "layui-this "?>">个人认证</li>
                    <li class="<?php echo $type==2 ? " layui-this " : " "?>">企业认证</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item <?php echo $type==2 ? " " : "layui-show "?>">
                        <?php echo $type==2 ? "<p class='cardBody'>您已选择企业认证，不能再进行个人认证</p>" : ""?>
                        <?php echo $type==2 ? "<form class='layui-form hidden'>" : "<form class='layui-form'>"?>
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="status" value="<?php echo isset($audit['status']) ? $audit['status'] : ""?>">
                        <div class='layui-form-item'>
                            <label class="layui-form-label">姓名：</label>
                            <div class="layui-input-block">
                                <input type="text" class='layui-input' name="name" required lay-verify='required' value="<?php echo isset($audit['name']) ? $audit['name'] : " "?>" placeholder="真实姓名" />
                            </div>
                        </div>
                        <div class='layui-form-item'>
                            <label class="layui-form-label">身份证号：</label>
                            <div class="layui-input-block">
                                <input type="text" class='layui-input' name="postcard" required lay-verify='required|number' value="<?php echo isset($audit['postcards']) ? $audit['postcards'] : " "?>" placeholder="身份证号" />
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
                            <?php echo isset($audit[' status '])&&($audit['status ']==0 || $audit['status ']==1) ? " " : "<button lay-submit class='layui-btn layui-btn-warm ' lay-filter='formPerson'>提交</button>";?>
                            
                        </div>
                    </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php echo $type==2 ? " layui-show " : " "?>">
                    <?php echo $type==1 ? "<p>您已选择个人认证，不能再进行企业认证</p>" : ""?>
                    <?php echo $type==1 ? "<form class='layui-form hidden'>" : "<form class='layui-form'>"?>
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="status" value="<?php echo isset($audit['status']) ? $audit['status'] : " "?>">
                    <div class='layui-form-item'>
                        <label class="layui-form-label">企业名称：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="enterprise" required lay-verify='required' value="<?php echo isset($audit['enterprise']) ? $audit['enterprise'] : " "?>" placeholder="企业名称" />
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">法人姓名：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="name" required lay-verify='required' value="<?php echo isset($audit['name']) ? $audit['name'] : " "?>" placeholder="法人姓名" />
                        </div>
                    </div>
                    <div class='layui-form-item'>
                        <label class="layui-form-label">营业执照号：</label>
                        <div class="layui-input-block">
                            <input type="text" class='layui-input' name="businessLicense" required lay-verify='required|number' value="<?php echo isset($audit['business_img']) ? $audit['business_license'] : " "?>" placeholder="营业执照号" />
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
                        <?php echo isset($audit[' status '])&&($audit['status '] == 0 || $audit['status ']==1) ? "" : "<button type='submit' lay-submit class='layui-btn layui-btn-warm ' lay-filter='formBusiness'>提交</button>";?>
                        
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
layui.use(["element", "upload", "layer", 'form'], function() {
    var element = layui.element;
    var upload = layui.upload;
    var layer = layui.layer;
    var form = layui.form;
    element.on("tab(aduitTab)", function() {
        element
    })

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
        beatCount++;
        layer.load();
        $.post("./postcard.php?pagetype=postcardBackstage", data.field, function(result) {
            console.log(result);
            layer.closeAll("loading");
            if (!result.res) {
                // window.location.href = "./postcard.php?pagetype=postcard";
                layer.msg(result.msg, { icon: 1, skin: "demo-class" }, function() {
                    window.location.href = "./postcard.php";
                })
            } else {
                layer.msg(result.msg, { icon: 5, skin: "demo-class" });
            }
        }, "json");
        return false;
    });
    form.on("submit(formBusiness)", function(data) {
        console.log(data);
        if (beatCount >= 1) {
            layer.msg(beatCount + "只能提交一次", { icon: 5, skin: "demo-class" });
            return false;
        }
        if (data.field.status == '0' || data.field.status == '1') {
            layer.msg(data.field.status + "此状态不可更改", { icon: 5, skin: "demo-class" });
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
