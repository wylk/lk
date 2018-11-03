<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <title>转账</title>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        html body{
            background-color: #f2f2f2;min-height: 0px;
        }
        .lk-content{background-color: white;margin: 15px; border-radius: 5px;}
        .block{width:100%;height:50px;}
        .block-header{width: 90%;height: 90px;margin: 15px auto; color: #333;}
        .block-header h2{text-align: center;padding-top: 15px;}
        .crad_logo{width:55px;height: 55px;margin: 0px auto}
        .crad_logo img{width:100%;height: 100%;}
        .imgstyle{width:15%;float:left;text-align:right;line-height: 50px;}
        #addRemark{width:15%;float:right;text-align:left;line-height: 50px;}
        .dataTitle i{font-size: 18px;}
        .dataBox{width:65%;height:50px;float:left;line-height:50px;margin-left: 10px;}
        .dataBox input{border:0px;width: 80%;height: 30px;margin-left: 20px;}
        /* .dataBox input{border:0;border-bottom:1px solid gray;height:30px;} */
        .btnStyle{text-align:center;margin-top:40px;padding-bottom: 30px;}
        .blockSpan{height: 35px; text-align: center; margin: 5px auto; width: 85%;}
        .blockSpan .spanLeft{float: left; margin: 10px auto;width: 45%;padding-right: 5px;}
        .blockSpan .spanRight{float: right; margin: 10px auto;width: 45%;padding-left: 5px;}
        .spanLeft span{float: right;height: 23px;line-height: 23px;}
        .spanRight span{float: left;height: 23px;line-height: 23px;}
        /*{border:1px solid red;width:40%;height:50px;float:left;}*/
        /*.blockRight span,.blockRight span{}*/
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
        /*.block-balance{line-height: 40px;width: 100%;text-align: center;}*/
        .layui-btn{
            width: 70%;
            background: #fff;
            color: #efd21d;
            border: 1px solid #efd21d;
        }
        .btn-theme{
            border-color: #29aee7;
            color: #999;
            border-radius: 5px;
            width: 90%;
        }
        /*转账弹框*/
        .platform{border: 1px solid #4ea9a0;width: 80%;border-radius: 5px;position: absolute;left: 10%;top: 200px;background-color: white;display: none;}
       .platform h3{text-align: center;margin:20px;}
       .platform input{width: 70%;}
       .layui-form-block{text-align: center;}
       .platform button{width: 40%;}
       .payBtnColor{background-color:white;}
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
    <div class="lk-content">
        <div class="block-header">
            <h2><?php echo $cardName['val']; ?></h2>
           <div class="blockSpan">
               <div class="spanLeft"><span><?php echo number_format($cardInfo['num'],2) ?></span><span style="color: #999;">可用：</span></div> 
               <div class="spanRight"><span style="color: #999;">锁定：</span><span><?php echo number_format($cardInfo['frozen'],2) ?></span></div> 
           </div>
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
                    <input type="text" name="getAddress" value="<?php echo $address;?>" required lay-verify="address" placeholder="请输入转账地址" />
                </div>
                <!-- <div class="dataTitle"> -->
                    <i class="layui-icon" id="addRemark">&#xe654;</i>
                <!-- </div> -->
                <hr/>
            </div>
            <div class="block block-line">
                <div class="dataTitle">
                    <i class="layui-icon imgstyle">&#xe66f;</i>
                </div>
                <div class="dataBox">
                    <input type="text" value="<?php echo $name;?>" name="addressName" required lay-verify="addressName" placeholder="请输入地址备注" />
                </div><hr/>
            </div>
            <?php if(!$is_self){?>
            <div class="block btnStyle">
                <input type="hidden" name="sendAddress" value="<?php echo $cardInfo['address'] ?>">
                <input type="hidden" name="cardId" value="<?php echo $cardInfo['card_id'] ?>">
                <button lay-submit class='layui-btn btn-theme' lay-filter="subTransfer" >确认转账</button>
            </div>
            <?php }?>
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
<!-- 转账弹框 -->
<div class="layui-form platform">
    <h3>平台支付</h3>
    <form action="javascript:;">
        <input type="hidden" name="sendAddress" value="<?php echo $cardInfo['address'] ?>">
        <input type="hidden" name="cardId" value="<?php echo $cardInfo['card_id'] ?>">
    <div class="layui-form-item">
      <label class="layui-form-label">密码：</label>
      <div class="layui-input-block">
        <input type="password" name="pwd" value="" placeholder="请输入密码" class="layui-input">
      </div>
      <!-- 密码：<input type="" name=""> -->
    </div>
    <div class="layui-form-item">
      <div class="layui-form-block">
        <button class="layui-btn layui-btn-primary">取消</button>
        <button class="layui-btn" id='submit' lay-submit lay-filter="formDemo">确认</button>
      </div>
    </div>
    </form>
  </div>
</div>
    <?php //include display('public_menu');?>
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
        $(".layui-btn-primary").click(function(){
           $(".platform").hide();
           $("[name=pwd]").val('');
        })
        // $(".btn-theme").bind("click",function(){
        //     $(".platform").show();
        // });
        form.on("submit(formDemo)",function(datas){
            var pwd = $("[name=pwd]").val();
            if(!pwd.length) layer.msg("请先输入密码",{icon:5,skin:"demo-class"});
            // console.log(datas);
            var data = datas.field;
            data.getAddress = $("[name=getAddress]").val();
            data.addressName = $("[name=addressName]").val();
            data.num = $("[name=num]").val();
            data.type = "transferBill";
            console.log(data);
            // return false;
            $.post("./transferBill.php",data,function(res){
                console.log(res);
                if(!res.res){
                    layer.msg(res.msg,{icon:1,skin:"demo-class"});
                    window.location.href = "./card_package.php"
                }else{
                    layer.msg(res.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
            return false;
        });
        form.on("submit(subTransfer)",function(datas){
            $(".platform").show();
            console.log(datas);
            var num = datas.field.num;
            var data = datas.field;
            data.type = "transferBill";
            console.log(data);
            return false;
            // return false;
            // $.post("./transferBill.php",data,function(res){
            //     console.log(res);
            //     if(!res.res){
            //         // layer.msg(res.msg,{icon:1,skin:"demo-class"});
            //         // if(res.isPublisher){
            //         //     $(".evaluate").show();
            //         // }else{ }
            //             layer.msg(res.msg,{icon:1,skin:"demo-class"});
            //             window.location.href = "./card_package.php"
                   
            //     }else{
            //         layer.msg(res.msg,{icon:5,skin:"demo-class"});
            //     }
            // },"json");
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
