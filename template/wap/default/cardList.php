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
    .lk-row{
      min-height: 200px;
      width: 95%;
      margin: 2px auto;
    }
    .lk-row-title{
      height: 45px;
      line-height: 45px;
    }
    .lk-row-title>span{
      font-weight: bold;
      font-size: 18px;
    }
    .lk-row-infos{
        height: 90px;
        display: flex;
        justify-content: space-between;
    }
    .lk-row-info{
        height: 90px;
        width: 35%;
    }
    .info-grow{
        flex-grow:1;
        line-height: 27px;
        padding-left: 50px;
    }
    .lk-row-btns{
        height: 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lk-row-btn{
        border-radius: 5px;
        border: 1px solid #259B24;
        height: 35px;
        width: 18%;
        text-align: center;
        line-height: 35px;
    }
    .info-btn{
        width: 35%;
        height: 28px;
        line-height: 28px;
        color: #259B24;
    }
    .info-edit{
        display: flex;
        justify-content:space-between;
    }
  </style>
</head>
<body>
   <header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title"  >卡券管理</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">
    <div class="lk-rows"> 

    <?php foreach ($cardBagList as $key => $value) { ?>
      <div class="lk-row">
        <div class="lk-row-title"><span>抵现卡:</span><?php echo $value['card_id']; ?></div>
        <div class="lk-row-infos">
            <div class="lk-row-info info-logo">
                <img src="https://free.modao.cc/uploads3/images/1907/19079609/raw_1523959707.jpeg" style="height: 100%;width: 100%;">
            </div>
            <div class="lk-row-info info-grow" >
                <div>
                    <p>累计核销:<?php echo number_format($value['recovery_count'],2); ?></p>
                    <p>累计出售:<?php echo number_format($value['sell_count'],2); ?></p>
                </div>
                <div class="info-edit">
                    <p>未  售:<?php echo number_format($value['num'],2); ?></p> <a class="lk-row-btn info-btn" id="transaction_<?php echo $key;?>" title="<?php echo $value['card_id']; ?>">交易</a>
                </div>
            </div>
        </div>
        <div class="lk-row-btns">
            <a href="" class="lk-row-btn">设置</a>
            <a href="myDeal.php?cardId=<?php echo $value['card_id']; ?>" class="lk-row-btn">我的交易</a>
            <a href="transactionRecord.php?cardId=<?php echo $value['card_id']; ?>" class="lk-row-btn">全部交易</a>
            <a href="cardRecord.php?cardId=<?php echo $value['card_id'] ?>" class="lk-row-btn">持卡记录</a>
        </div>
      </div>
      <hr class="layui-bg-gray">
    <?php }?>

    </div>
</div>
<?php include display('public_menu');?>
</body>
</html>
<script type="text/javascript">
  $("a[id^=transaction_]").bind("click",function(res){
    console.log(res)
    var cardId = $(this).attr("title");
    console.log(cardId);
    window.location.href = "./transaction.php?cardId="+cardId;
  })

</script>