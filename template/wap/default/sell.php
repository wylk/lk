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
    .lk-rows-title{
      line-height: 40px;
      background-color: #fff;
      padding-left: 15px; 
    }
    .lk-rows{
      min-height: 100px;
      margin: 0px auto;
      background-color: #fff;
    }
    #laytable-cell-space{
      text-align: center;
    }
    .table-margin0{
      margin: 0px 0;
    }
    .lk-sell-inputs{
      height: 300px;
      margin: 5px 0;
      background-color: #fff;
    }
    .lk-sell-input{
      width: 90%;
      margin: 0px auto;
      height: 290px;
    }
    .layui-form-label{
      text-align: center;
      overflow:visible;
    }
    .lk-btn{
        color: #5fb878;
        border: 1px solid #5fb878;
        background-color: #fff;
    }
    .lk-btn:hover{color: #5fb878;}
  </style>
</head>
<body>
   <header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">交易</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">
    <div class="lk-sell-inputs">
        <div style="height: 10px;background-color: #fff;"></div>
        <div class="lk-sell-input">
            <form class="layui-form" action="">
              <div class="layui-form-item">
                <label class="layui-form-label">出售价：</label>
                <div class="layui-input-block">
                  <input type="text" name="price" required  lay-verify="price|number" placeholder="请输入出售价" autocomplete="off" class="layui-input">
                </div>
              </div>
              <hr>
              <div class="layui-form-item">
                <label class="layui-form-label">出售量：</label>
                <div class="layui-input-inline">
                  <input type="text" name="num" required lay-verify="num|number" placeholder="请输出售量" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux" id="surplusNum">可以:<i><?php echo number_format($numInfo['num']); ?></i></div>
              </div>
               <hr>
              <div class="layui-form-item">
                <label class="layui-form-label">最少购买数:</label>
                <div class="layui-input-block">
                  <input type="text" name="limit" required  lay-verify="limit|number" placeholder="请输入最少购买数" autocomplete="off" class="layui-input">
                </div>
              </div>
               <hr>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <input type="hidden" name="type" value="transaction" />
                  <input type="hidden" name="cardId" value="<?php echo $cardId; ?>" />
                  <button class="layui-btn lk-btn" lay-submit lay-filter="formDemo">立即提交</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
              </div>
            </form>
        </div>
    </div>
    <div class="lk-rows-title">
      <div>当前委托</div>
    </div>
    <div class="lk-rows">     
       <table lay-skin="line" class="layui-table laytable-cell-space table-margin0">
        <colgroup>
          <col width="20%">
          <col width="20%">
          <col >
          <col width="20%">
        </colgroup>
        <thead >
          <tr style="background-color: #fff">
            <th id="laytable-cell-space">待成交</th>
            <th id="laytable-cell-space">价格</th>
            <th id="laytable-cell-space">时间</th>
            <th id="laytable-cell-space" >操作</th>
          </tr> 
        </thead>
        <tbody>
          <?php foreach ($tranList as $key => $value) { ?>
          <tr id="<?php echo $value['id']?>">
            <td ><?php echo number_format($value['num'],2);?></td>
            <td><?php echo number_format($value['price'],2);?></td>
            <td><?php echo date("Y-m-d H:i:s",$value['createtime']);?></td>
            <td  id="revoke_<?php echo $value['id']?>" num="<?php echo $value['num'];?>" cardId="<?php echo $value['card_id'];?>" onclick="revoke(<?php echo $value['id']?>)" >撤销</td>
          </tr>
            <?php }?>
        </tbody>
      </table>
    </div>
</div>
<?php include display('public_menu');?>
</body>
</html>
<script>
  function get(id){
    alert(id);
  }
layui.use(['form','layer'], function(){
  var layer = layui.layer;
  var form = layui.form;
  var beatCount=0;
  //监听提交
  form.on('submit(formDemo)', function(data){
    console.log(JSON.stringify(data.field));
      console.log(data);
      layer.load();
      var surplusNum = $("#surplusNum i").html();
      if(data.field.num-surplusNum > 0){
        layer.msg("发布额度超出现有额度",{icon:5,skin:'demo-class'});
        layer.closeAll("loading");
        return false;
      }
      $.post("./transaction.php",data.field,function(res){
        console.log(res);
        if(!res.res){
          // var date = new Date(res.dataInfo.createtime);
            $("#surplusNum i").html(res.num);
            var resNum = new Number(res.dataInfo.num);
            var resPrice = new Number(res.dataInfo.price);
            // window.location.href = "./cardList.php";
            str = "<tr id='"+res.dataInfo.id+"'><td >"+resNum.toFixed(2)+"</td><td>"+resPrice.toFixed(2)+"</td><td>"+getTime()+"</td><td id='revoke_"+res.dataInfo.id+"' num='"+res.dataInfo.num+"' cardId='"+res.dataInfo.card_id+"' onclick='revoke("+res.dataInfo.id+")'>撤销</td></tr>";
            $("tbody").prepend(str);
            layer.msg(res.msg,{icon:1,skin:"demo-class"},function(){
          })
        }else{
          layer.msg(res.msg,{icon:5,skin:'demo-class'});
        }
        layer.closeAll("loading");
      },"json");
    return false;
  });
  

});
// 点单撤销功能
  function revoke(id){
    var num = $("#revoke_"+id).attr('num');
    var cardId = $("#revoke_"+id).attr("cardId");
    data = {'id': id,"num" : num ,"cardId": cardId, "type" : "revoke"}
    $.post("./transaction.php",data,function(res){
      console.log(res);
      if(!res.res){
        console.log($(this).parent().remove());
        $("#"+id).remove();
        var surplusNum = $("#surplusNum i").html();
        surplusNum = Number(surplusNum) + Number(num);
        $("#surplusNum i").html(surplusNum);
        layer.msg(res.msg,{icon:1,skin:"demo-class"});
      }else{
        layer.msg(res.msg,{icon:5,skin:"demo-class"});
      }

    },"json");
  }
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