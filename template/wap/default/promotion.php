<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>二维码</title>
    <style type="text/css">
        *{
            padding: 0px;
            margin: 0px;
        }
        html, body,.content{
            height: 100%;
        }
        .content{
            display: flex;
            align-items: center;
            justify-content: space-around; 
            background-image: url('../template/wap/default/images/code.png?r=3');
            background-repeat:no-repeat;
            background-size:100% 100%;
            -moz-background-size:100% 100%; 
        }
        .display-a-j{
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .codeAddress{ 
            height: 70%; 
            width: 90%;
            color: #999; 
            border-radius: 5px;
            background: #fff;
            border:1px solid #f0f0f0;
        }
        .code{
            width:250px;
            height:250px;
            margin:auto;
        }
        .code img{
            height: 100%;
            width: 100%;
        }
        #getAddress{
            text-align:center;
        }
        .otherFunc{
            padding:0px 20px;
        }
        .codeAddress h4{
           height: 10%;
            color: #333;
           
        }
        .getAdd{
            height: 25%;
           
        }
        .getAdd p{
            margin: 0px auto;
        }
    </style> 
</head>

<body>
    
    <div class="content">
        <div class="codeAddress">
           <h4 class="display-a-j"><?=$card['val'];?></h4>
            <div class="code"><img src="./qrcode.php?type=store&mid=<?=$wap_user['userid'];?>&cardId=<?=$card['card_id']?>" /></div>
            <div class="getAdd display-a-j" data-clipboard-target="#getAddress" id="copyAddress">
                <p id="getAddress" >扫描购卡,让消费更省钱</p>
            </div>
        </div>
    </div>
    <?php //include display('public_menu');?>
</body>

</html>
