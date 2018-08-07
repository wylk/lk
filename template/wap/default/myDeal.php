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
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
  <style type="text/css">
    .lk-rows{
      min-height: 100px;
      margin: 10px auto;
      background-color: #fff;
    }
    #laytable-cell-space{
      text-align: center;
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
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">我的交易</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">
    <div class="lk-rows">     
       <table lay-skin="line" class="layui-table laytable-cell-space">
        <colgroup>
          <col width="20%">
          <col width="17%">
          <col width="38%">
          <col >
        </colgroup>
        <thead >
          <tr >
            <th id="laytable-cell-space">用户</th>
            <th id="laytable-cell-space">交易量</th>
            <th id="laytable-cell-space">对方地址</th>
            <th id="laytable-cell-space">时间</th>
          </tr> 
        </thead>
        <tbody>
          <?php foreach($orderList as $key=>$value) { ?>
          <tr>
            <td>卖</td>
            <?php if($value['send_address'] == $address){ ?>
              <td style="color:red;">-<?php echo number_format($value['num'],2); ?></td>
              <td><?php echo substr($value['get_address'],0,15); ?></td>
            <?php }else{ ?>
              <td style="color:green;">+<?php echo number_format($value['num'],2); ?></td>
              <td><?php echo substr($value['send_address'],0,15); ?></td>
            <?php } ?>
            <td><?php echo date("Y-m-d H:i:s",$value['createtime']); ?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
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