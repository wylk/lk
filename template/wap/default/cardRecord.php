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
    <h1 class="lk-title">持卡记录</h1>
  </header>
<div class="lk-content">
    <?php if(!empty($recordList)){ ?>  
    <div class="lk-rows">   
       <table lay-skin="line" class="layui-table laytable-cell-space">
        <colgroup>
          <col width="20%">
          <col width="20%">
          <col width="20%">
          <col >
        </colgroup>
        <thead >
          <tr >
            <th id="laytable-cell-space">头像</th>
            <th id="laytable-cell-space">用户</th>
            <th id="laytable-cell-space">现有数量</th>
            <th id="laytable-cell-space">转出数量</th>
            <th id="laytable-cell-space">转入数量</th>
          </tr> 
        </thead>
        <tbody>
          <?php foreach($recordList as $key=>$value) { ?>
          <tr>
            <td><img src="<?php echo !empty($userInfo[$value['uid']]['avatar']) ? $userInfo[$value['uid']]['avatar'] : 'http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg' ?>" style="border-radius: 20%;width: 100%;"  /></td>
            <td><?php echo mb_substr($userInfo[$value['uid']]['name'], 0,2,"utf-8") ?></td>
            <td><?php echo number_format($value['num']+$value['frozen'],2) ?></td>
            <td><?php echo number_format($value['sell_count']) ?></td>
            <td><?php echo number_format($value['recovery_count']) ?></td>
           
          </tr>
            <?php }?>
        </tbody>
      </table>
    </div>
    <?php }else{?>
      <div class="layui-container">
        <div class="layui-tab" lay-filter="aduitTab">
          <div style="margin: 50px auto;text-align: center;"><h3>暂无持卡记录</h3></div>
        </div>
      </div>
    <?php }?>
</div>
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
var table = layui.table;
 console.log(table);
//转换静态表格
// table.init('demo', {
//   height: 315 //设置高度
//   ,limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
//   //支持所有基础参数
// });
</script>