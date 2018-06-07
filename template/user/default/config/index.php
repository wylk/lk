<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>系统设置</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo TPL_URL;?>x-admin/css/font.css">
        <link rel="stylesheet" href="<?php echo TPL_URL;?>x-admin/css/xadmin.css">
        <link rel="stylesheet" type="text/css" href="https://epai.51ao.com/source/tp/Project/tpl/Static/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
        <script type="text/javascript">
            var frame_show = false;
            var static_path = false;
        </script>
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="<?php echo TPL_URL;?>/js/config_index.js?r=<?php echo time();?>"></script>
        <script type="text/javascript" src="https://mall.epaikj.com//static/js/jquery.form.js"></script>
        <script type="text/javascript" src="https://mall.epaikj.com//static/js/jquery.validate.js"></script>
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>

    </head>
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red">test</span>！当前时间:2018-04-25 20:50:53
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:-9px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </blockquote>
        <form id="myform" datas="1" method="post" action="?c=config&a=saveConfig" refresh="true">
            <fieldset class="layui-elem-field">
                <legend>系统设置</legend>
                <div class="layui-field-box">
                    <table class="layui-table">
                        <tbody>
                            <?php echo $config;?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <blockquote class="layui-elem-quote layui-quote-nm"> <button  class="layui-btn layui-btn-lg" name="dosubmit">保存</button></blockquote>
        </form>
    </div>
    <input type="hidden" value="" id="img">
    <input type="file" name="image" style="opacity:0;filter:alpha(opacity=0);" id="inputfile"/>
    </body>
</html>
