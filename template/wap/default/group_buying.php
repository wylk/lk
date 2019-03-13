<html>
	<head>
		<meta charset="utf-8">
		<title>团购</title>
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
					width: 80%;
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
				.gr-card-info{
					display: flex;
					width: 60%;
					background-image: url(../static/images/5.png?r=22); 
					background-size: 100% 100%;
					height: 100px;
					border-radius: 2px;
				}
				.gr-card-total {
				    width: 61.8%;
				    height: 100%;
				    line-height: 100px;
				    text-align: right;
				    font-size: 25px;
				    color: #ea3030;
				}
				.gr-card-val{
					width: 38.2%;
					display: flex;
					align-items:flex-end;
					justify-content:center;
					margin-bottom: 8px;
					color: #fff;
				}

				.gr-buy-info{
					width: 40%;
					padding-left: 10px;
				}
				
				.gr-buy-info div{
					padding: 12px 0px 0px;
				}

		</style>

	</head>

	<body>
		<div class="mui-content" >
			<ul class="mui-table-view" style="margin-top: 0px;color: #999">
				<li class="mui-table-view-cell " >
					<div class="group-list-box">	
						<div class="group-logo "><img src="http://img4.imgtn.bdimg.com/it/u=2516412662,1264355198&fm=26&gp=0.jpg"></div>
						<div class="group-info ">
							<div class="gr-info-title"><span class="cl-3">老王 </span> &nbsp;&nbsp;    辉煌国际4号楼</div>
							<div class="gr-info-rate cl-6">当前还差<span class="cl-red">50</span>个开团</div>
							<div class="gr-info-card">
								<div class="gr-card-info">
								 	<div class="gr-card-total ">1000</div>
								 	<div class="gr-card-val "><span>¥100</span></div>
								</div>
								<div class="gr-buy-info">
									<div>团长: <span class="cl-3">李明</span></div>
									<div>团友: <span class="cl-3">48</span></div>
									<div  style="color: #67ccf4;">+参团</div>
								</div>
							</div>
						</div>
					</div>
					
				</li>
				<li class="mui-table-view-cell " >
					<div class="group-list-box">	
						<div class="group-logo "><img src="http://img4.imgtn.bdimg.com/it/u=2516412662,1264355198&fm=26&gp=0.jpg"></div>
						<div class="group-info ">
							<div class="gr-info-title"><span class="cl-3">老王 </span> &nbsp;&nbsp;    辉煌国际4号楼</div>
							<div class="gr-info-rate cl-6">当前还差<span class="cl-red">50</span>个开团</div>
							<div class="gr-info-card">
								<div class="gr-card-info">
								 	<div class="gr-card-total ">1000</div>
								 	<div class="gr-card-val "><span>¥100</span></div>
								</div>
								<div class="gr-buy-info">
									<div>团长: <span class="cl-3">李明</span></div>
									<div>团友: <span class="cl-3">48</span></div>
									<div  style="color: #67ccf4;">+参团</div>
								</div>
							</div>
						</div>
					</div>
					
				</li>
			
			</ul>
		</div>
		<script type="text/javascript">
			var progressbar1 = mui('#demo1');
			mui(progressbar1).progressbar().setProgress(10)
			progressbar1.on('tap', 'a', function() {
				mui(progressbar1).progressbar().setProgress(this.getAttribute('data-progress'));
			});
		</script>
	</body>
</html>