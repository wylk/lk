layui.use(['form', 'layer'],
function() {
    $ = layui.jquery;
    var form = layui.form,
    layer = layui.layer;

    //自定义验证规则
    form.verify({
    });

    //监听提交
    form.on('submit(add)',
    function(data) {
        //layer.msg(JSON.stringify(data.field));
        $.post('?c=config&a=addApplication',data.field,function(re){
            if(re.error == 0){
                layer.alert(re.msg, {icon: 6},function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                });
            }else{
                layer.alert(re.msg, {icon: 2},function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                });
            }

        },'json');
        //发异步，把数据提交给php
        
        return false;
    });


    $('[id=img]').click(function() {
        $('#hidden_img').val($(this).data('type'));
        $('#inputfile').click();
    });

    $("#inputfile").change(function() {
        var img_id = '#' + ($('#hidden_img').val());
        var up_path = '?c=config&a=uploadFile';
        lk.up_img($(this), up_path,function(res) {
            console.log(res);
            if (res.error == 0) {
                var obj = $(img_id);
                var url = obj.val();
                $.post('?c=config&a=delFile', {
                    url: url
                },
                function() {});
                obj.val(res.msg);
            }
        },'json');
        
    });
});