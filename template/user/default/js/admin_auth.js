layui.use(['form', 'layer'],
function() {
    $ = layui.jquery;
    var form = layui.form,
    layer = layui.layer;
    //自定义验证规则
    form.verify({
        name: function(value) {
            if (value.length < 3) {
                return '权限名至少得3个字符啊';
            }
        },
        auth_c:[/[a-zA-Z]/,'控制器必须是字母'],
        auth_a:[/[a-zA-Z]/,'方法必须是字母'],
        icon:function(value){
            if (value.length < 8) {
                return '图标名不能少得8个字符啊';
            }
        }
    });

    //监听提交
    form.on('submit(add)', function(data) {
        $.post('?c=admin&a=auth', data.field, function(res) {
            console.log(res);
            if(res.error == 0){
                swal("友情提示！", res.msg,"success");
            }else{
                swal("友情提示！", res.msg,"error");
            }
        },'json');
        return false;
    });

});


/*  layui.use('laydate', function(){
    var laydate = layui.laydate;

    
    //执行一个laydate实例
    laydate.render({
      elem: '#start' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
      elem: '#end' //指定元素
    });
  });

   /*用户-停用*/
 /* function member_stop(obj,id){
      layer.confirm('确认要停用吗？',function(index){

          if($(obj).attr('title')=='启用'){

            //发异步把用户状态进行更改
            $(obj).attr('title','停用')
            $(obj).find('i').html('&#xe62f;');

            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
            layer.msg('已停用!',{icon: 5,time:1000});

          }else{
            $(obj).attr('title','启用')
            $(obj).find('i').html('&#xe601;');

            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
            layer.msg('已启用!',{icon: 5,time:1000});
          }
          
      });
  }*/

  /*用户-删除*/
 /* function member_del(obj,id){
      layer.confirm('确认要删除吗？',function(index){
          //发异步删除数据
          $(obj).parents("tr").remove();
          layer.msg('已删除!',{icon:1,time:1000});
      });
  }*/



/*  function delAll (argument) {

    var data = tableCheck.getData();

    layer.confirm('确认要删除吗？'+data,function(index){
        //捉到所有被选中的，发异步进行删除
        layer.msg('删除成功', {icon: 1});
        $(".layui-form-checked").not('.header').parents('tr').remove();
    });
  }*/