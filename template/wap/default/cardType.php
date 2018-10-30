<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    
    <style type="text/css">
    html body p{
        padding: 0px;
        margin: 0px;  
    }
    html body {
        border-color: #f0f0f0;
        height: 100%;  
    }
    .container{
        background-color: #fff;
        width: 95%;
        margin:5px auto;
        font-size: 12px;
        color: #999;
        border:1px solid #f0f0f0;
        height: 40px; 
        line-height: 20px;
    }
    .cards{
        min-height: 400px;
        margin: 10px auto;
        width: 95%;
    }
    .card{
        height: 120px;
        width: 100%;
        border:1px solid #f0f0f0;
        margin-bottom: 10px;
        border-radius: 1px;
    }
    .card-b{
        width: 95%;
        margin:5px auto 0px;
    }
    .card_titles{
        height: 80px;
        display: flex;
    }
    .card_title{
        height: 100%;
        width: 30%;
    }
    .card_title img{
        height: 100%;
        width: 100%;
    }
    .card_title p:first-child{
        color: #333;
        font-size: 18px;
        line-height: 45px;
    }
    .flex-grow{
        flex-grow:1;
        padding-left: 10px;
    }
    .card_infos{
        height: 35px;
        display: flex;
        justify-content: space-around;
    }
    .card_info{
        width: 30%;
        line-height:38px;
        font-size: 12px;
        color: #999;
        text-align: center;
    }

    .btn{
        display:block;
        color:#999;
        text-decoration:none;
    }
    .btn span{
        font-size: 15px;
        color:#10a3d2;
    }
    </style>
</head>
<body>
<div class="lk-content">
    <div class="container">
        <span style="color:#333">&nbsp;&nbsp;&nbsp;注 :</span>
        选择要发布的会员卡有的提现时按发布的卡券比例锁住平台币;交易完成后可以解除锁定
    </div>
    <div class="cards">
        <?php foreach($cardRes as $k=>$v){  ?>
    
        <div class="card">
            <div class="card-b">
                <div class="card_titles">
                    <div class="card_title">
                        <img src="<?php echo $v['wap_logo'];?>">
                    </div>
                    <div class="card_title flex-grow">
                        <p> <?= $v['contract_name'] ?></p>
                        <p style="font-size: 12px;color: #999;"><?= $v['contract_explain'] ?></p>
                    </div>
                </div>
                <div class="card_infos">
                    <div class="card_info">发布量: 100</div>
                    <div class="card_info">好评: 80%</div>
                    <div class="card_info">
                         <?php if(!in_array($v['contract_title'], $cardtype)){?>
                            <a href="javascript:;" class="btn" data-type="1" data-card="contract_<?php echo $v['contract_title']?>"><span>+</span>&nbsp;发卡</a>
                        <?php }else{ ?>
                            <a href="javascript:;" class="btn" data-type="2"><span>+</span>&nbsp;管理卡券</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
       <?php } ?>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
<script type="text/javascript">

    $(function(){
        $('.btn').click(function(){
            var t = $(this);
            var type = t.data('type');
            if(type == 1){
                var title = t.data('card');
                var card = title.substring(9,title.indexOf("Card"));
                console.log(card);
                window.location.href = "./cardmaking.php?card="+card;
            }else if(type == 2){
                window.location.href='./cardList.php';
            }
        })
    })
</script>
