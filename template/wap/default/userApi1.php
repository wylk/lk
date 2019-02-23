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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/clipboard.min.js" charset="utf-8"></script>
    <style type="text/css">
      .layui-container{padding: 0 8px;}
      /*登录样式*/
      .layui-form{margin-top: 100px;}
      .layui-input-block{margin-right: 50px;}
      .layui-input{border:0; padding-left:6px;}
      .layui-form-item .layui-input-inline.us-input-inline{display: inline-block; float: none; left: 0;  width: auto; margin: 0; padding: 10px 0 10px 0px;}
      .layui-form-item{margin: 0; line-height: 45px;color: #333;}
      .us-btn{background-color: #FFF; color:#FF5722; font-weight: 500}
      .us-btn:hover{color:#FF5722;}
      .layui-form-item .layui-form-label{margin-top:10px;}
      .layui-row{border-radius: 3px;}
      /*账号样式*/
      .api_block{padding: 10px 0px;background: white; border-radius: 5px;margin-top:5px;}
      .api_line{border-top:1px solid #ddd;}
      .api_span{background:white;height:40px;line-height: 40px;color: #333;display: flex;align-items: center;}
      .api_attr{display: block;float:left;margin:auto 10px;width: 45px;text-align: right;}
      .api_input{display: block;float:left;width: 65%;overflow:scroll;}
      .api_btn{float:right;margin-left:10px;height:25px;line-height: 25px;padding:2px 6px;border-radius: 3px;background: #a9e6ef;}

      /*接口样式*/
      .inter{background: white;margin-top:5px;border-radius: 5px;padding:10px 0px;margin-bottom: 30px;}
      .inter_block{border:1px solid #f2f2f2;border-radius:4px;margin:15px 5px;display: flex;align-items: center;padding:8px;flex-direction: column;}
      .inter_row{/*border:1px solid red;*/width: 100%;}
      .inter_img{background-image: url(../template/wap/default/images/logo.jpg);background-size: 40px 40px;background-repeat: no-repeat;display: block;width: 40px;height: 40px;float: left;}
      .inter_name{color:#333;font-size: 17px;margin-left: 5px;}
      .inter_attr{font-size:12px; color:#999;padding:0 4px;}
      .attr_left{float: left;margin-left: 42px;}
      .attr_right{float:right;}
      .inter_num{font-size:14px;color:#333;}
      /*开关样式*/
      .switch_block{float: right;height:40px;}
      .switch_opt{display: flex;align-items: center;flex-direction: row;}
      .switch{width: 28px;height: 20px;border:1px solid #a9e6ef;border-radius:1px;font-size: 12px;}
      .switch_on{color:white;background:#a9e6ef;display: flex;align-items: center;justify-content: center;}
      .switch_off{color:#333;background:#f2f2f2;display: flex;align-items: center;justify-content: center;border:1px solid #f2f2f2;}

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

<body style="background-color: #f2f2f2;">
  <div class="layui-container" style="padding-top:15px;">
      <?php if(empty($userInfo['mid'])){ ?>
    <form class="layui-form" action="javascript:;">
      <div class="layui-row" style="border:1px solid #d2d2d2; background-color: #FFF; margin-bottom:50px;">
        <div class="layui-col-xs12">
            <div class="layui-form-item">
                <label class="layui-form-label">手机号码</label>
                <div class="layui-input-inline us-input-inline" style="padding-left:0px;">
                    <input type="text" name="phone" id="phone" required lay-verify="phoneNumber" placeholder="<?php echo $phoneShow ?>" autocomplete="off" class="layui-input" value="<?php echo $phoneShow; ?>" readonly>
                </div>
            </div>
            <div class="layui-form-item"  style="border-top:1px solid #F0F0F0">
              <div class="layui-input-inline us-input-inline" style=" border-right:1px solid #F0F0F0">
                    <input type="text" name="password" required lay-verify="passVerify" placeholder="请输入手机验证码" autocomplete="off" class="layui-input" style="float:right; width: 78%">
              </div>
                <a href="javascript:;"  id="getVerify" class="layui-btn us-btn">获取验证码</a>
            </div>
        </div>
      </div>
      <div class="layui-row">
      <button id="layui-btn" class="layui-btn" style="width:100%;">申请商户号</button>
      </div>
    </form>
<?php }else{ ?>
    <div style="font-size: 17px;">接口账号</div>
    <div class="api_block">
      <div class="api_span">
        <span class="api_attr">appid:</span>
        <span class="api_input" id="api"><?php echo $userInfo['mid'] ?></span>
        <span class="api_btn" id="copy_api" data-clipboard-target="#api">复制</span>
      </div>
      <div class="api_line"></div>
      <div class="api_span">
        <span class="api_attr">key:</span>
        <span class="api_input" id="key"><?php echo $userInfo['mid_key'] ?></span>
        <span class="api_btn" id="copy_key" data-clipboard-target="#key">复制</span>
      </div>
    </div>
    <!-- 接口开关 -->
    <div style="margin-top: 80px;font-size: 17px;">接口管理</div>
    <div class="inter" >
      <?php foreach($inter_arr as $key=>$value){ ?>
      <div class="inter_block">
        <div class="inter_row" style="height: 40px;line-height: 40px;">
          <span class="inter_img"></span>
          <span class="inter_name">会员卡支付<?php echo $key ?></span>
          <span class="switch_block switch_opt">
            <div class="switch_opt" id="on_<?php echo $key; ?>" <?php if(!$value['status']) echo "style='display:none'" ?> >
              <div class="switch"></div>
              <div class="switch switch_on">ON</div>
            </div>
            <div class="switch_opt" id="off_<?php echo $key; ?>" <?php if($value['status']) echo 'style="display: none;"' ?> >
              <div class="switch switch_off">OFF</div>
              <div class="switch" style="border:1px solid #f2f2f2;"></div>
            </div>
          </span>
        </div>
        <div class="inter_row">
          <?php foreach($value as $k=>$v){ ?>
          <?php if(!is_array($v)) continue; ?>
          <span class="inter_attr <?php echo ($k%2==0)?"attr_left" : "attr_right"; ?>"><?php echo $v['inter_name'] ?>：<i class="inter_num"><?php echo $v['num']; ?>次</i></span>
          <?php } ?>
        </div>
      </div>
      <?php  } ?>
    </div>
  </div>
<?php } ?>
</body>
</html>
<script type="text/javascript">
  var layer;
  layui.use(['layer'],function(){
    layer = layui.layer;
  });
  $("#getVerify").bind("click",function(){
    var data = {type:"verify"};
    $.post("./userApi.php",data,function(res){
      if(res.messageRes)
        layer.msg("验证码发送成功",{icon:1,skin:'demo-class'});
      else 
        layer.msg("验证码发送失败",{icon:5,skin:'demo-class'});
    },"json");
  });
  $("#layui-btn").bind("click",function(){
    var pwd = $("[name=password]").val();
    if(pwd.length != 6){
      layer.msg("验证码不正确",{icon:5,skin:'demo-class'});
      return;
    }
    var data = {type:'apply',pwd:pwd};
    $.post("./userApi.php",data,function(res){
      if(!res['res']){
        layer.msg(res.msg,{icon:1,skin:'demo-class'});
        setTimeout(function(){
          window.location.reload(true);
        },1000);
      }else
        layer.msg(res.msg,{icon:5,skin:'demo-class'});
    },"json");
  });
  // 开关
   $("[id^=on_]").bind('click',function(){
      var idStr = $(this).attr('id');
      var val = idStr.substr(idStr.indexOf("_")+1);
      // $(this).hide();
      // $("#off_"+val).show();
      swtich_status(val,0);
   });
   $("[id^=off_]").bind("click",function(){
      var idStr = $(this).attr("id");
      var val = idStr.substr(idStr.indexOf('_')+1);
      // $(this).hide();
      // $("#on_"+val).show();
      swtich_status(val,1);
   });
   function swtich_status(val,status){
    var data = {type:'switch',val:val,status:status}
    console.log(data);
    $.post("./userApi.php",data,function(result){
      console.log(result);
      if(result['res']){
        layer.msg(result['msg'],{ icon: 5, skin: "demo-class" });
      }else{
        layer.msg(result['msg'],{ icon: 1, skin: "demo-class" });
      }
        setTimeout(function() {
          window.location.reload();
        }, 1000);
    },"json");
   }
   // 点击复制
   $("[id^=copy_]").bind("click",function(){
      var idStr = $(this).attr("id");
      console.log(idStr);
      var clipboard = new ClipboardJS("#"+idStr);
      clipboard.on("success",function(e){
          e.clearSelection();
          layer.msg("复制成功",{ icon: 1, skin: "demo-class" });
      })
      clipboard.on("error",function(e){
          layer.msg("复制失败",{ icon: 5, skin: "demo-class" });
      })
   });

</script>
