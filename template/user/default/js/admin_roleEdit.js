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
          });

          form.on('checkbox(allChoose)', function(data){
              var child = $(data.elem).parent().next().find('input[type="checkbox"]');
              child.each(function(index, item){
                item.checked = data.elem.checked;
              });
              form.render('checkbox');
          });

          //监听提交
          form.on('submit(edit)', function(data){
            data.field.auth_id = lk.checkbox_val('auth_id');
            $.post('?c=admin&a=roleEdit',data.field,function(res){
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
