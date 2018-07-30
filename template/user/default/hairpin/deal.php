<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>平台币交易</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
    body,html {
      margin: 0;
      padding: 0;
      height: 100%;
      color: #fff;
    }
    .row{
        border:1px solid #D3D3D3;
        min-height: 500px;
        width: 33.99%;
    }
    .content {
        margin: 10px auto;
        width: 95%;
        display: flex;
    } 
    .ask-list{
        height: 300px;
    }
    .div-overflow{
        overflow-x:auto;
    }
    .div-overflow::-webkit-scrollbar {/*滚动条整体样式*/
        width: 5px;     /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }
    .div-overflow::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        background: #D3D3D3;
    }
    .div-overflow::-webkit-scrollbar-track {/*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        border-radius: 10px;
        background: #f0f0f0;
    }
    .content-div{
        width: 98%;
        height: 500px;
        margin: 5px auto;
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }
    .order-list{
        border-bottom: 2px solid #D3D3D3;
        width: 100%;
        height: 100px;
    }
    .order-list-title{
        border-bottom: 1px solid #f0f0f0;
        line-height: 30px;
    }
    .order-list-content{
        height: 70px; 
    }
    .text-r{
        text-align: right;
        margin-right: 8px;
    }
    .div-div div{
        width: 40%;
    }
    .div-div-hight div{
        height: 70px;
    }
    #order-list-content-left{
        width: 50%;
        line-height: 23px;
    }
    .order-list-content-right{
        line-height: 38px;
    }
    .lk-deal-link{text-align: center; line-height: 45px; font-size:.5rem;padding: 0 20px;}
    .lk-deal-link a input[type='text']{
        display: inline;
        border:none;
    }
    .entrust{
    }
  </style>
  </head>

  <body class="layui-anim layui-anim-up">
    <div class="content" style="color: #000;">
        <!-- 买卖单列表 -->
        <div class="row">
            <table class="layui-table" lay-skin="line">
                  <thead>
                    <tr>
                      <th>档位</th>
                      <th>数量</th>
                      <th>金额</th>
                      <th>操作</th>
                    </tr> 
                  </thead>
                </table>
            <div class="ask-list div-overflow">
                <table class="layui-table" lay-skin="line">
                   <colgroup>
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                  </colgroup>
                  <tbody>
                    <?php foreach ($buyList as $key => $value) { ?>
                    <tr>
                      <td style="color:#008069">买</td>
                      <td><?php echo number_format($value['num'],2) ?></td>
                      <td><?php echo number_format($value['price']*$value['num'],2) ?></td>
                      <td><a href="javascript:;" id="sellTran_<?php echo $value['id']; ?>"  class="layui-btn layui-btn-xs">卖出</a></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
            <hr style="background-color:  #000;">
            <div class="ask-list ask-buy div-overflow">
                 <table class="layui-table" lay-skin="line">
                  <colgroup>
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                  </colgroup>
                  <tbody>
                    <?php foreach ($sellList as $key => $value) { ?>
                    <tr>
                      <td style="color:red">卖</td>
                      <td><?php echo number_format($value['num'],2) ?></td>
                      <td><?php echo number_format($value['price']*$value['num'],2) ?></td>
                      <!-- onclick="x_admin_show('卖出','?c=hairpin&a=transaction&type=0&id=<?= 1 ?>',500,500)" -->
                      <td><a href="javascript:;" id="buyTran_<?php echo $value['id'] ?>"  class="layui-btn layui-btn-xs" >买入</a></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="layui-tab layui-tab-brief">
              <ul class="layui-tab-title" >
                <li class="layui-this ">待处理订单</li>
                <li>完成订单</li>
              </ul>
              <div class="layui-tab-content">
                <!-- 待处理订单 -->
                    <div class="layui-tab-item layui-show">
                        <div class="order div-overflow content-div" id="ordering">
                            <?php foreach ($orderingList as $key => $value) { ?>
                            <div class="order-list">
                                <div class="order-list-title div-div lk-container-flex lk-justify-content-sb">
                                    <div class="" style="width:80%">
                                        <?php if($value['sell_id'] == $userId){ ?>
                                        <span style="color: red">卖出</span>
                                        <?php }else{ ?>
                                        <span style="color: green">买入</span>
                                        <?php } ?>
                                    单号:<?php echo $value['onumber'] ?>
                                    </div>
                                    <div class="order-list-title-right text-r" onclick="x_admin_show('订单详情','?c=hairpin&a=orderList&orderId=<?= $value['id'] ?>',400,460)">订单详情</div>
                                </div>
                                <div class="order-list-content div-div div-div-hight lk-container-flex lk-justify-content-sb">
                                    <div id="order-list-content-left">
                                        <p><?php echo date("Y-m-d H:i:s",$value['create_time']) ?></p>
                                        <p>单价:¥<?php echo number_format($value['price'],2); ?></p>
                                        <p>数量:<?php echo number_format($value['number'],2); ?></p>
                                    </div>
                                    <div class="order-list-content-right text-r">
                                        <?php if($value['sell_id'] == $userId){ ?>
                                            <p style="color: red">
                                                <?php if($value['status'] == "0") echo "待收款" ?>
                                                <?php if($value['status'] == "3") echo "已收款" ?>
                                                </p>
                                            <?php }else{ ?>
                                                <p style="color: green">
                                                <?php if($value['status'] == "0") echo "待付款" ?>
                                                <?php if($value['status'] == "3") echo "已付款" ?>
                                                </p>
                                            <?php } ?>
                                        <p>金额:¥<?php echo number_format($value['number']*$value['price'],2); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <!-- 完成订单 -->
                    <div class="layui-tab-item">
                        <div class="order div-overflow content-div">
                            <?php foreach ($finishOrderList as $key => $value) { ?>
                            <div class="order-list">
                                <div class="order-list-title div-div lk-container-flex lk-justify-content-sb">
                                    <div style="width:80%">
                                        <?php if($value['sell_id'] == $userId){ ?>
                                        <span style="color: red">卖出</span> 
                                        <?php }else{ ?>
                                        <span style="color: green">买入</span> 
                                        <?php } ?>
                                        单号:<?php echo $value['onumber'];?></div>
                                    <div class="order-list-title-right text-r" onclick="x_admin_show('订单详情','?c=hairpin&a=orderList&orderId=<?= $value['id'] ?>',400,450)">订单详情</div>
                                </div>
                                <div class="order-list-content div-div div-div-hight lk-container-flex lk-justify-content-sb">
                                    <div id="order-list-content-left">
                                        <p><?php echo date("Y-m-d",$value['create_time']) ?></p>
                                        <p>单价:¥<?php echo number_format($value['price'],2); ?></p>
                                        <p>数量:<?php echo number_format($value['number'],2); ?></p>
                                    </div>
                                    <div class="order-list-content-right text-r">
                                        <p>已付款</p>
                                        <p>金额:¥<?php echo number_format($value['number']*$value['price'],2); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        <div class="row" > 
            <div class="layui-tab layui-tab-brief">
              <ul class="layui-tab-title" >
                <li class="layui-this ">买入</li>
                <li>卖出</li>
                <li>委托单</li>
              </ul>
              <div class="layui-tab-content">
                    <!-- 买入 -->
                    <div class="layui-tab-item layui-show">
                        <div class="lk-content" style="margin-top: -50px;">
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">买入价：<input type='text' name="buyPrice" value='<?php echo number_format(option('hairpan_set.price'),2) ?>' placeholder="<?php echo number_format(option('hairpan_set.price'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></a>
                                    <a href="javascript:;">余额：<?php echo number_format($packageInfo['num'],2); ?></a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">买入数量：<input type='text' name="buyNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                                    <a href="javascript:;">WLK</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">最低买入量：<input type='text' name="limitBuy" value='' placeholder="<?php echo number_format(option('hairpan_set.limit'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                                    <a href="javascript:;">WLK</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">兑换资金：<span id="buyMoney"></span></a>
                                    <a href="javascript:;">CNY</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-c">
                                <a href="javascript:;" id="buyTran" class="layui-btn" style="width: 90%">买入</a>
                            </div>
                        </div>
                    </div>
                     <!-- 卖出 -->
                    <div class="layui-tab-item">
                        <div class="lk-content" style="margin-top: -50px;">
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">卖入价：<input type='text' name="sellPrice" value='<?php echo number_format(option('hairpan_set.price'),2) ?>' placeholder="<?php echo number_format(option('hairpan_set.price'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></a>
                                    <a href="javascript:;">余额：<?php echo number_format($packageInfo['num'],2); ?></a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">卖入数量：<input type='text' name="sellNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                                    <a href="javascript:;">WLK</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">最低卖入量：<input type='text' name="limitSell" value='' placeholder="<?php echo number_format(option('hairpan_set.limit'),2) ?>" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                                    <a href="javascript:;">WLK</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                                    <a href="javascript:;">兑换资金：<span id="sellMoney">0.00</span></a>
                                    <a href="javascript:;">CNY</a>
                            </div>
                            <hr>
                            <div class="lk-container-flex lk-justify-content-c">
                                <a href="javascript:;" id="sellTran" class="layui-btn" style="width: 90%">卖出</a>
                            </div>
                        </div>
                    </div>
                     <!-- 委托单 -->
                    <div class="layui-tab-item">
                        <div class="entrust content-div div-overflow">
                             <table class="layui-table" lay-skin="line">
                                  <thead>
                                    <tr>
                                      <th>档位</th>
                                      <th>数量</th>
                                      <th>金额</th>
                                      <th>操作</th>
                                    </tr> 
                                  </thead>
                                </table>
                            <div class="ask-list">
                                <table class="layui-table" lay-skin="line">
                                   <colgroup>
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="25%">
                                  </colgroup>
                                  <tbody id="registerList">
                                    <?php foreach ($registerList as $key => $value) { ?>
                                    <tr id="strRevoke_<?php echo $value['id'] ?>">
                                    <?php if($value['type'] == '1'){ ?>
                                      <td style="color:#008069">买</td>
                                    <?php }else{ ?>
                                      <td style="color:red">卖</td>
                                    <?php } ?>
                                      <td><?php echo number_format($value['num'],2); ?></td>
                                      <td><?php echo number_format($value['price'],2); ?></td>
                                      <td><a href="javascript:;" id="revoke_<?php echo $value['id'] ?>"  class="layui-btn layui-btn-xs">撤销</a></td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
//注意：选项卡 依赖 element 模块，否则无法进行功能性操作
layui.use(["layer",'element'], function(){
  var element = layui.element;
  // var layer = layui.layer;

  $("[id^=sellTran_]").bind("click",function(){
    layer.load();
    var idStr = $(this).attr("id");
    var tranId = idStr.substring(idStr.indexOf("_")+1);
    console.log(tranId);
    var data = {"tranId":tranId};
    $.post("?c=hairpin&a=sellTran",data,function(result){
        console.log(result);
        layer.closeAll("loading");
        if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            var price = new Number(result.data.price);
            var number = new Number(result.data.number);
            var prices = new Number(result.data.number*result.data.price);
            var str = "<div class='order-list'>";
            str += "<div class='order-list-title div-div lk-container-flex lk-justify-content-sb'>";
            str += "<div style='width:80%'>";
            str += "<span style='color: red'>卖出</span>";
            str += result.data.onumber + "</div>";
            str += "<div class='order-list-title-right text-r' onclick='x_admin_show(\"订单详情\",\"?c=hairpin&a=orderList&orderId="+result.data.id+"\",400,450)'>订单详情</div></div>";
            str += "<div class='order-list-content div-div div-div-hight lk-container-flex lk-justify-content-sb'>";
            str += "<div id='order-list-content-left'>";
            str += "<p>"+getTime()+"</p><p>单价:¥"+price.toFixed(2)+"</p><p>数量:"+number.toFixed(2)+"</p>";
            str += "</div>";
            str += "<div class='order-list-content-right text-r'>";
            str += "<p style='color: red'>未收款</p><p>金额:¥"+prices.toFixed(2)+"</p>";
            str += "</div></div></div>";
            $("#ordering").prepend(str);
        }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
        }
    },"json");
  })
  $("[id^=buyTran_]").bind("click",function(){
    layer.load();
    var idStr = $(this).attr("id");
    var tranId = idStr.substring(idStr.indexOf("_")+1);
    console.log(tranId);
    var data = {"tranId":tranId};
    $.post("?c=hairpin&a=buyTran",data,function(result){
        console.log(result);
        layer.closeAll("loading");
        if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            var price = new Number(result.data.price);
            var number = new Number(result.data.number);
            var prices = new Number(result.data.price*result.data.number);
            var str = "<div class='order-list'>";
            str += "<div class='order-list-title div-div lk-container-flex lk-justify-content-sb'>";
            str += "<div style='width:80%'>";
            str += "<span style='color: green'>买入</span>";
            str += result.data.onumber + "</div>";
            str += "<div class='order-list-title-right text-r' onclick='x_admin_show(\"订单详情\",\"?c=hairpin&a=orderList&&orderId="+result.data.id+"\",400,450)'>订单详情</div></div>";
            str += "<div class='order-list-content div-div div-div-hight lk-container-flex lk-justify-content-sb'>";
            str += "<div id='order-list-content-left'>";
            str += "<p>"+getTime()+"</p><p>单价:¥"+price.toFixed(2)+"</p><p>数量:"+number.toFixed(2)+"</p>";
            str += "</div>";
            str += "<div class='order-list-content-right text-r'>";
            str += "<p style='color: green'>未付款</p><p>金额:¥"+prices.toFixed(2)+"</p>";
            str += "</div></div></div>";
            $("#ordering").prepend(str);
        }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
        }
    },"json");
  })
  // 买入委单
  $("#buyTran").bind("click",function(){
    layer.load();
    var buyPrice = $("[name=buyPrice]").val();
    var buyNum = $("[name=buyNum]").val();
    var limitNum = $("[name=limitBuy]").val();
    var packageId = "<?php echo $packageInfo['id'] ?>";
    var data = {"price":buyPrice,"tranNum":buyNum,"limitNum":limitNum,"packageId":packageId,"type":"1"};
    $.post("?c=hairpin&a=addRegister",data,function(result){
        console.log(result);
        layer.closeAll("loading");
        if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            var num = new Number(result.data.num);
            var price = new Number(result.data.price);
            var str = "<tr id='strRevoke_"+result.data.id+"'>";
            str += "<td style='color:#008069'>买</td>";
            str += "<td>"+num.toFixed(2)+"</td><td>"+price.toFixed(2)+"</td><td><a href='javascript:;' id='revoke_"+result.data.id+"' class='layui-btn layui-btn-xs'>撤销</a></td>";
            str += "</tr>";
            $("#registerList").prepend(str);
        }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
        }
    },"json");
  });
    // 卖出委单
  $("#sellTran").bind("click",function(){
    layer.load();
    var sellPrice = $("[name=sellPrice]").val();
    var sellNum = $("[name=sellNum").val();
    var limitNum = $("[name=limitSell]").val();
    var packageId = "<?php echo $packageInfo['id'] ?>";
    var data = {"price":sellPrice,"tranNum":sellNum,"limitNum":limitNum,"packageId":packageId,"type":"2"};
    $.post("?c=hairpin&a=addRegister",data,function(result){
        layer.closeAll("loading");
        if(!result.res){
            layer.msg(result.msg,{icon:1,skin:"demo-class"});
            var num = new Number(result.data.num);
            var price = new Number(result.data.price);
            var str = "<tr id='strRevoke_"+result.data.id+"'>";
            str += "<td style='color:red'>卖</td>";
            str += "<td>"+num.toFixed(2)+"</td><td>"+price.toFixed(2)+"</td><td><a href='javascript:;' id='revoke_"+result.data.id+"' class='layui-btn layui-btn-xs'>撤销</a></td>";
            str += "</tr>";
            $("#registerList").prepend(str);
        }else{
            layer.msg(result.msg,{icon:5,skin:"demo-class"});
        }
    },"json");
  });
  $("[name^=buy]").bind("keyup",function(){
    var buyPrice = $("[name=buyPrice]").val();
    var buyNum = $("[name=buyNum]").val();
    var buyMoney = new Number(buyPrice*buyNum);
    $("#buyMoney").html(buyMoney.toFixed(2));
  });
  $("[name^=sell]").bind("keyup",function(){
    var sellPrice = $("[name=sellPrice]").val();
    var sellNum = $("[name=sellNum]").val();
    var sellMoney = new Number(sellPrice*sellNum);
    console.log(sellMoney);
    $("#sellMoney").html(sellMoney.toFixed(2));
  });

  // 撤销委单
  $("[id^=revoke_]").bind("click",function(){
    var idStr = $(this).attr("id");
    var tranId = idStr.substring(idStr.indexOf("_")+1);
    layer.confirm("确定要撤销吗?",function(){
    layer.load();
        var data = {"tranId":tranId};
        console.log(data);
        $.post("?c=hairpin&a=revokeRegister",data,function(result){
            layer.closeAll("loading");
            if(!result.res){
                layer.msg(result.msg,{icon:1,skin:"demo-class"});
                $("#strRevoke_"+tranId).remove();
            }else{
                layer.msg(result.msg,{icon:5,skin:"demo-class"});
            }
        },"json");
    })
  })

  //…
});
function getTime(){
  var date = new Date();
  // date.setTime(time * 1000);
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  m = m < 10 ? ("0"+m) : m;
  var d = date.getDate();
  d = d < 10 ? ("0" + d) : d;
  var h = date.getHours();
  h = h < 10 ? ("0" + h) : h;
  var i = date.getMinutes();
  i = i < 10 ? ("0" + i) : i;
  var s = date.getSeconds();
  s = s < 10 ? ("0" + s) : s;
  // console.log(time,time,y,m,d,h,s);
  return y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
}
</script>