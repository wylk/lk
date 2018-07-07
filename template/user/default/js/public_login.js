$(function  () {
  var is_name = false;
     layui.use('form', function(){
       var form = layui.form;
       var layer = layui.layer;
        form.verify({
          name: function(value) {
              if (value.length < 1) {
                  return '用户名不能为空！';
              }
          },
          upwd: function(value) {
              if (value.length < 1) {
                  return '密码不能为空！';
              }
          },
          code:function(value){
              if (value.length < 4) {
                  return '验证码不能少得4个字符啊';
              }
          }
      });
       //监听提交
       form.on('submit(login)', function(data){
        layer.load();
          $.post('?c=public&a=login',data.field,function(res){
             layer.closeAll('loading');
            if(res.status == 0){
              layer.msg(res.msg,{icon:1,time:2000},function(){
               
                window.location.href="user.php?c=index&a=index";
              });
            }else{
              layer.msg(res.msg,{icon:2,time:1000});
            }
          },'json');
          return false;
       });
     });
 })
