<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>个人中心</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/css/base.css?r=1"> 
    <style type="text/css">
        html,body{
            height: 100%;
            background: #ececec;
        }
        * { touch-action: none; }
        .item-headers{
            margin: 0px auto 20px;
            background-image: url('../template/wap/default/images/my.jpg?r=234');
            background-repeat:no-repeat;
            background-size:100% 100%;
            -moz-background-size:100% 100%;
            height: 100px;
            color: #fff;
        }
        .item-header-img{
            width: 30%;
            height: 100%;
        }
        .item-header-name{
            width: 60%;
            height: 100%;
            color: #999;
        }
   
        .user_info p:first-child{
            color: #fff;
            font-size: 16px;
        }
        img{
           height: 65px;
           width: 65px;
           border-radius: 2%; 
        }
        a{
            color: #333;
        }
        .mui-table-view{
            background: #fff;
        }
        .mui-table-view-cell {
            /*padding: 6px 10px;*/
        }
        .mui-table-view:after,.mui-table-view:before {
            background-color: #fff; 
        }
        .mui-table-view-cell:after {
            right: 20px;
            bottom: 0;
            left: 20px;
            background-color: #c8c7cc;
        }
        .menu_title{
            font-size: 15px;
            color: #333;
        }

        .icon-yemiantuiguang:before {
            content: "\e600";
            color: #67ccf4;
            margin-right: 10px;
        }

        .icon-qiaquan:before {
            content: "\e63e";
            margin-right: 10px;
            color: #67ccf4;;
        }
        .icon-api:before {
            content: "\e888";
            margin-right: 10px;
            color: red;
        }

        .icon-authenticate:before {
            content: "\e666";
            color: red;
            margin-right: 10px;
        }

        .mui-icon-gear:before {
            content: '\e502';
            color: #67ccf4;
        }
        .icon-dingdan:before {
            content: "\e607";
            margin-right: 10px;
            color: #67ccf4;
        }

        .icon-shezhi:before {
            content: "\e602";
            margin-right: 10px;
            color: #75cef4;
        }
    </style>
</head>
<body>
<div class="lk-content" style="padding:0px;">
        <div class="item-headers lk-container-flex" >
            <div class="item-header-img lk-container-flex lk-justify-content-c lk-align-items-c">
                <?php  if($res['avatar']){?>
                    <img src="<?php echo $res['avatar'];?>">
                <?php }else{?>
                    <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg">
               <?php } ?></div>
            <div class="item-header-name lk-container-flex lk-align-items-c">
                   <div class="user_info">
                        <?php if($res['name']){?>
                             <p><?php echo  $res["name"];?></p>
                        <?php }else{?>
                             <p>乐卡用户</p>
                        <?php }?>

                    <p style="margin-top: 10px;color: #f0f0f0;">手机号:<?php echo $phone; ?></p>
                    </div>
            </div>

        </div>
            <ul class="mui-table-view" >
                <li class="mui-table-view-cell">
                    <a class="mui-navigate-left iconfont icon-dingdan" href="orderList.php">
                        <span class="menu_title">订单</span>
                    </a>
                </li>
                <li class="mui-table-view-cell">
                    <a class="mui-navigate-left iconfont icon-authenticate" href="postcard.php">
                        <span class="menu_title">认证</span>
                    </a>
                </li>
            </ul>
            <?php if(!empty($menu)){?>
            
            <ul class="mui-table-view" style="margin-top: 25px;">
                <?php foreach($menu as $v){?>
                <li class="mui-table-view-cell">
                    <a class="mui-navigate-left iconfont <?php echo $v['icon'];?>" href="<?php echo $v['url'];?>">
                        <span class="menu_title"><?php echo $v['title'];?></span>
                    </a>
                </li>
                <?php }?>
            </ul>
            
            <?php }?>
            <ul class="mui-table-view" style="margin-top: 25px;">
                <li class="mui-table-view-cell">
                    <a class="mui-navigate-left iconfont icon-shezhi" href="./setup.php">
                        <span class="menu_title">设置</span>
                    </a>
                </li>
            </ul>       
        </div>
</div>
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
    function showMsg(msg){
        mui.toast(msg, { icon: 5, skin: "demo-class" });
    }
    mui('body').on('tap','a',function(){
        window.top.location.href=this.href;
    });
</script>