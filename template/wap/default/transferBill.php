<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .block{width:100%;height:50px;}
        .block-header{width: 90%;height: 100px;margin: 5px auto;}
        .crad_logo{width:55px;height: 55px;margin: 0px auto}
        .crad_logo img{width:100%;height: 100%;}
        .imgstyle{width:15%;float:left;text-align:right;line-height: 50px;}
        .dataTitle i{font-size: 18px;}
        .dataBox{width:70%;height:50px;float:left;line-height:50px;margin-left: 10px;}
        .dataBox input{border:0px;width: 75%;height: 30px;margin-left: 20px;}
        /* .dataBox input{border:0;border-bottom:1px solid gray;height:30px;} */
        .btnStyle{text-align:center;margin-top:40px;}
        .blockLeft,.blockRight{width:40%;height:50px;float:left;text-align:center;}
        /*{border:1px solid red;width:40%;height:50px;float:left;}*/
        .blockRight span,.blockRight span{}
        /*.remarkList,.remark,.remarkName,.remarkAddress{border:1px solid red;width:100%;}*/
        .remarkList{
            position: relative;
            top: 0;
            width:390px;
            height: 600px;
            line-height: 25px;
            background-color:rgba(0,0,0,.3);
            padding-top: 10px;
        }
        .remark{
            width:90%;
            height:35px;
            margin:0 auto;
            background-color:#ddefde;
            line-height:35px;
            margin-bottom:2px;
        }
        .remarkName{width:20%;height:35px;float:left;text-align:center;}
        .remarkAddress{width:70%;height:18px;float:left;}
        .evaluate{width:90%;margin:10px;padding:10px;display: none;}
        .evaluate{width: 80%;margin:10px auto;}
        .evaluate textarea{width:280px;height:80px;}
        .evaluate button{float:left; margin-left: 50px;}
        .block-line{width: 90%;margin: 0px auto}
        .block-balance{line-height: 40px;width: 100%;text-align: center;}
        .layui-btn{
            width: 70%;
            background: #fff;
            color: #000;
            border: 1px solid green;
        }
    </style>
     <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
     <script type="text/javascript">
        $(function(){
            lk.is_weixin() && function(){
                $('.lk-bar-nav').css('display','none');
                $('.lk-content').css({"padding":"0px"});
            }()
        })
    </script>
</head>

<body>
    <header class="lk-bar lk-bar-nav">
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">转  账</h1>
    </header>
    <div class="lk-content">
        <div class="block-header">
            <div class="crad_logo"><img src="<?php echo STATIC_URL;?>/images/default_send_logo.png" /></div>
           <div class="block-balance">
                <span>可用金额：</span><span style="font-weight: bold"><?php echo number_format($cardInfo['num'],2) ?></span>
           </div>
          <!--  <div class="blockRight"><span>冻结金额：</span><span><?php echo number_format($cardInfo['frozen'],2) ?></span></div>  -->
          <hr>
        </div>

        <form class="layui-form">
            <div class="block block-line">
                <div class="dataTitle">
                    <i class="layui-icon imgstyle">&#xe65e;</i>
                </div>
                <div class="dataBox">
                    <input type="text" name="num" required lay-verify="num" placeholder="请输入数量" />
                </div><hr/>
            </div>

            <div class="block block-line">
                <div class="dataTitle">
                    <i class="layui-icon imgstyle">&#xe612;</i>
                </div>
                <div class="dataBox">
                    <input type="text" name="getAddress" required lay-verify="address" placeholder="请输入对方地址" /><i class="layui-icon" id="addRemark">&#xe61f;</i>
                </div><hr/>
            </div>
            <div class="block block-line">
                <div class="dataTitle">
                    <i class="layui-icon imgstyle">&#xe66f;</i>
                </div>
                <div class="dataBox">
                    <input type="text" name="addressName" required lay-verify="addressName" placeholder="请输入地址备注名称" />
                </div><hr/>
            </div>
            <div class="block btnStyle">
                <input type="hidden" name="sendAddress" value="<?php echo $cardInfo['address'] ?>">
                <input type="hidden" name="cardId" value="<?php echo $cardInfo['card_id'] ?>">
                <button lay-submit class='layui-btn' lay-filter="subTransfer" >确认转账</button>
            </div>
        </form>
        <div class="evaluate">
            <div class="text">
                <textarea></textarea>
            </div>
            <div class="btnStyle">
                <button class="layui-btn layui-btn-warm" id="cancleEval">取消</button>
                <button class="layui-btn layui-btn-warm" id="addEval">确定</button>
            </div>
        </div>
    </div>
    <?php include display('public_menu');?>
</body>
<script type="text/javascript">
    layui.use(['form','layer'],function(){
        var form = layui.form;
        var layer = layui.layer;
        form.verify({
            num : function(value){
                value = $.trim(value);
                if(value.length == 0){
                    return "数量不能为空";
                }
            },
            address : function(value){
                value = $.trim(value);
                if(value.length == 0){
                    return "请填写对方地址";
                }
            },
            addressName : function(value){
                value = $.trim(value);
                if(value.length == 0){
                    return "请为转账地址添加备注名，便于保存";
                }
            }
        });
        form.on("submit(subTransfer)",function(datas){
            console.log(datas);
            var num = datas.field.num;
            var data = datas.field;
            data.type = "transferBill";
            // return false;
            $.post("./transferBill.php",data,function(res){
                console.log(res);
                if(!res.res){
                    // layer.msg(res.msg,{icon:1,skin:"demo-class"});
                    /*if(res.isPublisher){
                        $(".evaluate").show();
                    }else{ }*/
                        layer.msg(res.msg,{icon:1,skin:"demo-class"});
                        window.location.href = "./card_package.php"
                   
                }else{
                    layer.msg(res.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
            return false;
        })
        $("#addRemark").bind("click",function(){
            var cardId = $("input[name=cardId]").val();
            var data = {"type":"getRemark","cardId":cardId};
            
            $.post("./transferBill.php",data,function(res){
                console.log(res);
                if(!res.res){
                    var str = "<div class='remarkList'>";
                    $.each(res.list,function(item,value){
                        str += "<div class='remark' onclick='getInfo(\""+value.name+"\",\""+value.address+"\")' ><span class='remarkName'>"+value.name+"</span>";
                        str += "<span class='remarkAddress'>"+value.address+"</span></div>";
                    })
                    str += "</div>";
                    layer.open({
                        type:3
                        ,area: ['390px']
                        ,shade: 0
                        ,offset: [0,0]
                        ,maxmin: false
                        ,content:str
                    })
                }else{
                    layer.msg(res.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
        })
        $("#cancleEval").bind("click",function(){
            $(".evaluate").hide();
        })
        $("#addEval").bind("click",function(){
            var content = $("textarea").val();
            var cardId = $('input[name=cardId]').val();
            var data = {'content':content,"cardId":cardId,"type":"addEval"};
            console.log(data);
            $.post("./transferBill.php",data,function(res){
                console.log(res);
                if(!res.res){
                    layer.msg(res.msg,{icon:1,skin:"demo-class"});
                    window.location.href = "./card_package.php"
                }else{
                    layer.msg(res.msg,{icon:5,skin:"demo-class"});
                }
                $(".evaluate").hide();
            },"json");
        })
    })
function getInfo(name,address){
    $("input[name=getAddress]").val(address);
    $("input[name=addressName]").val(name);
    layui.use('layer',function(){
        layer.closeAll();
    })
}

</script>

</html>
