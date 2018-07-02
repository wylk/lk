layui.use('laydate', function(){
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

      //禁用 启用
        $('.member_stop').click(function(){
            var data = {}
            data.id = $(this).data('id');
            data.status = $(this).data('status');
            $.get('?c=admin&a=change',data,function(res){
                console.log(res);
                if(res.status == 0){
                    alert(res.msg);
                    window.location.replace(location.href);
                }else{
                    alert(res.msg);
                }
            },'json')
        })

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('?c=admin&a=delete',{id:id},function(res){
                if(res.error == 0){
                  $(obj).parents("tr").remove();
                  layer.msg(res.msg,{icon:1,time:1000});
                }else{
                  layer.msg(res.msg,{icon:4,time:1000});
                }
              },'json');
              //发异步删除数据
              // $(obj).parents("tr").remove();
              // layer.msg('已删除!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
