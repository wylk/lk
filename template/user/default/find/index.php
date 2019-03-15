<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>乐卡后台管理</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>lib/layui/css/layui.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
        .func_block{border:1px solid #e6e6e6;border-bottom: 0px;margin:30px 25px;}
        .layui-row{display: flex;text-align: center;border-bottom:1px solid #e6e6e6;min-height: 45px;}
        .layui-row .layui-col-xs4{align-self: center;}

        .func_add_block{margin:30px 25px;}
        .func_add_block .layui-form{border:1px solid #e6e6e6;display: flex;padding-top: 8px;}
        .layui-form .layui-form-item{flex-direction: row;/*border:1px solid red;*/display: flex;}
        .layui-form-item div,.layui-form-item label{align-self: center;/*border:1px solid red;*/}
        .layui-input-block{margin-left: 0px;}
        .layui-textarea{min-height: 60px;}
    </style>
</head>
<body>
<div class="x-nav">
    <span class="layui-breadcrumb">
        <a href="?c=find&a=index">发现列表</a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
    <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="func_add_block">
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">功能名：</label>
            <div class="layui-input-block">
                <input type="text" name="title" placeholder="请输入功能名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">功能描述：</label>
            <div class="layui-input-block">
                <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button lay-submit lay-filter="submitBtn" class="layui-btn">提交</button>
            </div>
        </div>
    </form>
</div>

<div class="func_block">
    <div class="layui-row">
        <div class="layui-col-xs4 layui-col-sm3 layui-col-md4">功能</div>
        <div class="layui-col-xs4 layui-col-sm6 layui-col-md8">功能说明</div>
        <div class="layui-col-xs4 layui-col-sm3 layui-col-md4">设置</div>
    </div>
    <?php foreach($funcList as $key=>$val){ ?>
    <div class="layui-row">
        <div class="layui-col-xs4 layui-col-sm3 layui-col-md4"><a href="?c=find&a=func_name&id=<?php echo $val['id']?>"><?php echo $val['name']; ?></a></div>
        <div class="layui-col-xs4 layui-col-sm6 layui-col-md8"><?php echo $val['state'] ?></div>
        <div class="layui-col-xs4 layui-col-sm3 layui-col-md4 layui-form">
            <input type="checkbox" name="switch" lay-skin="switch" num="<?php echo $val['id'] ?>" lay-text="ON|OFF" <?php echo $val['switch'] ? "checked" : " " ?> >
        </div>
    </div>
    <?php } ?>
</div>
<script type="text/javascript">
layui.use(['layer','form'],function(){
    var layer = layui.layer;
    var form = layui.form;
    
    form.on("submit(submitBtn)",function(data){
        if(!data.field.title){
            $("[name=title]").focus();
            layer.msg("请输入功能名");
            return false;
        }
        if(!data.field.desc){
            $("[name=desc]").focus();
            layer.msg("请输入功能描述");
            return false;
        }
        var data = {desc:data.field.desc,type:"addFunc",title:data.field.title};
        $.post("?c=find&a=index",data,function(result){
            console.log(result);
            if(!result.error){
                layer.msg("添加成功");
                setTimeout(function(){
                    window.location.reload();
                },1000);
            }else{
                layer.msg("添加失败，请重新添加");
            }
        },"json");
        return false;
    });
    // 开关
    form.on("switch",function(data){
        var id = $(data.elem).attr("num");
        var data1 = {type:"switch",id:id,switch:data.elem.checked};
        $.post("?c=find&a=index",data1,function(result){
            console.log(result);
            if(!result.error){
                layer.msg("修改成功");
            }else{
                layer.msg("修改失败");
            }
        },"json");
    })
})
</script>
</body>
</html>
