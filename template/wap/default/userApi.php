<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css?<?=time()?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <style type="text/css">
        .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .content{width: 100%;position: absolute; left: 0; top: 200px;}
        .content div{margin: 3px; margin-left: 4px;}
        .content span{padding: 2px;}
        .content button{padding:2px;border-radius: 6px;background: #29aee7;width: 60px;}
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
        <h1 class="lk-title">api接口</h1>
    </header>
    <div class="lk-content" style="background-color: #f0f0f0;height: 500px;font-size: 18px;">
    	<?php if(empty($userInfo['mid'])){ ?>
    		<div>
    			<input type="" name="verify" value="请输入验证码"><button>获取验证码</button>
    			<button>申请商户号</button>
    		</div>
        <?php }else{ ?>
	        <div class="content">
	    		<div>
	    			<span>商户号：</span><span><?php echo $userInfo['mid'] ?></span><button>复制</button>
	    		</div>
	    		<div>
	    			<span>秘钥：</span><span><?php echo $userInfo['key'] ?></span><button>复制</button>
	    		</div>
	        </div>
        <?php } ?>
    </div>
    <?php include display('public_menu');?>

</body>
</html>