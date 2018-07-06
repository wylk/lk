<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=345">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
      .dy1{
        margin-top: 7px;
      }
      .dy2{
        margin-top: 7px;
      }
      .dy2 img{
        width: 85px;
      }
      .dy2 h2{
        color:#228B22;margin-left:127px;margin-top:-44px;
      }
      .dy3{
        margin-top: 7px;
      }
      .dy4{
        margin-top: 7px;
      }
      .layui-col-space10{
        font-size: 17px;
      }
      button{
        width: 118px;height:39px;border: 1.3px solid #228B22;margin-left: 20px;
      }
    </style>
</head>
<body>
  <header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">选择卡券</h1>
</header>
<div class="lk-content">
  <div class="layui-container">
    <div class="layui-row dy1">
      <font size="3">
        <i style="color:red">注</i>
        <i style="margin-left: 24px;">选择要发布的会员卡有的需要保证金</i>
      </font>
    </div>
  </div>
  <hr class="layui-bg-gray">

<!-- 分割 -->
  <?php foreach($cardRes as $k=>$v){ ?>
  <div class="layui-container">
    <div class="layui-row dy2">
      <img src="http://lk.com/upload/images/000/000/001/201806/5b34850b65353.jpg">
      <h2><?= $v['contract_name'] ?></h2>
    </div>
  <br>
    <div class="layui-row dy3">
      <h3><?= $v['contract_name'] ?>：<?= $v['contract_explain'] ?></h3>
    </div>
    <br>
    <div class="layui-row dy4">
      <div class="layui-col-space10">
        <i>发布量 100</i>
        <i>|</i>
        <i>好评 80%</i>
        <i><button  class="layui-btn layui-btn-primary" id="contract_<?php echo $v['contract_title']?>">发布</button></i>
      </div>
    </div>
  </div>
  <br>
  <hr class="layui-bg-gray">
  <?php } ?>
</div>
</body>
</html>
<script type="text/javascript">
$("button[id^=contract_]").bind("click",function(res){
    console.log(this);
    var title = $(this).attr('id');
    var pos = title.indexOf("Card");
    var card = title.substring(9,pos);
    // console.log(card);
    window.location.href = "./cardmaking.php?card="+card;
    // console.log(title);
    // alert('this');
})
</script>
