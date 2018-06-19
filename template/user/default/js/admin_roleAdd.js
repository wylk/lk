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

          //监听提交
          form.on('submit(add)', function(data){

            var postData = {}
            postData.role_id = '';
            for(var k in data.field){
              if(k == 'role_name'){
                postData.role_name = data.field[k]
              }else{
                postData.role_id += data.field[k].toString()+',';
              }
            }

            $.post('?c=admin&a=roleAdd',postData,function(res){
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
