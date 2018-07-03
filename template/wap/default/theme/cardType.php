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
   <table class="layui-table">
 <!--  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup> -->
  <thead>
    <tr>
      <th>卡名</th>
      <th>种类</th>
      <th>用途</th>
      <th>费用</th>
      <th>图片</th>
      <th>图片</th>
      <th>使用状态</th>
    </tr> 
  </thead>
  <tbody>
    <?php foreach($cardRes as $key => $value){?>
    <?php  if(!in_array($value['contract_title'], $cardtype)){ ?>
    <tr id="contract_<?php echo $value['id']?>" title="<?php echo $value['contract_title']?>">
      <td><?php echo $value['contract_name']?></td>
      <td><?php echo $value['contract_title']?></td>
      <td><?php echo $value['contract_explain']?></td>
      <td><?php echo $value['free']?></td>
      <td><img src="<?php echo $value['pc_logo']?>"/></td>
      <td><img src="<?php echo $value['wap_logo']?>" /></td>
      <td>未使用</td>
    </tr>
    <?php }else{?>
      <tr id="contract_<?php echo $value['id']?>" title="<?php echo $value['contract_title']?>">
      <td><?php echo $value['contract_name']?></td>
      <td><?php echo $value['contract_title']?></td>
      <td><?php echo $value['contract_explain']?></td>
      <td><?php echo $value['free']?></td>
      <td><img src="<?php echo $value['pc_logo']?>"/></td>
      <td><img src="<?php echo $value['wap_logo']?>" /></td>
      <td>正在使用</td>
    </tr>
    <?php } } ?>
  </tbody>
</table>
</body>
</html>
<script type="text/javascript">
$("tr[id^=contract_]").bind("click",function(res){
    console.log(this);
    var title = $(this).attr('title');
    var pos = title.indexOf("Card");
    var card = title.substr(0,pos);
    // console.log(card);
    window.location.href = "./cardmaking.php?card="+card;
    // console.log(title);
    // alert('this');
})
</script>