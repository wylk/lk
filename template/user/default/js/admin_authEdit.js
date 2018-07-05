layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;

        //自定义验证规则
        form.verify({
          nikename: function(value){
            if(value.length < 5){
              return '昵称至少得5个字符啊';
            }
          }
          ,pass: [/(.+){6,12}$/, '密码必须6到12位']
          ,repass: function(value){
              if($('#L_pass').val()!=$('#L_repass').val()){
                  return '两次密码不一致';
              }
          }
        });

        //监听提交
        form.on('submit(add)', function(data){
          $.post('?c=admin&a=authEdit',data.field,function(res){
                console.log(res);
                if(res.error==0){
                    layer.alert(res.msg, {icon: 1,},function () {
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                    });
                }else{
                    layer.alert(res.msg, {icon: 2,time:1000},function () {
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                    });
                }
            },'json');

          return false;
        });
      });
