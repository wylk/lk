<html>
	<head>
		<meta charset="utf-8">
		<title>拼卡</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
		<!--App自定义的css-->
		<style type="text/css">
				.mui-table-view-cell:after {
				    position: absolute;
				    right: 0;
				    bottom: 0;
				    left: 0px;
				    height: 1px;
				    content: '';
				    -webkit-transform: scaleY(.5);
				    transform: scaleY(.5);
				    background-color: #c8c7cc;
				}
				.group-list-box{
					display: flex;
				}

				.b-r{
					border: 1px solid red;
				}
				.cl-3{
					color: #333;
				}
				.cl-6{
					color: #666;
				}
				.cl-8{
					color: #888;
				}
				.cl-red{
					color: red;
				}
				.group-logo{
				    width: 15%;
				    padding: 0px 8px;
				}
				.group-logo img{
					width: 100%;
					border-radius: 50%;
				}
					
				.group-info{
					width: 100%;
				}
				.gr-info-title{
					line-height: 36px;
				}
				.gr-info-rate{
					line-height: 36px;
				}
				.gr-info-card{
					display: flex;
				}
				.gr-card-info-f{
					width: 40%;
					height: 100px;
					background-image: url(../static/images/index/15.jpg?r=22); 
					background-size: 100% 100%;
					border-radius: 5px;
				}
				.gr-card-info{
					display: flex;
					width: 100%;
					background-image: url(../static/images/0.png?r=22222); 
					background-size: 100% 100%;
					height: 100%;
					border-radius: 5px;
				}
				.gr-card-total {
				    width: 53%;
				    height: 100%;
				    line-height: 100px;
				    text-align: right;
				    font-size: 25px;
				    color: #ea3030;
				}
				.gr-card-val{
					padding-top: 20px;
					width: 48.2%;
					margin-bottom: 8px;
					color: #fff;
				}

				.gr-buy-info{
					width: 60%;
					padding-left: 10px;
				}
				
				.gr-buy-info div{
					padding: 6px 0px 0px;
				}

				.mui-plus .plus{
					display: inline;
				}
				
				.plus{
					display: none;
				}
				
				#topPopover {
					position: absolute;
					top: 16px;
					right: 6px;
				}
				#topPopover .mui-popover-arrow {
					left: auto;
					right: 6px;
				}

				p {
					text-indent: 22px;
				}
				span.mui-icon {
					font-size: 14px;
					color: #007aff;
					margin-left: -15px;
					padding-right: 10px;
				}
				.mui-popover {
					height: 138px;
					width: 123px;
				}

				.mui-modal.mui-active {
				    height: 35%;
				}
				.mui-modals.mui-active {
				    height:225px;
				    -webkit-transition: -webkit-transform .25s;
				    transition: transform .25s;
				    -webkit-transition-timing-function: cubic-bezier(.1,.5,.1,1);
				    transition-timing-function: cubic-bezier(.1,.5,.1,1);
				    -webkit-transform: translate3d(0,0,0);
				    transform: translate3d(0,0,0);
				    opacity: 1;
				}
				
				.mui-modals {
				    position: fixed;
				    z-index: 999;
				    bottom: 0;
				    overflow: hidden;
				    width: 100%;
				    min-height: 100px;
				    -webkit-transition: -webkit-transform .25s,opacity 1ms .25s;
				    transition: transform .25s,opacity 1ms .25s;
				    -webkit-transition-timing-function: cubic-bezier(.1,.5,.1,1);
				    transition-timing-function: cubic-bezier(.1,.5,.1,1);
				    -webkit-transform: translate3d(0,100%,0);
				    transform: translate3d(0,100%,0);
				    opacity: 0;
				    background-color: #fff;
				}

				.limit{
					margin-top: 5px;
				}

				.mui-input-row label {
				    padding: 11px 0px;
				}

				.mui-input-row label~input, .mui-input-row label~select, .mui-input-row label~textarea {
			    float: left;
			    width: 45%; 
			    margin-bottom: 0;
			    padding-left: 0;
			    border: 0;
			    border-radius: 0px;
			    border-bottom: 1px solid #999;
			    height: 35px;
			}

			.mui-btn-blue, .mui-btn-primary, input[type=submit] {
			    color: #fff;
			    border: 1px solid #67ccf4;
			    background-color: #67ccf4;
			}

		</style>

	</head>

	<body><!-- mdsdsui-bar-transparent -->
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left cl-6"></a>
			<a id="menu" class="mui-action-menu mui-icon mui-icon-bars mui-pull-right cl-6" href="#topPopover"></a>
			<h1 class="mui-title">拼卡</h1>
		</header>
			<div id="topPopover" class="mui-popover">
				<div class="mui-popover-arrow"></div>
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<ul class="mui-table-view">
							<li class="mui-table-view-cell"><a href="#">拼卡中</a>
							</li>
							<li class="mui-table-view-cell"><a href="#">拼卡成功</a>
							</li>
							<li class="mui-table-view-cell"><a href="#">拼卡失败</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<div class="mui-content" >
			<ul class="mui-table-view" style="margin-top: 0px;color: #999;font-size: 14px;">
				<?php for($i=1; $i<10; ++$i){?>
				<li class="mui-table-view-cell " >
					<div class="group-list-box">	
						<div class="group-info ">
							<div class="gr-info-card">
								<div class="gr-card-info-f">
									<div class="gr-card-info">

									 	<div class="gr-card-total "></div>
									 	<div class="gr-card-val ">
									 		<span style="color:#d20808;font-size: 18px;">1000</span>元<br>
									 		<span style="font-size: 12px;">抵现卡</span><br>
									 		<span>¥100</span>
									 	</div>
									</div>
								</div>
								<div class="gr-buy-info">
									<div style="padding: 0px;">店铺: <span class="cl-3" style="font-weight: bold;">呷哺呷哺</span></div>
									<div class="mui-ellipsis">地址: 辉煌国际4号sdgfsdgasdgasdgad楼</div>
									<div>团友: <span class="cl-3">48</span>&nbsp;&nbsp;  开团: <span class="cl-3">-192元</span> </div>
									<div  class="ping"><span  style="color: #67ccf4;">+我拼</span></div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<?php }?>
			
			</ul>
			<!--右上角弹出菜单-->
		</div>
		<!-- <div class="mui-backdrop mui-active" style=""></div> -->
		<div id="modal" class="mui-modals">
			<header id="modal_close" class="mui-bar-nav" style="height: 40px;background-color:#67ccf4;padding: 0px 10px;">
				<h3 class="mui-title" style="color: #fff;">我拼</h3>
				<a class="mui-icon mui-icon-close mui-pull-right" href="javascript:;" style="color: #fff;line-height: 40px;"></a>
			</header>
			<div class="mui-content" style="height: 100%;background: #fff;padding: 10px 35px 20px 35px;">
				<div class="limit cl-8" style="font-size: 12px;">拼卡限购：100-500  &nbsp;&nbsp;&nbsp;单价：0.3</div>
				<div style="margin-top: 8px;font-size: 16px;">
					<div class="mui-input-row cl-3" style="display: flex;">
						<div><label>购买数</label>
						<input type="text" placeholder=""></div>
						<div>
							<label style="width:20% ">=</label>
						<input type="text" placeholder=""><label style="text-align: center;">CNY</label></div>
					</div>
				</div>
				<div style="padding: 30px 18px;">
					<button type="button" class="mui-btn mui-btn-primary" style="width: 100%" data-loading-icon="mui-spinner mui-spinner-custom">确认</button>
				</div>
			</div>
		</div>
		

		<script src="<?php echo STATIC_URL;?>mui/js/mui.min.js"></script>
		<script>
			mui.init({
				swipeBack:true //启用右滑关闭功能
			});
			mui(document.body).on('tap', '.mui-btn', function(e) {
			    mui(this).button('loading');
			    setTimeout(function() {
			        mui(this).button('reset');
			    }.bind(this), 2000);
			});

			mui(document.body).on('tap', '.ping', function(e) {
				var dom=document.createElement("div");
				dom.className = 'mui-backdrop mui-activev';
				document.body.appendChild(dom);
			    document.querySelector(".mui-modals").classList.add("mui-active");
			    
			});
            document.getElementById("modal_close").addEventListener("click", function() {  
                document.querySelector(".mui-modals").classList.remove("mui-active"); 
                document.body.removeChild(document.querySelector(".mui-backdrop")); 
            });  
           
        
		
		</script>
	</body>
</html>