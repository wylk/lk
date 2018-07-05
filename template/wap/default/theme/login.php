<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
      .layui-input-block{margin-right: 50px;}
      .layui-input{border:0;}
      .layui-form-item .layui-input-inline.us-input-inline{display: inline-block; float: none; left: 0;  width: auto; margin: 0; padding: 10px 0 10px 31px;}
      .layui-form-item{margin: 0; line-height: 45px;}
      .us-btn{background-color: #FFF; color:#FF5722; font-weight: 500}
      .us-btn:hover{color:#FF5722;}
      .layui-form-item .layui-form-label{margin-top:10px;}
      .layui-row{border-radius: 3px;}

      .layui-checkbox{background-color: #FFF; color:#FFF; width: 12px; height: 12px; border:1px solid #f2f2f2; margin:10px; font-size:9px;padding:2px;}

      .us-checkbox{background-color: #FFF; color:#000; width: 12px; height: 12px; border:1px solid #ddd; margin:10px; font-size:9px;padding:2px; }
      .layui-layer-btn{background:none;}
    </style>
</head>

<body style="background-color: rgba(240,240,240,.3);">
  <header class="lk-bar lk-bar-nav" style="background-color: #FFF">
      <i class="iconfont">&#xe697;</i>
      <h1 class="lk-title">登 陆</h1>
  </header>
  <div class="layui-container" style="padding-top:155px">
    <form class="layui-form" action="./login.php">
  <div class="layui-row" style="border:1px solid #d2d2d2; background-color: #FFF; margin-bottom:50px;">
    <div class="layui-col-xs12">
        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                <input type="text" name="phone" id="phone" required lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item"  style="border-top:1px solid #F0F0F0">
          <div class="layui-input-inline us-input-inline" style=" border-right:1px solid #F0F0F0">
                <input type="text" name="password" required lay-verify="required" placeholder="请输入手机验证码" autocomplete="off" class="layui-input">
          </div>
            <a href="javascript:;"  id="getVerify" class="layui-btn us-btn">获取验证码</a>
        </div>
  </div>
</div>
<div class="layui-row">
<button id="layui-btn" class="layui-btn layui-btn-disabled" lay-submit lay-filter="formDemo"  style="width:100%;">登 陆</button>
<input type="hidden" name="logintype" value='login' />
<div class="site-demo-button" id="layerDemo" style="margin-bottom: 0;">
  <div id="checkbox" class="layui-icon layui-inline layui-checkbox">&#xe605;</div>同意
  <a data-method="setTop" href="javascript:;" class="layui-btn" style="color:#01AAED; background: none; margin:0; padding: 0;">《服务条款》</a>
</div>
</div>
</form>
</div>

<script type="text/javascript">
  $("#checkbox").click(
    function(){
      var a = !$(this).hasClass("us-checkbox");
      if(a){
        $(this).addClass("us-checkbox");
        $("#layui-btn").removeClass("layui-btn-disabled");
        $("#layui-btn").addClass("layui-btn-danger");
      }else{
        $(this).removeClass("us-checkbox");
        $("#layui-btn").addClass("layui-btn-disabled");
      }
  });
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句

  //触发事件
  var active = {
    setTop: function(){
      var that = this;
      //多窗口模式，层叠置顶
      layer.open({
        type: 2 //此处以iframe举例
        ,title: '服务条款'
        ,area: ['98%', '100%']
        ,shade: 0
        ,maxmin: false
        ,offset: [0,0 //为了演示，随机坐标
          //Math.random()*($(window).height()-300)
          //,Math.random()*($(window).width()-390)
        ]
        ,content: '/wap/service_terms.php'
        //,btn: ['继续弹出', '全部关闭'] //只是为了演示
        ,yes: function(){
          $(that).click();
        }
        ,btn2: function(){
          layer.closeAll();
        }

        ,zIndex: layer.zIndex //重点1
        ,success: function(layero){
          layer.setTop(layero); //重点2
        }
      });
    }


  };

  $('#layerDemo .layui-btn').on('click', function(){
    var othis = $(this), method = othis.data('method');
    active[method] ? active[method].call(this, othis) : '';
  });

});

</script>
<script>
    layui.use(['form',"layer","element"],function(){
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var element = layui.element;
        form.on("submit(formDemo)",function(data){
            var data = data.field;
            $.post("./login.php",data,function(result){
                console.log(result);
                if(result['res']){
                    window.location.href = './my.php';
                    layer.msg(result['msg'],{skin:'demo-class',icon: 1});
                }else{
                    layer.msg(result['msg'],{skin:'demo-class',icon: 5});
                }
            },"json");
            return false;
        })
        // 获取验证码
        $("#getVerify").bind("click", function() {
            var phone = $("#phone").val();
            phoneReg = /^1([0-9]{10})$/;
            if (!phoneReg.test(phone)) {
                layer.msg("请正确填写手机号",{skin:'demo-class',icon: 5});
                return ;
            }
            var data = { phone: phone, type: "code" }
            $.post("./login.php", data, function(data) {
                console.log(data);
                if(data['result']['result']['success']){
                    countDown = 60;
                    setTime();
                    $("#code").val(data['code']);
                    layer.msg("验证码已发送",{skin:'demo-class',icon: 1});
                }else{
                    layer.msg("验证码发送失败",{skin:'demo-class',icon: 5});
                }

            },'json');
        })
    })
    var countDown;

    function setTime() {
        // alert("dff");
        if (countDown == 0) {
            $("#getVerify").html("获取验证码");
            $("#getVerify").attr("disabled", false);
        } else {
            $("#getVerify").html("重新发送" + countDown);
            $("#getVerify").attr("disabled", true);
            countDown--;
            setTimeout(function() {
                setTime();
            }, 1000);
        }
    }
    </script>
</body>

</html>
