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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
    .layui-container p{ line-height: 35px;}
    .layui-container p i { color: red; margin-right: 10px;}
    .layui-tab-content { height: auto}
    .lk-content hr{margin: 0}
    .lk-container-flex {padding: 0 5px;}
    .order-left{width: 63%}
    .order-right{width: 37%;text-align: right;}
    .layui-tab-title li{min-width: 30px;}
    .margin-t10{
        margin-top:5px; 
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
        <i onclick="javascript:history.back(-1);" class="iconfont">&#xe697;</i>
        <h1 class="lk-title">订单管理</h1>
    </header>
    <div class="lk-content">
         <div class="layui-container">
            <div class="layui-tab layui-tab-brief" lay-filter="aduitTab">
                <ul class="layui-tab-title">
                    <li class="layui-this ">全部订单</li>
                    <li class="">未付款订单</li>
                    <li class="">付款订单</li>
                    <li class="">评价</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show ">
                        <?php foreach($orderList as $key=>$value){ ?>
                        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell margin-t10">
                            <div class="order-left">
                                <p><span class="b">买入</span> 单号：<?php echo $value['onumber'] ?></p>
                                <p><?php echo date("Y-m-d H:i:s",$value['create_time']) ?>下单</p>
                                <p>数量：<?php echo number_format($value['number'],2)?></p>
                            </div>
                            <div class="order-right">
                                <p><a class="layui-btn layui-btn-warm" style="padding:5px 7px;height: 30px; line-height:19px;border-radius: 5px;" href="./orderDetail.php?id=<?php echo $value['id']; ?>">查看详情</a></p>
                                <p>价格：<?php echo number_format($value['price'],2); ?></p>
                                <p style="color: #2F4056">
                                    <?php if($value['status']==0) echo "<a style='color:red' href='./pay.php?id={$value['id']}'>付款</a>"; ?>
                                    <?php if($value['status']==1) echo "交易成功"; ?>
                                    <?php if($value['status']==2) echo "订单取消"; ?>
                                    <?php if($value['status']==3) echo "已付款"; ?>
                                    <?php if($value['status']==4) echo "订单超时"; ?>

                                <p>总金额：<span class="total"><?php echo number_format($value['price']*$value['number'],2); ?></span></p>
                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div>
                    <div class="layui-tab-item ">
                        <?php foreach($unpaidOrderList as $key=>$value){ ?>fdgsdfg
                        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell margin-t10">
                            <div class="order-left">
                                <p><span class="b">买入</span> 单号：<?php echo $value['onumber'] ?></p>
                                <p><?php echo date("Y-m-d H:i:s",$value['create_time']) ?>下单</p>
                                <p>数量：<?php echo number_format($value['number'],2)?></p>
                            </div>
                            <div class="order-right">
                                <p><a class="layui-btn layui-btn-warm" style="padding:5px 7px;height: 30px; line-height:19px;border-radius: 5px;" href="./orderDetail.php?id=<?php echo $value['id']; ?>">查看详情</a></p>
                                <p>价格：<?php echo number_format($value['price'],2); ?></p>
                                <p>总金额：<span class="total"><?php echo number_format($value['price']*$value['number'],2); ?></span></p>
                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div>
                    <div class="layui-tab-item ">
                        <?php foreach($paidOrderList as $key=>$value){ ?>
                        <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell margin-t10">
                            <div class="order-left">
                                <p><span class="b">买入</span> 单号：<?php echo $value['onumber'] ?></p>
                                <p><?php echo date("Y-m-d H:i:s",$value['create_time']) ?>下单</p>
                                <p>数量：<?php echo number_format($value['number'],2)?></p>
                            </div>
                            <div class="order-right">
                                <p><a class="layui-btn layui-btn-warm" style="padding:5px 7px;height: 30px; line-height:19px;border-radius: 5px;" href="./orderDetail.php?id=<?php echo $value['id']; ?>">订单详情</a></p>
                                <p>价格：<?php echo number_format($value['price'],2); ?></p>
                                <p style="color: #2F4056">已付款</p>
                                <p>总金额：<span class="total"><?php echo number_format($value['price']*$value['number'],2); ?></span></p>
                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div>
                    <div class="layui-tab-item ">
                        <table lay-skin="line" class="layui-table laytable-cell-space">
                        <colgroup>
                          <col width="5%">
                          <col width="">
                          <col width="30%">
                          <col width="25%">
                        </colgroup>
                        <thead >
                          <tr >
                            <th id="laytable-cell-space">序号</th>
                            <th id="laytable-cell-space">内容</th>
                            <th id="laytable-cell-space">卡券</th>
                            <th id="laytable-cell-space">时间</th>
                          </tr> 
                        </thead>
                        <tbody>
                          <?php foreach($evaluate as $key=>$value) { ?>
                          <tr>
                            <td><?php echo $key ?></td>
                            <td><?php echo $value['content'] ?></td>
                            <td><?php echo $value['card_id'] ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$value['createtime']); ?></td>
                          </tr>
                            <?php }?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //include display('public_menu');?>
</body>
<script type="text/javascript">
  layui.use(['element'],function(){
    var element = layui.element;
  })
</script>

</html>
