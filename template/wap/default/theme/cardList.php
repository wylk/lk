<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
</head>
<body>
    <div class="layui-main" style="height:20px;width:100%;"><a href="./my.php">返回</a></div>
<table class="layui-table">
    <tbody>
        <?php foreach($cardListRes as $key=>$value){ ?>
           <?php if($value['is_publisher'] != 0){ ?>
        <tr >
          <td colspan="2"></td>
          <td align="right">发布中</td>
        </tr>
        <tr id="contract_<?php   ?>" title="<?php  ?>">
          <td rowspan="3"><img src="<?php echo $value['card_log'] ?>" /></td>
          <td>数量：<?php echo $value['sum'] ?></td>
          <td rowspan="2"><?php echo $value['describe']?></td>
        </tr>
        <tr id="contract_<?php  ?>" title="<?php ?>">
          <td>价格：<?php echo $value['price'] ?></td>
        </tr>
        <tr id="contract_<?php  ?>" title="<?php  ?>">
          <td>剩余<?php  ?> 共<?php echo $value['num'] ?></td>
          <td></td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
</body>
</html>
<script type="text/javascript">

</script>