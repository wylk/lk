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
        .imgstyle{width:15%;float:left;text-align:right;line-height: 50px;color: #999;}
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
        /*浮动层*/
.ftc_wzsf { display:none; width: 100%; height: 100%; position: fixed; z-index: 999; top: 0; left: 0; min-width: 320px; max-width: 640px;}
.ftc_wzsf .hbbj { width: 100%; height: 100%; position: absolute; z-index: 8; background: #000; opacity: 0.4; top: 0; left: 0; }
.ftc_wzsf .srzfmm_box { position: absolute; z-index: 10; background: #f8f8f8; width: 88%; left: 50%; margin-left: -44%; top: 20%; }
.qsrzfmm_bt { font-size: 16px; border-bottom: 1px solid #c9daca; overflow: hidden; }
.qsrzfmm_bt a { display: block; width: 10%; padding: 10px 0; text-align: center; }
.qsrzfmm_bt img.tx { width: 10%; padding: 10px 0; }
.qsrzfmm_bt span { padding: 15px 5px; color: #999}
.zfmmxx_shop { text-align: center; font-size: 12px; padding: 10px 0; overflow: hidden; }
.zfmmxx_shop .mz { font-size: 14px; float: left; width: 100%; }
.zfmmxx_shop .zhifu_price { font-size: 24px; float: left; width: 100%; }
.ml5 { margin-left: 5px; }
.mm_box { width: 89%; margin: 10px auto; height: 40px; overflow: hidden; border: 1px solid #bebebe; }
.mm_box li { border-right: 1px solid #efefef; height: 40px; float: left; width: 16.3%; background: #FFF; }
.mm_box li.mmdd{ background:#FFF url(<?php echo STATIC_URL;?>/images/dd_03.jpg) center no-repeat ; background-size:25%;}
.mm_box li:last-child { border-right: none; }
.xiaq_tb { padding: 5px 0; text-align: center; border-top: 1px solid #dadada; }
.numb_box { position: absolute; z-index: 10; background: #f5f5f5; width: 100%; bottom: 0px; }
.nub_ggg { border: 1px solid #dadada; overflow: hidden; border-bottom: none; }
.nub_ggg li { width: 33.3333%; border-bottom: 1px solid #dadada; float: left; text-align: center; font-size: 22px; }
.nub_ggg li a { display: block; color: #000; height: 50px; line-height: 50px; overflow: hidden; }
.nub_ggg li a:active  { background: #e0e0e0;}
.nub_ggg li a.zj_x { border-left: 1px solid #dadada; border-right: 1px solid #dadada; }
.nub_ggg li span { display: block; color: #e0e0e0; background: #e0e0e0; height: 50px; line-height: 50px; overflow: hidden; }
.nub_ggg li span.del img { width: 30%; }

.fh_but{ position:absolute; right:0px; top:12px; font-size:14px; color:#20d81f;}
.spxx_shop{ background:#FFF; margin-left:4.35%; border-top:1px solid #dfdfdd; padding:10px 0; }
.spxx_shop td{ color:#7b7b7b; font-size:14px; padding:10px 0;}
.mlr_pm{margin-right:4.35%;}
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
               <div class="spanRight"><span style="color: #999;">锁定：</span><span><?php echo number_format(($cardInfo['frozen']+$cardInfo['bail']),2) ?></span></div> 
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
                    <i class="layui-icon imgstyle" id="addRemark">&#xe654;</i>
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

</div>

 <!-- 支付弹框 -->
<div class="ftc_wzsf">
        <div class="srzfmm_box">
            <div class="qsrzfmm_bt clear_wl">
                <img src="<?php echo STATIC_URL;?>/images/xx_03.jpg" class="tx close fl">
               <!--  <img src="<?php echo STATIC_URL;?>/images/jftc_03.png" class="tx fl"> -->
                <span class="fl">请输入支付密码</span></div>
            <div class="zfmmxx_shop">
                <div class="mz"><?php echo $cardName['val']; ?></div>
                <div class="zhifu_price"><span id="card_num">23432</span> </div></div>
            <ul class="mm_box">
                <li></li><li></li><li></li><li></li><li></li><li></li>
            </ul>
        </div>
        <div class="numb_box">
            <div class="xiaq_tb layui-icon">&#xe61a;</div>
            <ul class="nub_ggg">
                <li><a href="javascript:void(0);" class="zf_num">1</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">2</a></li>
                <li><a href="javascript:void(0);" class="zf_num">3</a></li>
                <li><a href="javascript:void(0);" class="zf_num">4</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">5</a></li>
                <li><a href="javascript:void(0);" class="zf_num">6</a></li>
                <li><a href="javascript:void(0);" class="zf_num">7</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">8</a></li>
                <li><a href="javascript:void(0);" class="zf_num">9</a></li>
                <li><a href="javascript:void(0);" class="zf_empty">清空</a></li>
                <li><a href="javascript:void(0);" class="zj_x zf_num">0</a></li>
                <li><a href="javascript:void(0);" class="zf_del">删除</a></li>
            </ul>
        </div>
        <div class="hbbj"></div>
    </div>
 <!--  end -->
    <?php //include display('public_menu');?>
</body>
<script type="text/javascript">
    var layer;
    layui.use(['form','layer'],function(){
        var form = layui.form;
        layer = layui.layer;
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
        // $(".btn-theme").bind("click",function(){
        //     $(".platform").show();
        // });
     
        form.on("submit(subTransfer)",function(datas){
             $(".ftc_wzsf").show();
             $('#card_num').html($("[name=num]").val());
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
<script type="text/javascript">
var i = 0;
$(function(){
    // 调取支付接口
    //出现浮动层
    $(".ljzf_but").click(function(){
        $(".ftc_wzsf").show();
    });
    //关闭浮动
    $(".close").click(function(){
        $(".ftc_wzsf").hide();
        $(".mm_box li").removeClass("mmdd");
        $(".mm_box li").attr("data","");
        i = 0;
    });
        //数字显示隐藏
    $(".xiaq_tb").click(function(){
        $(".numb_box").slideUp(500);
    });
    $(".mm_box").click(function(){
        $(".numb_box").slideDown(500);
    });
        //----
    
    $(".nub_ggg li .zf_num").click(function(){
            
        if(i<6){
            $(".mm_box li").eq(i).addClass("mmdd");
            $(".mm_box li").eq(i).attr("data",$(this).text());
            i++
            if (i==6) {
                layer.load();
                    setTimeout(function(){
                    var payPwd = "";
                        $(".mm_box li").each(function(){
                        payPwd += $(this).attr("data");
                    });
                    transfer(payPwd);
                },100);
            };
        } 
    });
        
    $(".nub_ggg li .zf_del").click(function(){
        if(i>0){
            i--
            $(".mm_box li").eq(i).removeClass("mmdd");
            $(".mm_box li").eq(i).attr("data","");
        }
    });

    $(".nub_ggg li .zf_empty").click(function(){
        $(".mm_box li").removeClass("mmdd");
        $(".mm_box li").attr("data","");
        i = 0;
    });
 
});

var transfer = function (pwd){
    var data = {pwd:pwd};
    data.getAddress = $("[name=getAddress]").val();
    data.addressName = $("[name=addressName]").val();
    data.cardId = $("[name=cardId]").val();
    data.sendAddress = $("[name=sendAddress]").val();
    data.num = $("[name=num]").val();
    data.type = "transferBill";
    console.log(data);
    // return false;
    $.post("./transferBill.php",data,function(res){
        layer.closeAll("loading");
        if(!res.res){
            layer.msg(res.msg,{icon:1,skin:"demo-class"});
            setTimeout(function(){
                window.location.href = "./card_package.php";
            },2000);
        }else{
            $(".mm_box li").removeClass("mmdd");
            $(".mm_box li").attr("data","");
            i = 0;
            layer.msg(res.msg,{icon:5,skin:"demo-class"});
        }
    },"json");
}

</script>