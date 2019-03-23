<html>
	<head>
		<meta charset="utf-8">
		<title>捞卡</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
		
		<style type="text/css">
		.bb{
			border: 1px solid red;
		}
		.content{
			height: 100%;
			width: 100%;
			background-image: url(<?php echo TPL_URL;?>images/fishing_bg.jpg);
			background-size: 100% 100%;
		}

		.btn_box{
			height: 35px;
			width: 100%;
			position: absolute;
			bottom: 60px;
			display: flex;
			justify-content:space-around;
		}

		.btn_box a{
			background: #00b8ee;
			padding: 0px 10px;
			line-height: 35px;
			border-radius: 5px;
			color: #fff;
			box-shadow: 0px 0px 12px #999;
		}

		.net_bag{
			width: 100%;
			position: fixed;
			text-align: center;
		}

		.mui-modals.mui-active {
		    height:48%;
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

		select {
		    border: 1px solid #ececec !important;   
		}

		.mui-input-row label~input, .mui-input-row label~select, .mui-input-row label~textarea {
	        float: left;
		    width: 84%;
		    margin-bottom: 0;
		    padding-left: 8px;
		    border: 1px solid #ececec;
		    color: #999;
		    font-size: 12px;
		}

		.modal-content{
			padding: 10px 40px 10px;
			font-size: 14px;
		}
		.mui-input-row {
		    position: relative;
		    margin-top: 10px;
		}

		.mui-input-row label {
		    font-family: 'Helvetica Neue',Helvetica,sans-serif;
		    line-height: 1.1;
		    /* float: left; */
		    width: 15%;
		    padding: 11px 0px;
		    color: #555;
		}

		.mui-input-row .mui-btn {
		    line-height: 1.1;
		    /* float: right; */
		    width: 100%;
		    padding: 10px 15px;
		}

		.mui-input-row .mui-btn {
		    line-height: 1.1;
		    float: right;
		    width: 100%;
		    padding: 10px 15px;
		    background: #00b8ee;
		    border-color: #00b8ee;
		    border-radius: 5px;
		    color: #fff;
		}

		</style>

	</head>
	<body><!-- mdsdsui-bar-transparent -->
		
		<div class="content">
			<div   class="net_bag" id="net_bat_img" style="top:50px;"><img id="img"  src="<?php echo TPL_URL;?>images/net_bag1.png?r=33" style="width: 90px;opacity:0" alt="图片未找到"></div>
			<div class="btn_box">
				<a href="javascript:;" class="ren">扔一扔</a>
				<a id="fishing" href="javascript:;" onclick="tesy()">捞一捞</a>
				<a href="javascript:;" onclick="my_card()">我的卡</a>
			</div>
		</div>

		<div id="modal" class="mui-modals">
			<div class="modal-content">
				<div class="mui-input-row">
					<label >卡券:</label>
					<select name="select" id="card_info" >
						<?php if(!empty($Card_package_list)){
								foreach ($Card_package_list as $key => $value) {
							?>
						<option value="<?php echo $value['card_id'];?>" data-num="<?php echo $value['num'];?>"><?php echo $value['val']?></option>
						<?php }}?>

					</select>
				</div>
				<div class="mui-input-row">
							<label>数量:</label>
					<input type="number" placeholder="普通输入框" id="num">
				</div>
				<div class="mui-input-row">
					<label>留言:</label>
					<textarea id="lea_meg" rows="5" placeholder="多行文本框" style="height: 60px;"></textarea>
				</div>

				<div class="mui-input-row" style="margin-top: 20px;">
					<a href="javascript:;" class="mui-btn ren-btn">扔卡</a>
				</div>
			</div>
		</div>
		<script src="<?php echo STATIC_URL;?>mui/js/mui.min.js"></script>
		<script type="text/javascript">
		var w_h = (window.innerHeight)*0.6;
		var net_img = document.getElementById('net_bat_img');
		var img = document.getElementById('img');
		window.onload = function(){
			net_img.style.top= w_h+'px';
			img.style.opacity = 0;
		}
		/*扔卡*/
		mui(document.body).on('tap', '.ren-btn', function(e) {
			var card_info = document.getElementById('card_info');
			var num = document.getElementById('num').value;
			var lea_meg = document.getElementById('lea_meg').value;
			var index = card_info.selectedIndex ;
			var card_id = card_info.options[index].value;
			var old_num = parseFloat(card_info.options[index].dataset.num);
			if(num < 0.1){
				mui.toast('请输入正确的数量');return;
			}
			if(parseFloat(num) > old_num){
				mui.toast('请输入数量不能大于'+old_num);return;
			}

			mui.post('./fishing_card.php?action=ren',{num:num,card_id:card_id,len_meg:lea_meg},function(re){
				console.log(re);
				if(re.error == 0){
					mui.toast(re.msg);
					setTimeout(function(){
						remve();
					},1000)
				}else{
					mui.toast(re.msg);
				}
			},'json')
				
		});


		mui(document.body).on('tap', '.ren', function(e) {
			var dom=document.createElement("div");
			dom.className = 'mui-backdrop mui-activev';
			document.body.appendChild(dom);
		    document.querySelector(".mui-modals").classList.add("mui-active");
		});
		var remve = function(){
			document.body.removeChild(document.querySelector(".mui-backdrop")); 
		    document.querySelector(".mui-modals").classList.remove("mui-active");
		}
		mui(document.body).on('tap', '.mui-backdrop', function(e) {
			remve(); 
		});
		function my_card(){
			window.location.href='./my_card.php'
		}
		function tesy(){
			var bottom = net_img.style.top;
			bottom = bottom.replace("px","");
			if(Math.round(bottom) == 280){
				down();
			}else{
				setTimeout(function(){
					up();
				},1000);
			}
		}

		function down(){	
		　　var bottom = net_img.style.top;//取得图像当前的left值
			var op = parseFloat(img.style.opacity);
			bottom = Math.round(bottom.replace("px",""));
			//console.log(Math.round(bottom));
		　　if(bottom != Math.round(w_h)){
				bottom = bottom+1;
				op = op-0.08;
				console.log(bottom);
		　　   	net_img.style.top = bottom+"px"; //操作img的style属性使之运动
				img.style.opacity = op;
		　　   	setTimeout(down,16.8)//定时的调用当前这个方法
		　　}else{
				clearTimeout();
				setTimeout(up,500);
			}
		}

		function up(){
		　　var bottom = net_img.style.top;//取得图像当前的left值
			var op = parseFloat(img.style.opacity);
			bottom = bottom.replace("px","");

		　　if(Math.round(bottom) != 280){
				bottom = bottom-1;
				op = op+0.08;
				console.log(op);
		　　   	net_img.style.top = bottom+"px"; //操作img的style属性使之运动
				img.style.opacity = op;
		　　   	setTimeout(up,16.8)//定时的调用当前这个方法
		　　}else{
				clearTimeout();
			}
		}
		</script>
	</body>
</html>