<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>lib/layui/css/layui.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <style type="text/css">
      /*搜索*/
      .func_add_block{margin:30px 25px;}
      .func_add_block .layui-form{border:1px solid #e6e6e6;display: flex;padding-top: 8px;}
      .layui-form .layui-form-item{flex-direction: row;/*border:1px solid red;*/display: flex;}
      .layui-form-item div,.layui-form-item label{align-self: center;/*border:1px solid red;*/}
      .layui-input-block{margin-left: 0px;}
      .layui-textarea{min-height: 60px;}
      .layui-form-select{width: 70%;border:1px solid #e6e6e6;border-radius: 6px}
      .layui-form-select input{border:0;}
      /*列表*/
      .func_block{border:1px solid #e6e6e6;border-bottom: 0px;margin:30px 25px;}
      .layui-row{display: flex;text-align: center;border-bottom:1px solid #e6e6e6;min-height: 45px;}
      .layui-row .layui-col-xs4{align-self: center;}
      .layui-col-xs4 img{max-width: 25%;}
      .layui-col-xs4 .image{max-width: 60%;}

      #image_block {text-align: center;margin:0 auto;}
      #image_block img{max-width: 60%;margin:10px;}
      #page{text-align: center;}
    </style>
  </head>

<body>
  <div class="x-nav">
    <span class="layui-breadcrumb">
      <a href="?c=find&a=index">发现列表</a>
      <a><cite><?php echo $info['name'] ?></cite></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
      <i class="layui-icon" style="line-height:30px">ဂ</i></a>
  </div>
  <div class="func_add_block">
      <form class="layui-form">
          <div class="layui-form-item">
              <label class="layui-form-label">选择框：</label>
              <div class="layui-input-block">
                <select name="search_type" lay-verify="">
                  <option value=" ">请选择</option>
                  <option value="0">主贴</option>
                  <option value="1">留言</option>
                </select>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">搜索内容：</label>
              <div class="layui-input-block">
                  <input type="text" name="title" placeholder="请输入功能名" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <div class="layui-input-block">
                  <button lay-submit lay-filter="submitBtn" class="layui-btn">提交</button>
              </div>
          </div>
      </form>
  </div>

  <div class="func_block">
      <div class="layui-row">
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">头像</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">昵称</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">类型</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md8">内容</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">图片</div>
          <div class="layui-col-xs4 layui-col-sm3 layui-col-md1">设置</div>
      </div>
      <div id="list_content"></div>
  <div id="page" count="<?php echo $listNum ?>"></div>
  </body>
</html>
<script type="text/javascript">
  var layer,laypage,form;
  var count = "<?php echo $findNum; ?>";
  layui.use(['layer',"laypage",'form'],function(){
    layer = layui.layer;
    form = layui.form;

    laypage = layui.laypage;
    // 分页 首次加载
    laypage.render({
      elem  : "page",
      count : count,
      jump  : function(obj){
        console.log(obj);
        // var table = "<?php echo card_circle?>";
        var data = {limit:obj.limit,page:obj.curr}
        var search_type = $("[name=search_type]").val();
        var content = $("[name=title]").val();
        // 搜索 条件
        if(search_type) data.type = search_type;
        if(content) data.content = content;
        // console.log(data);
        $.post("?c=find&a=card_circle",data,function(result){
          console.log(result);
          if(!result.error){
            console.log(count);
            obj.count = count = result.data.findNum;
            var strHtml = '';
            $.each(result.data.list,function(key,val){
              strHtml += strFunc(val,result.data.userinfo);
            });
            $("#list_content").html(strHtml);
            form.render();
          }else{
            layer.msg("加载失败");
          }
        },"json");
      }
    });
    // 查询条件的处理
    form.on("submit(submitBtn)",function(data){
      console.log(data);
      var data1 = {content:data.field.title,type:data.field.search_type};
      $.post("?c=find&a=card_circle",data1,function(result){
        console.log(result);
        if(!result.error){
          count = result.data.findNum;
          console.log(count);
          // 分页
          laypage.render({
            elem  : "page",
            count : count,
            jump  : function(obj,first){
              if(!first){
              console.log(obj);
                var table = "<?php echo $table?>";
                var data1 = {limit:obj.limit,page:obj.curr,table:table}
                var search_type = $("[name=search_type]").val();
                var content = $("[name=title]").val();
                // 搜索 条件
                if(search_type) data1.type = search_type;
                if(content) data1.content = content;
                $.post("?c=find&a=card_circle",data1,function(result){
                  if(!result.error){
                    var strHtml = '';
                    $.each(result.data.list,function(key,val){
                      strHtml += strFunc(val,result.data.userinfo);
                    });
                    $("#list_content").html(strHtml);
                    form.render();
                  }else{
                    layer.msg("加载失败");
                  }
                },"json");
                return false;
              }
            }
          });
          var strHtml = '';
          $.each(result.data.list,function(key,val){
            strHtml += strFunc(val,result.data.userinfo);
          });
          $("#list_content").html(strHtml);
          form.render();
        }else{
          layer.msg("加载失败");
        }
      },"json");
      return false;
    });
    // 内容显示/隐藏的设置
    form.on("switch",function(res){
		console.log(res);
		var id = $(res.elem).attr("num");
		var status=res.elem.checked;
	  	var data = {id:id,is_delete:status};
	  	console.log(data);
	  	// return false;
	  	$.post("?c=find&a=circleSet",data,function(result){
	  		console.log(result);
	  		if(!result.error){
	  			layer.msg("修改成功");
	  		}else{
	  			layer.msg("修改失败");
	  		}
	  	},"json");
  	});
  });
  function strFunc(data,userinfo){
    str = '';
    str += '<div class="layui-row">';
    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md1">';
      if(userinfo[data['uid']] && userinfo[data['uid']]['avatar']){
        str += '<img src="'+userinfo[data['uid']]['avatar']+'">';
      }else{
        str += '<img src="<?php echo STATIC_URL;?>images/1.jpg">';
      }
    str += '</div>';
    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md1">';
      if(userinfo[data['uid']] && userinfo[data['uid']]['name']){
        str += userinfo[data['uid']]['name']+data['id'];
      }else{
        str += '匿名'+data['id'];
      }
    str += '</div>';
    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md1">';
      str += data['fid']!='0' ? "留言" : "主贴";
    str += '</div>';

    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md8" onclick="content(';
      str += data['fid'] ? data['fid'] : data['id'];
    str += ')" >'+data['content']+'</div>';

    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md1">';
      str += (data['img'] && data['img']) != 'undefined' ? '<img class="image" onclick=image("'+data['img']+'") src="'+data['img']+'">' : '';
    str += '</div>';

    str += '<div class="layui-col-xs4 layui-col-sm3 layui-col-md1 layui-form">';
      str += '<input type="checkbox" name="switch" lay-skin="switch" num="'+data['id']+'" lay-text="显示|隐藏" ';
      if(data['is_delete'] == '0'){
        str += "checked";
      }
    str += ' /></div>';
    str += '</div>';
    return str;
  }
  function content(id){
    console.log(id);
    layer.open({
      area : ['900px','500px'],
      type : 2,
      content : "?c=find&a=content&id="+id,
    })
  }
  function image(url){
    var str = '<div id="image_block"><img src="'+url+'"></div>';
    console.log(str);
    layer.open({
      // area : ['900px','500px'],
      type : 1,
      content : str,
    })
  }

</script>
