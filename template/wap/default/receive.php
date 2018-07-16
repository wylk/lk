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
        .card-logo{
            border: 1px solid #f0f0f0;
            height: 200px;
        }
        .card-img{
            width: 90%;
            height: 90%;
            margin: 10px auto;
        }
        .card{
            height: 120px;
            border-bottom:1px solid #f0f0f0;
        }
         .layui-btn-primary{
            border: 1px solid #5fb878;
            color: #5fb878;
            height: 45px;
            width: 60%;
            line-height: 45px;
            font-size: 18px;
        }
        .card-info{
            display: flex;
            justify-content:space-around;
        }
        .card-info-row{
            width: 30%;
            height: 50px;
            line-height: 50px;
        }
        .card-data{
            height: 37px;
            width: 85%;
            margin: 0 auto;
            line-height: 37px;
        }
        .card-data-style{
            color: rgb(37, 155, 36);
            font-size: 12px;
        }
        .layui-input{
            display:inline;
            width: 26%;
            border: 1px solid #fff;
            border-bottom: 0.5px solid #000;
        }
    </style>
</head>
<body>
<header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">卡券领取</h1>
</header>
<div class="lk-content">
   <div class="card-logo">
       <div class="card-img">
           <img src="https://free.modao.cc/uploads3/images/1907/19079609/raw_1523959707.jpeg" style="width: 100%;height: 100%">
       </div>
   </div>
   <div class="card card-info" style="height: 55px;">
       <div class="card-info-row">北京川菜馆</div>
       <div class="card-info-row" style="width: 37%;"><i class="iconfont">&#xe715;</i>北京海淀区苏州街</div>
   </div>
   <form>
   <div class="card card-num">
       <div class="card-data">你想买多少</div>
       <div class="card-data card-data-style">交易限制:<i><?= floatval($UserAud['limit']) ?></i>-<i><?= floatval($UserAud['num']) ?></i> 单价:<i><?= floatval($UserAud['price']) ?></i></div>
       <div class="card-data">购买量:

        <input type="text" name="number" required  lay-verify="required" autocomplete="off" class="layui-input">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="prices" required  lay-verify="required" autocomplete="off" class="layui-input" >

        CNY
    </div>
   </div>
   <div class="card" style="text-align: center;line-height: 120px;">
        <a class="layui-btn layui-btn-primary">购买</a>
   </div>
 </form>
</div>
  	<?php include display('public_menu');?>
</body>
</html>

<script type="text/javascript">
layui.use(['form', 'layer'],function() {
    layer = layui.layer;

    var text = parseFloat($(".card-data-style i").eq(0).text());
    var num = parseFloat($(".card-data-style i").eq(1).text());
    var price = $(".card-data-style i").eq(2).text();

     $("input[name='number']").bind('input',function(){
         $("input[name='prices']").val(price*parseFloat($(this).val()));

      });
     $("input[name='prices']").bind('input',function(){
         $("input[name='number']").val(parseFloat($(this).val())/price);
      });

    $(".layui-btn-primary").click(function(){
      var data = {}
        data.number = $("input[name='number']").val();
        data.prices = $("input[name='prices']").val();
        data.card_id = "<?php echo $UserAud['card_id'] ?>";
        data.sell_id = "<?php echo $_GET['uid'] ?>";
        data.quantity = "<?php echo floatval($UserAud['num']) ?>";
        data.tranId = "<?php echo floatval($UserAud['id']) ?>";

        if(data.number < text || data.number>num){
          layer.msg('输入购买数不合法！',{icon: 5,time:1000},function(){
              $("input[name='prices']").val('');
              $("input[name='number']").val('');
              $("input[name='number']").focus();
          });
          return false;
        }
        layer.load();
        $.post('./receive.php',data,function(data){
            // console.log(data);
            if(data.error==0){
                //此处演示关闭
                layer.closeAll('loading');
                layer.msg(data.msg,{icon: 1,time:1000});
            }else{
                //此处演示关闭
                layer.closeAll('loading');
                layer.msg(data.msg,{icon: 5,time:1000},function(){
                });

            }
        },'json');

    });
});
</script>
