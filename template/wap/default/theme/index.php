<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>  -->
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <script type="text/javascript">   
        var plugin = '<?php echo isset($_GET['plugin'])?$_GET['plugin']:1;?>';
    </script>
    <style type="text/css">
        .lk-titles{
          border-bottom: 1px solid #f0f0f0;
          height: 40px;
          display: flex;
        }
        .lk-ti{
          width: 25%;
          line-height: 40px;
          text-align: center;
        }
        .action{
          color: red;
          border-bottom: 1px solid red; 
        }
        .stores{
          margin: 0 auto;
          text-align: center;
          width: 95%;
        }
        .store{
          margin-top:10px;
          display: flex;
          line-height: 50px;
        }
        .img{
          width: 20%;
        }
        .price{
           width: 50%;
        }
        .num{
           width: 35%;
        }
        .imgs{
          height: 37px;
          width: 37px;
          margin: 5px auto;
          border-radius:50%;
        }
        .num a{
          border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="pullrefreshs" style="touch-action: none;">
        <div>
            <!-- <header class="lk-bar lk-bar-nav">
                <i class="iconfont" style="font-size: 20px;">&#xe697;</i>
                <h1 class="lk-title">首页</h1>
            </header> -->
            <div class="lk-content" style="padding-top:0px ">
                <div class="lk-titles">
                    <div class="lk-ti <?php echo $_GET['plugin']==1 || empty($_GET['plugin'])?'action':'';?>" data-id="1">抵现卡</div>
                    <div class="lk-ti <?php echo $_GET['plugin']==2 ?'action':'';?>" data-id="2">积分卡</div>
                    <div class="lk-ti <?php echo $_GET['plugin']==3 ?'action':'';?>" data-id="3">投票卡</div>
                    <div class="lk-ti <?php echo $_GET['plugin']==4 ?'action':'';?>" data-id="4">自选</div>
                </div>
                <div class="stores" >
                   <!--  <?php foreach ($storeInfo as $k => $v) { ?>
                         <div class="store">
                           <div class="img">
                               <img src="<?php echo $arrs[$v['uid']]['card_log'] ?>" class="imgs"/>
                           </div >
                           <div class="price"><?php echo $v['enterprise'] ?></div>
                           <div class="num">
                               <a  href="./home.php?shoreUid=<?php echo $v['uid'] ?>" class="layui-btn home">交易</a>
                           </div>
                         </div>
                     <hr>
                   <?php } ?> -->
                </div>
            </div>
        </div>
    </div>
  	<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js?r=<?=time();?>"></script>

  
