layui.use(['form','element'], function(){
        form = layui.form;
        var element = layui.element;
        layer = layui.layer;
        form.on('switch(ifNullDemo)',function(i){
            var id = $(this).data('id');

            $.post('?c=config&a=applicationStatus', {status: (i.value),id:id}, function(re) {
                if(re.error == 0){
                    layer.msg(re.msg,{icon:1,time:1000});
                }else{
                    layer.msg(re.msg,{icon:2,time:1000});
                }
               
            },'json');
        });
        $('.x-sort').change(function(){
            var sort = $(this).val(),
            id = $(this).data('id'),
            reg = /^[-+]?\d*$/;
            if(!reg.test(sort)){
                layer.msg('请输入正整数',{icon:2,time:1000});return false;
            }

            $.post('?c=config&a=applicationSort',{sort:sort,id:id},function(re){
                if(re.error == 0){
                    layer.msg(re.msg,{icon:1,time:1000},function(){
                        window.location.replace(location.href);
                    });

                }else{
                    layer.msg(re.msg,{icon:2,time:1000});
                }
            },'json')
        })
      });
      /*合约-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
                $.get('?c=config&a=applicationDel',{id:id},function(re){
                    if(re.error == 0){
                        $(obj).parents("tr").remove();
                        layer.msg(re.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(re.msg,{icon:2,time:1000});
                    }

                },'json');
          });
      }