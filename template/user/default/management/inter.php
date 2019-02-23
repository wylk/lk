<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
      .list_body,.list_title,.list_content{border:1px solid #d0cfcf;border-radius: 4px;}
      .list_body{background-color: #f2f2f2;width: 100%;padding-bottom:15px;}
      .list_title1{height: 30px;line-height: 30px;}
      
      .list_content{background: white;width: 95%;margin:0 auto;text-align: center;margin-top:6px;display: flex;}
      .rows{width: 16%;display: flex;align-items: center;justify-content: center;}
      /*.rows_content{line-height:60px;}*/
      .row{width: 16%;display: inline-block;}
      .rows1{width: 48%;display: block;float:left;}
      .row_content{line-height: 30px;width:100%;display: inline-block;}

      .rows_line{border-right: 1px solid #cecdcd;}
      .rows_line1{display: block; width: 100%; height: 30px; line-height: 30px}
      .row_content1{width: 100%; display: inline-block; float: left;}
      .cols_line{border-top: 1px solid #cecdcd;}

      /*开关样式*/
      .switch_block{float: right;height:40px;}
      .switch_opt{display: flex;align-items: center;flex-direction: row;}
      .switch{width: 28px;height: 20px;border:1px solid #a9e6ef;border-radius:1px;font-size: 12px;}
      .switch_on{color:white;background:#a9e6ef;display: flex;align-items: center;justify-content: center;}
      .switch_off{color:#333;background:#f2f2f2;display: flex;align-items: center;justify-content: center;border:1px solid #f2f2f2;}
    </style>
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">应用</a>
        <a><cite>店铺管理</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body" >
      <div class="layui-row" ></div>
        <span class="x-right" style="line-height:40px;">共有数据：100 条</span>
      <div style="clear:both;"></div>
      <div class="list_body">
        <div class="list_content list_title1">
          <div class="rows rows_content rows_line">接口</div>
          <div class="rows rows_content rows_line">用户数量</div>
          <div class="rows1 rows_content rows_line">接口属性</div>
          <div class="rows rows_content">开关</div>
          <!-- <div class="rows rows_content rows_line">说明</div> -->
        </div>
        <?php foreach($inter_list as $key=>$value){ ?>
        <div class="list_content">
          <div class="rows rows_content rows_line"><?php echo $value['inter'] ?></div>
          <div class="rows rows_content rows_line">0<?php echo $value['id'] ?></div>
          <div class="rows1 rows_line">
            <?php foreach($value['attr'] as $k=>$v){ ?>
            <span class="rows_line1 <?php echo $k == 0 ? '' : 'cols_line' ?>">
              <span class="row_content1 rows_line"><?php echo $v['inter'] ?></span>
            </span>
            <?php } ?>
          </div>
          <span class="rows rows_content"><?php // echo $value['status'] ? "true" : "false" ?>
            <span class="switch_block switch_opt">
            <div class="switch_opt" id="on_<?php echo $value['id']; ?>" <?php if(!$value['switch']) echo "style='display:none'" ?> >
              <div class="switch"></div>
              <div class="switch switch_on">ON</div>
            </div>
            <div class="switch_opt" id="off_<?php echo $value['id']; ?>" <?php if($value['switch']) echo 'style="display: none;"' ?> >
              <div class="switch switch_off">OFF</div>
              <div class="switch" style="border:1px solid #f2f2f2;"></div>
            </div>
          </span>
          </span>
          <div style="clear:both;"></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>
<script type="text/javascript">
  // 开关
   $("[id^=on_]").bind('click',function(){
      var idStr = $(this).attr('id');
      var uid = $(this).attr('uid');
      var val = idStr.substr(idStr.indexOf("_")+1);
      // $(this).hide();
      // $("#off_"+val).show();
      switch_status(val,0,uid);
   });
   $("[id^=off_]").bind("click",function(){
      var idStr = $(this).attr("id");
      var uid = $(this).attr("uid");
      var val = idStr.substr(idStr.indexOf('_')+1);
      // $(this).hide();
      // $("#on_"+val).show();
      switch_status(val,1,uid);
   });
   function switch_status(val,status,uid){
    var data = {pid:val,status:status,uid:uid}
    console.log(data);
    $.post("?c=management&a=inter",data,function(result){
      console.log(result);
      if(result['res']){
        layer.msg(result['msg'],{ icon: 5, skin: "demo-class" });
      }else{
        layer.msg(result['msg'],{ icon: 1, skin: "demo-class" });
      }
        setTimeout(function() {
          window.location.reload();
        }, 1000);
    },"json");
   }
</script>

