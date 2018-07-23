<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>系统设置</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>

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
                <legend>发卡管理</legend>
                <div class="layui-field-box">
                    <form class="layui-form" action="">
                      <div class="layui-form-item">
                        <label class="layui-form-label">输入框</label>
                        <div class="layui-input-block">
                          <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">密码框</label>
                        <div class="layui-input-inline">
                          <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">辅助文字</div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">选择框</label>
                        <div class="layui-input-block">
                          <select name="city" lay-verify="required">
                            <option value=""></option>
                            <option value="0">北京</option>
                            <option value="1">上海</option>
                            <option value="2">广州</option>
                            <option value="3">深圳</option>
                            <option value="4">杭州</option>
                          </select>
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">复选框</label>
                        <div class="layui-input-block">
                          <input type="checkbox" name="like[write]" title="写作">
                          <input type="checkbox" name="like[read]" title="阅读" checked>
                          <input type="checkbox" name="like[dai]" title="发呆">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">开关</label>
                        <div class="layui-input-block">
                          <input type="checkbox" name="switch" lay-skin="switch">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">单选框</label>
                        <div class="layui-input-block">
                          <input type="radio" name="sex" value="男" title="男">
                          <input type="radio" name="sex" value="女" title="女" checked>
                        </div>
                      </div>
                      <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">文本域</label>
                        <div class="layui-input-block">
                          <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <div class="layui-input-block">
                          <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                      </div>
                    </form>
                </div>
            </fieldset>

        </form>
    </div>
    <input type="hidden" value="" id="img">
    <input type="file" name="image" style="opacity:0;filter:alpha(opacity=0);" id="inputfile"/>
    </body>
</html>
