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
   <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
       
        <a>
          <cite>支付设置</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="lk-content" style="border:1px solid red">
            <div class="layui-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this" >微信支付</li>
                    <li>微信支付</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <label class="layui-form-label">appid：</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="appid" value="wxcf45e0f03cb2fe06" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">api_key：</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="api_key" value="7458e55e72ea67b4e03c8380668a8793" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">mch_id：</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="mch_id" value="1504906041" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">AppSecret：</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="AppSecret" value="230bbd5800c6e0fa2524266f03892c3a" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="layui-tab-item">微信支付啊</div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
