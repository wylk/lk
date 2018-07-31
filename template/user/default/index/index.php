<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>乐卡后台管理</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css?r=33">
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?r=33">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>

</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">乐卡 v2.0</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
              <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
               <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
          </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">admin</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
              <dd><a href="?c=index&a=logout">退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="javascript:;" id="del_cache">清除缓存</a></li>
        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <?php foreach($auth as $k=>$v){ ?>
            <?php if($v['is_show']==1){ ?>
            <?php if($v['pid'] == 0){ ?>
            <li>
                <a href="javascript:;">
                    <i class="iconfont"><?= htmlspecialchars_decode($v['icon']) ?></i>
                    <cite><?= $v['name'] ?></cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <?php foreach($auth as $kk=>$vv){ ?>
                <?php if($vv['pid'] == $v['id'] && $vv['is_show']==1){ ?>
                    <li>
                        <a _href="?c=<?= $vv['auth_c'] ?>&a=<?= $vv['auth_a'] ?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite><?= $vv['name'] ?></cite>
                        </a>
                    </li >
                    <?php } ?>
                <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='?c=index&a=welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
   <div class="footer">
       <div class="copyright">Copyright ©2017 lk 2.3 All Rights Reserved</div>
   </div>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
   

layui.use(['layer'], function(){
    $ = layui.jquery;
    var layer = layui.layer;
    $('#del_cache').click(function(){
        $.post('?c=public&a=cache',{},function(i){
            layer.msg(i.msg, {icon: 1,time:2000},function () {
                window.location.replace(location.href);
            });
        },'json');
    }) 
 });
    </script>
</body>
</html>
