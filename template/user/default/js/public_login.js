$(function  () {
  var is_name = false;
     layui.use('form', function(){
       var form = layui.form;
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
          $.post('?c=public&a=login',data.field,function(res){
            if(data.status==0){
              alert(res.msg);
              window.location.href="?c=index&a=index";
            }else{
              alert(res.msg);
            }
          },'json');

         // layer.msg(JSON.stringify(data.field),function(){
         // });
          return false;
       });
     });
 })
