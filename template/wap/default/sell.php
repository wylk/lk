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
                <div class="layui-form-mid layui-word-aux">可以:1000.32</div>
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
            <th id="laytable-cell-space">操作</th>
          </tr> 
        </thead>
        <tbody>
          <?php for ($i=0; $i < 2; $i++) { ?>
          <tr>
            
            <td>12</td>
            <td>0.323</td>
            <td>16-11-29 12:33:14</td>
            <td>撤销</td>
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
layui.use(['form','layer'], function(){
  var layer = layui.layer;
  var form = layui.form;
  var beatCount=0;
  //监听提交
  form.on('submit(formDemo)', function(data){
    console.log(JSON.stringify(data.field));
      console.log(data);
      layer.load();
      if(beatCount >= 1) {
        layer.msg("不要重复点击",{icon:5,skin:'demo-class'});
      }
      $.post("./transaction.php",data.field,function(res){
        console.log(res);
        if(!res.res){
            layer.msg(res.msg,{icon:1,skin:"demo-class"},function(){
            window.location.href = "./cardList.php";
          })
        }else{
          layer.msg(res.msg,{icon:5,skin:'demo-class'});
        }
        layer.closeAll("loading");
      },"json");
    return false;
  });

});
</script>