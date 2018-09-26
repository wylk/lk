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
        <link rel="stylesheet" type="text/css" href="https://epai.51ao.com/source/tp/Project/tpl/Static/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
        <script type="text/javascript">
            var frame_show = false;
            var static_path = false;
            var authUrl = "<?php dourl('index');?>";
        </script>
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="<?php echo TPL_URL;?>/js/config_index.js?r=<?php echo time();?>"></script>
        <script type="text/javascript" src="https://mall.epaikj.com//static/js/jquery.form.js"></script>
        <script type="text/javascript" src="https://mall.epaikj.com//static/js/jquery.validate.js"></script>
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>

    </head>
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red">test</span>！当前时间:2018-04-25 20:50:53
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:-9px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </blockquote>
       <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-  form-pane">
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="标题" name="info" lay-verify="title">
          </div>
          <div class="layui-input-inline">
            <select name="type">
              <option value="text">单行文本</option>
              <?php foreach($inputType as $k => $v){?>
                <option value="<?php echo $v['type']?>"><?php echo $v['title']?></option>
              <?php }?>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="reg">
              <option value="0">无验证</option>
              <?php foreach($regType as $kk => $vv){?>
                <option value="<?php echo $vv['type']?>"><?php echo $vv['title']?></option>
              <?php }?>
            </select>
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="字段name" name="name" lay-verify="name">
          </div>
          <div class="layui-input-inline">
             <input class="layui-input" placeholder="单选才输入,男,女/验证" name="remark">
          </div>
           <div class="layui-input-inline">
             <input class="layui-input" placeholder="下拉输入(三个值,号隔开)" name="select_name">
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="add" ><i class="layui-icon"></i>增加</button>
        </form>

      </div>



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
<script type="text/javascript">
    layui.use(['form', 'layer'],function() {
    $ = layui.jquery;
    var form = layui.form,
    layer = layui.layer;
    //自定义验证规则
    form.verify({
        title: function(value) {
            if (value.length < 1) {
                return '标题不能为空';
            }
        },
        name:[/[a-zA-Z]/,'name值必须是字母'],
    });

    //监听提交
    form.on('submit(add)', function(data) {
        console.log(data.field);
        $.post(authUrl, data.field, function(res) {
            console.log(res);
            if(res.error == 0){
                layer.msg(res.msg,{icon:1,time:2000},function(){
                    window.location.replace(location.href);
                });
            }else{
               layer.msg(res.msg,{icon:2,time:1000});
            }
        },'json');
        return false;
    });

});
</script>

