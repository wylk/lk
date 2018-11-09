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
1541742628<br/>
<?php echo date("Y-m-d H:i:s","1541742628"); ?><br/>
<span id="a"></span>
<span id="b"></span>
</body>
</html>

<script type="text/javascript">
  $(function(){
    var time = getTime("1541742628");
    var time2 = getTime('');
    $("#a").html(time);
    $("#b").html(time2);
  })
function getTime(time=null){
  var date = new Date();
  if(time){
    date.setTime(time * 1000);
  }
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  m = m < 10 ? ("0"+m) : m;
  var d = date.getDate();
  d = d < 10 ? ("0" + d) : d;
  var h = date.getHours();
  h = h < 10 ? ("0" + h) : h;
  var i = date.getMinutes();
  i = i < 10 ? ("0" + i) : i;
  var s = date.getSeconds();
  s = s < 10 ? ("0" + s) : s;
  // console.log(time,time,y,m,d,h,s);
  return y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
}
</script>
