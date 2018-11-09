<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.slidingPage.js?r=random()" charset="utf-8"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script> -->
    <style type="text/css">
    </style>
</head>
<body>
<div id="pullrefreshs" style="touch-action: none;" class="mui-content mui-scroll-wrapper">
<div style="margin:20px" id="content">
</div>

</body>
</html>

<script type="text/javascript">
$(function(){
  slidingPage("./testh.php","content");
});
function strFunc(data){
  var str = '';
  str += '<div style="margin:5px;height: 50px;border:1px solid red;">';
  str += '<div style="width: 70%;float: left;overflow: hidden;">';
  str += '<span style="float:left">'+data['send_address']+'</span>';
  str += '<span style="float:left;">'+data['get_address']+'</span></div>';
  str += '<div style="width:20%;float: left;margin-left: 8px;text-align: center;">'+data['num']+'</div></div>';
  return str;
}
</script>
