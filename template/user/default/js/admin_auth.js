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
            if (value.length < 5) {
                return '图标名不能少得5个字符啊';
            }
        }
    });

    //监听提交
    form.on('submit(add)', function(data) {
        console.log(data.field);
        $.post(authUrl, data.field, function(res) {
            console.log(res);
            if(res.error == 0){
                swal("友情提示！", res.msg,"success",false);
                setTimeout(function(){
                    window.location.replace(location.href);
                },2000)
            }else{
                swal("友情提示！", res.msg,"error");
            }
        },'json');
        return false;
    });

});

/*用户-删除*/
function member_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.get(delAuthUrl,{id:id},function(res){
            console.log(res);
            if(res.error == 0){
                $(obj).parents("tr").remove();
                layer.msg(res.msg,{icon:1,time:1000});
            }else{
                layer.msg(res.msg,{icon:4,time:1000});
            }
        },'json');

    });
}



/*  function delAll (argument) {

    var data = tableCheck.getData();

    layer.confirm('确认要删除吗？'+data,function(index){
        //捉到所有被选中的，发异步进行删除
        layer.msg('删除成功', {icon: 1});
        $(".layui-form-checked").not('.header').parents('tr').remove();
    });
  }*/
