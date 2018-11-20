<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>卡券管理</title>
   <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
  <style type="text/css">
    *{
        padding: 0px;margin:0px;
    }
    html,body{
        height: 100%;
    }
    a{
        color: #999;
    }
    .content {
        height: 100%;
        background-color: #f2f2f2;
        color: #999;
    }
    .color-black3{
        color: #333;
    }
    .mar-top{
        margin-top: 2px;
    }
    .card{
        font-size: 14px;
        position: relative;
        overflow: hidden;
        margin: 10px;
        border-radius: 5px;
        background-color: #fff;
        background-clip: padding-box;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .3);

    }
    .card-title{
        height: 100px;
        margin: 10px 20px;
        background-image: url('../template/wap/default/images/card2.jpg?r=3322');
        background-repeat:no-repeat;
        background-size:100% 100%;
        -moz-background-size:100% 100%;
        border-radius: 5px;
        padding:10px;
    }
    .card-name{
        text-align: center;
        margin-top: 30px;
        font-size: 20px;
        color: #333;
        font-weight:bold;
    }
    .mui-card-content-inne{
        display: flex;
        justify-content:space-around;
    }
    .card_info{
        width: 20%;
        height: 50px;
        text-align: center;
    }

    .data-line-header{
        font-size: 14px;
        padding: 0px 5px;
        min-height: 26px;
    }

    .data-line-content{
        height: 88%;
       /*  background-image: url('../template/wap/default/images/856880807256349200.jpg?r=33');
       background-repeat:no-repeat;
       background-size:100% 100%;
       -moz-background-size:100% 100%;   */
    }

    .user-card-edit{
        line-height: 30px;
        text-align: center;
        width: 23%;
        border-right:1px solid #c8c7cc;
    }
    .user-card-infos{
        height: 60px;
        display: flex;
        justify-content:center;
    }
    .user-card-info{
        width: 32%;
        line-height: 60px;
        text-align: center;
    }
    .user_card_info_span{
        color: #29aee7;
        font-size: 16px;
    }
  </style>
</head>
<body>
   <div class="content" style="padding-top:1px;">
        <div class="card">
            <div class="mui-card-content-inner card-title">
                <div class="card-id" style="overflow: hidden;color:#333">
                    <?=$card['card_id'];?>
                </div>
                <div class="card-name">
                    <?=$card['val'];?>
                </div>
                <div></div>
            </div>
            <!--  <a href="transactionRecord.php?cardId=<?php echo $value['card_id']; ?>">全部交易</a>
                        <a href="cardRecord.php?cardId=<?php echo $value['card_id'] ?>" class="lk-row-btn">持卡记录</a> -->
            <div class="mui-card-content-inne">
                <div class="card_info">
                    <div class="color-black3"><?=$sum['val']?></div>
                    <div class="mar-top">发布总数</div>
                </div>
                <div class="card_info">
                    <div class="color-black3"><?=$count_fand;?></div>
                    <div class="mar-top"><a href="cardRecord.php?cardId=<?php echo $user_card['card_id'] ?>">会员</a></div>
                </div>
                <div class="card_info">
                    <div class="color-black3"><?=$count_record;?></div>
                    <div class="mar-top"><a href="transactionRecord.php?cardId=<?php echo $user_card['card_id']; ?>">转账记录</a></div>
                </div>
            </div>
        </div>

         <div class="card" style="height: 40%">
            <div class="mui-card-header data-line-header">交易数据</div>
            <div class="data-line-content" id="lineChart">
            </div>
        </div>

        <div class="card">
            <div class="user-card-infos">
                <div class="user-card-info">可用：<span style="color: #333"><?= round(($user_card['num']),2);?></span></div>
                <div class="user-card-info" style="">锁定：<?= round($user_card['frozen'],2);?></div>
                <div class="user-card-info"><a href="./home.php?card_id=<?=$user_card['card_id'];?>&plugin=offset&shoreUid=<?=$user_card['uid'];?>"><span class="user_card_info_span">+</span> &nbsp;店铺</a></div>
            </div>



            <div class="mui-card-footer" style="padding: 7px 15px">
                <div class="user-card-edit"><a href="transferBill.php?cardId=<?=$user_card['card_id']?>">转账</a></div>
                 <div class="user-card-edit"><a href="changeInto.php?id=<?= $user_card['id'];?>" >充值</a></div>
                <div class="user-card-edit"><a href="recordBooks.php?cardId=<?=$user_card['card_id']?>">账单</a></div>
                <div class="user-card-edit" style="border:0;"><a href="transaction.php?cardId=<?=$user_card['card_id']?>">交易</a></div>
            </div>
        </div>

    </div>
<?php //include display('public_menu');?>
</body>
</html>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js" charset="utf-8"></script>
<script src="<?php echo STATIC_URL;?>mui/libs/echarts-all.js"></script>
<script type="text/javascript">
$(function(){

    $("a[id^=transaction_]").bind("click",function(res){
        var cardId = $(this).attr("title");
        window.location.href = "./transaction.php?cardId="+cardId;
    })
})


</script>

    <script>
            var getOption = function(chartType) {
                var chartOption =  {
                    legend: {
                        data: ['售出','转账','核销']
                    },
                    grid: {
                        x: 35,
                        x2: 10,
                        y: 30,
                        y2: 25
                    },
                    toolbox: {
                        show: false,
                        feature: {
                            mark: {
                                show: true
                            },
                            dataView: {
                                show: true,
                                readOnly: false
                            },
                            magicType: {
                                show: true,
                                type: ['line', 'bar']
                            },
                            restore: {
                                show: true
                            },
                            saveAsImage: {
                                show: true
                            }
                        }
                    },
                    calculable: false,
                    xAxis: [{
                        type: 'category',
                        data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                    }],
                    yAxis: [{
                        type: 'value',
                        splitArea: {
                            show: true
                        }
                    }],
                    series: [{
                        name: '售出',
                        type: chartType,
                        data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                    },{
                        name: '转账',
                        type: chartType,
                        data: [2.1, 4.2, 7.3, 2.2, 20.6, 70.7, 6, 16, 24.6, 25.0, 63.4, 31.3]
                    },{
                        name: '核销',
                        type: chartType,
                        data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
                    }]
                };
                return chartOption;
            };
            var byId = function(id) {
                return document.getElementById(id);
            };
            var lineChart = echarts.init(byId('lineChart'));
            lineChart.setOption(getOption('line'));


        </script>
