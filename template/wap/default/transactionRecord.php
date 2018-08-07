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
/*    .lk-rows{
      min-height: 100px;
      margin: 10px auto;
      background-color: #fff;
    }
    #laytable-cell-space{
      text-align: center;
    }*/
    .layui-container p{ line-height: 25px;}
        .layui-container p i { color: red; margin-right: 10px;}
        .layui-tab-content { height: auto}
        .lk-content hr{margin: 0}
        .lk-container-flex {padding: 0 5px;}
        .order-left{width: 63%;}
        .order-right{width: 36.9%;text-align: right;}
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
  <div class="layui-container">
    <div class="layui-tab" lay-filter="aduitTab">
        <?php if(!empty($orderList)){?>
            <?php  foreach($orderList as $key=>$value){ ?>
            <div class="lk-container-flex">
                <div class="order-left">
                    <p>账户:<?php echo substr($value['get_address'],0,24) ?>...</p>
                    <p>转到:<?php echo substr($value['send_address'],0,24) ?>...</p>
                </div>
                <div class="order-right">
                    <p style="color: red"><span class="total"><?php echo number_format($value['num'],2)?>hsr</span></p>
                    <p><a class="" style="padding: 5px 2px;font-weight: bold;" href=""><?php echo date("Y-m-d H:i:s",$value['createtime']) ?></a></p>
                </div>
            </div>
            <hr>
            <?php } ?>
        <?php }else{?>
            <div style="margin: 50px auto;text-align: center;"><h3>暂无账单记录</h3></div>
        <?php }?>
    </div>
           
    </div>
   
</div>
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
var table = layui.table;
 console.log(table);
//转换静态表格
table.init('demo', {
  height: 315 //设置高度
  ,limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
  //支持所有基础参数
});
</script>