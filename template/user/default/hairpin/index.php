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
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/layui.css"  media="all">
    </head>
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red">test</span>！当前时间:2018-04-25 20:50:53
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:-9px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </blockquote>
            <fieldset class="layui-elem-field">
                <legend>发卡管理</legend>
                <div class="layui-field-box">
                    <form id="myform" datas="1" method="post" action="?c=hairpin&a=index" method="post" >
                      <div class="layui-form-item">
                        <label class="layui-form-label">卡名</label>
                        <div class="layui-input-block">
                          <input type="text" name="name" required  lay-verify="required" placeholder="请输入卡名" autocomplete="off" class="layui-input">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">限制条件</label>
                        <div class="layui-input-block">
                          <input type="text" name="is_limit" required  lay-verify="required" placeholder="请输入限制条件" autocomplete="off" class="layui-input">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">总量</label>
                        <div class="layui-input-block">
                          <input type="text" name="sum" required  lay-verify="required" placeholder="请输入总量" autocomplete="off" class="layui-input">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">合约</label>
                        <div class="layui-input-block">
                          <input type="text" name="contract" required  lay-verify="required" placeholder="请输入合约" autocomplete="off" class="layui-input">
                        </div>
                      </div>
                      <div class="layui-form-item">
                        <label class="layui-form-label">会员卡log</label>
                            <div class="layui-upload">
                              <button type="button" class="layui-btn upload" id="test1">上传图片</button>
                              <div class="layui-upload-list">
                                <img class="layui-upload-img" id="demo1" style="margin-left: 233px;margin-top: -48px;width: 171px;height: 100px;">
                                <p id="demoText"></p>
                              </div>
                            </div>
                      </div>
                      <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">卡卷描述</label>
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

<script type="text/javascript">
    layui.use('upload', function(){
  var $ = layui.jquery
  ,upload = layui.upload;

  //普通图片上传
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: '/upload/'
    ,before: function(obj){
      //预读本地文件示例，不支持ie8
        $.get('?c=hairpin&a=index',data,function(res){
                console.log(res);
                if(res.status == 0){
                    alert(res.msg);
                    window.location.replace(location.href);
                }else{
                    alert(res.msg);
                }
        ,'json')
      obj.preview(function(index, file, result){
        var uploads = $('#demo1').attr('src', result); //图片链接（base64）

      });
    }
    ,done: function(res){
      //如果上传失败
      if(res.code > 0){
        return layer.msg('上传失败');
      }
      //上传成功
    }
    ,error: function(){
      //演示失败状态，并实现重传
      var demoText = $('#demoText');
      demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
      demoText.find('.demo-reload').on('click', function(){
        uploadInst.upload();
      });
    }
  });

});
</script>
