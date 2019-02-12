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

			.mui-preview-image.mui-fullscreen {
				position: fixed;
				z-index: 20;
				background-color: #000;
			}
			.mui-preview-header,
			.mui-preview-footer {
				position: absolute;
				width: 100%;
				left: 0;
				z-index: 10;
			}
			.mui-preview-header {
				height: 44px;
				top: 0;
			}
			.mui-preview-footer {
				height: 50px;
				bottom: 0px;
			}
			.mui-preview-header .mui-preview-indicator {
				display: block;
				line-height: 25px;
				color: #fff;
				text-align: center;
				margin: 15px auto 4;
				width: 70px;
				background-color: rgba(0, 0, 0, 0.4);
				border-radius: 12px;
				font-size: 16px;
			}
			.mui-preview-image {
				display: none;
				-webkit-animation-duration: 0.5s;
				animation-duration: 0.5s;
				-webkit-animation-fill-mode: both;
				animation-fill-mode: both;
			}
			.mui-preview-image.mui-preview-in {
				-webkit-animation-name: fadeIn;
				animation-name: fadeIn;
			}
			.mui-preview-image.mui-preview-out {
				background: none;
				-webkit-animation-name: fadeOut;
				animation-name: fadeOut;
			}
			.mui-preview-image.mui-preview-out .mui-preview-header,
			.mui-preview-image.mui-preview-out .mui-preview-footer {
				display: none;
			}
			.mui-zoom-scroller {
				position: absolute;
				display: -webkit-box;
				display: -webkit-flex;
				display: flex;
				-webkit-box-align: center;
				-webkit-align-items: center;
				align-items: center;
				-webkit-box-pack: center;
				-webkit-justify-content: center;
				justify-content: center;
				left: 0;
				right: 0;
				bottom: 0;
				top: 0;
				width: 100%;
				height: 100%;
				margin: 0;
				-webkit-backface-visibility: hidden;
			}
			.mui-zoom {
				-webkit-transform-style: preserve-3d;
				transform-style: preserve-3d;
			}
			.mui-slider .mui-slider-group .mui-slider-item img {
				width: auto;
				height: auto;
				max-width: 100%;
				max-height: 100%;
			}
			.mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
				width: 100%;
			}
			.mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
				display: inline-table;
			}
			.mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
				display: table-cell;
				vertical-align: middle;
			}
			.mui-preview-loading {
				position: absolute;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				display: none;
			}
			.mui-preview-loading.mui-active {
				display: block;
			}
			.mui-preview-loading .mui-spinner-white {
				position: absolute;
				top: 50%;
				left: 50%;
				margin-left: -25px;
				margin-top: -25px;
				height: 50px;
				width: 50px;
			}
			.mui-preview-image img.mui-transitioning {
				-webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
				transition: transform 0.5s ease, opacity 0.5s ease;
			}
			@-webkit-keyframes fadeIn {
				0% {
					opacity: 0;
				}
				100% {
					opacity: 1;
				}
			}
			@keyframes fadeIn {
				0% {
					opacity: 0;
				}
				100% {
					opacity: 1;
				}
			}
			@-webkit-keyframes fadeOut {
				0% {
					opacity: 1;
				}
				100% {
					opacity: 0;
				}
			}
			@keyframes fadeOut {
				0% {
					opacity: 1;
				}
				100% {
					opacity: 0;
				}
			}
			p{
				color: #333;
			}
			p img {
				max-width: 100%;
				height: auto;
			}
			.mui-content{
				margin-bottom: 60px;
			}
		</style>

	</head>

	<body>
		<div class="mui-content" >
			<div class="mui-content-padded">
				<p>这是图片放大预览示例，点击如下图片体验全屏预览功能</p>
				<p>
					<img src="http://res.klook.com/images/fl_lossy.progressive,q_65/c_fill,w_1295,h_720,f_auto/w_80,x_15,y_15,g_south_west,l_klook_water/activities/rwq4gwp2pajj4za1xdlg/%E6%B2%B3%E5%86%85%E8%80%81%E5%9F%8E%E5%8C%BA%E7%BE%8E%E9%A3%9F%E4%B9%8B%E6%97%85.jpg" data-preview-src="" data-preview-group="1" />
				</p>
				<p>这是图片放大预览示例，点击如下图片体验全屏预览功能</p>
				<p>
					<img src="http://imgsrc.baidu.com/imgad/pic/item/b17eca8065380cd795edcc73ab44ad34588281b8.jpg" data-preview-src="" data-preview-group="1" />
				</p>
				<p>这是图片放大预览示例，点击如下图片体验全屏预览功能</p>
				<p>
					<img src="http://imgsrc.baidu.com/imgad/pic/item/f7246b600c3387447d2db0ff5b0fd9f9d62aa04d.jpg" data-preview-src="" data-preview-group="1" />
				</p>
				<p>这是图片放大预览示例，点击如下图片体验全屏预览功能</p>
				<p>
					<img src="http://img5.imgtn.bdimg.com/it/u=2145359727,1719103010&fm=26&gp=0.jpg" data-preview-src="" data-preview-group="1" />
				</p>
				<p>图片全屏后，双击或双指缩放均可对图片进行放大、缩小操作，左右滑动可查看同组(data-preview-group相同的图片为一组)其它图片，点击会关闭预览</p>
				<p>
					<img src="http://downhdlogo.yy.com/hdlogo/640640/640/640/23/2335233391/u23352333917rqiJFh.jpg" data-preview-src="" data-preview-group="1" />
				</p>
				<p>第三张图片，纯粹为了占位： </p>
				<p>
					<img src="http://imgsrc.baidu.com/imgad/pic/item/55e736d12f2eb938299a886fdf628535e4dd6fbc.jpg" data-preview-src="" data-preview-group="1" />
				</p>
			</div>
		</div>
<?php include display('public_menu');?>
	</body>
</html>