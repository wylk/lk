<html>
	<head>
		<meta charset="utf-8">
		<title>发现</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
		<!--App自定义的css-->
		<style type="text/css">
				.mui-table-view:before {
				    position: absolute;
				    right: 0;
				    left: 0;
				    height: 0px;
				    content: '';
				    -webkit-transform: scaleY(.5);
				    transform: scaleY(.5);
				    background-color: #c8c7cc;
				    top: -1px;
				}
				.mui-table-view:after {
				    position: absolute;
				    right: 0;
				    bottom: 0;
				    left: 0;
				    height: 0px;
				    content: '';
				    -webkit-transform: scaleY(.5);
				    transform: scaleY(.5);
				    background-color: #c8c7cc;
				}
				.icon-laoke:before,.icon-icontuan:before,.icon-pengyouquan:before {
		    		color: #67ccf4;
		    		font-size: 21px;
		    		margin-right: 10px;
				}
				.icon-gouwu:before{
					color: red;
		    		font-size: 21px;
		    		margin-right: 10px;
				}
				.mui-table-view-cell>a:not(.mui-btn) {
				    color: #333;
				    font-size: 14px;
				}
		</style>

	</head>

	<body>
		<div class="mui-content" >
			<ul class="mui-table-view">
				<li class="mui-table-view-cell ">
					<a id="about" class="iconfont icon-pengyouquan mui-navigate-right">
						卡圈
					</a>
				</li>
			</ul>
			<ul class="mui-table-view" style="margin-top: 20px;">
				<li class="mui-table-view-cell">
					<a id="about" class="iconfont icon-icontuan mui-navigate-right">
						团购
					</a>
				</li>
				<li class="mui-table-view-cell">
					<a id="about" class="iconfont icon-laoke mui-navigate-right">
						捞一捞
					</a>
				</li>
			</ul>
			<ul class="mui-table-view" style="margin-top: 20px;">
				<li class="mui-table-view-cell">
					<a href="https://mall.epaikj.com/wap/index.php" id="about" class="iconfont icon-gouwu  mui-navigate-right">
						购物
					</a>
				</li>
			</ul>
		</div>
<?php include display('public_menu');?>
	</body>
</html>