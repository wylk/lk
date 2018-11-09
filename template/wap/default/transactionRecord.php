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
  <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css" type="text/css">
  <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.slidingPage.js?r=<?php echo time(); ?>" charset="utf-8"></script>
  <style type="text/css">
/*    .lk-rows{
      min-height: 100px;
      margin: 10px auto;
      background-color: #fff;
    }
    #laytable-cell-space{
      text-align: center;
    }*/
    p{padding:0;margin:0;}
    .layui-container p{ line-height: 25px;}
        .layui-container p i { color: red; margin-right: 10px;}
        .layui-tab-content { height: auto}
        .lk-content hr{margin: 0}
        .lk-container-flex {padding: 0 5px;}
        .order-left{width: 63%;}
        .order-left p{color: #999;}
        .order-right{width: 42.9%;text-align: right;}
        .order-right a{padding: 5px 2px;font-weight: bold;color: #333;}
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
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">全部交易</h1>
  </header>
<div class="lk-content">
  <div class="layui-container" id="pullrefreshs" style="touch-action: none;overflow: auto;height: 500px;">
    <div class="layui-tab" lay-filter="aduitTab" id="content"></div>
  </div>
</div>
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
// var table = layui.table;
//  console.log(table);
//转换静态表格
// table.init('demo', {
//   height: 315 //设置高度
//   ,limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
//   //支持所有基础参数
// });
// ***************** 分页 start *****************
$(function(){
    inter("./transactionRecord.php?cardId=<?php echo $cardId ?>",'.layui-container','#pullrefreshs','#content');
});
function strFunc(data){
  var num = Number(data['num']);
  var str = '';
  str += '<div class="lk-container-flex">';
    str += '<div class="order-left">';
      str += '<p>账户:'+data['send_address'].substring(0,20)+'...</p>';
      str += '<p>转到:'+data['get_address'].substring(0,20)+'...</p>';
    str += '</div>';
    str += '<div class="order-right">';
      str += '<p style="color: red"><span class="total">'+num.toFixed(2)+'hsr</span></p>';
      str += '<p><a href="javascript:;">'+getTime(data['createtime'])+'</a></p>';
    str += '</div>';
  str += '</div><hr>';
  return str;
}
// ***************** 分页 end *****************
</script>