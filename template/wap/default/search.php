<html>
	<head>
		<meta charset="utf-8">
		<title>搜索</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
		<!--App自定义的css-->
		<style type="text/css">
			.mui-table-view-cell>a:not(.mui-btn) { 
		            display: flex;          
		        }

		        .flex-g{
		            flex-grow: 1
		        }

		        .mui-table-view .mui-media-object {
		            border-radius: 5px;
		        }
		        .font-c-9{
		        	color: #999;
		        }
		        .mui-table-view:before ,.mui-table-view:after{    
				    height: 0px;
				}
		</style>

	</head>

	<body>
		<div id="pullrefreshs" style="touch-action: none;" class="mui-content mui-scroll-wrapper">
			<div>
			<div class="mui-content" >
				<div class="mui-input-row mui-search" style="margin:10px 10px 0px">
		            <input type="search" class="mui-input-clear search" placeholder="输入店铺名">
		        </div>
		        <ul class="mui-table-view" id="mui-table-view"> 
	            </ul>
			</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js"></script>

<script type="text/javascript">
 var tag = '';
 mui.init({
    pullRefresh : {
        container:'#pullrefreshs',
        down: {
            callback: pulldownRefresh
        },
        up : {
            height:50,
            contentrefresh : "正在加载...",
            contentnomore:'没有更多数据了',
            callback :pullupRefresh
        }
    }
});

function data(tag,so=0){
	var length = document.querySelector('.mui-table-view').querySelectorAll('li').length;
	console.log(length);
    mui.post('./search.php',{i:length,tag:tag},function(re){
        if(re.error == 0){
            var fragment = document.createDocumentFragment();
            var li;
            mui.each(re.msg,function(index, el) { 
                	var juli = '0';
                	if(el.juli > 1000){
                		juli = parseFloat((el.juli/1000),2).toFixed(2) + 'km';
                	}else{
                		juli = parseFloat(el.juli,2).toFixed(2) + 'm';
                	}
               
                	li = document.createElement('li');
						li.className = 'mui-table-view-cell mui-media';
                    li.innerHTML =  ' <a class="d-flex" href="home.php?card_id='+el.card_id+' &plugin=offset&shoreUid='+el.uid+'" > <img class="mui-media-object mui-pull-left " src="'+el.logo+'"> <div class="mui-media-body font-17 flex-g">'+el.enterprise+'<p class="mui-ellipsis font-14">折扣:'+parseFloat(el.min).toFixed(2)+'-'+parseFloat(el.max).toFixed(2) +'</p></div><div class="font-14 font-c-9">'+juli+'</div></a>';
                    fragment.appendChild(li);
               
            });
            document.querySelector('.mui-table-view').appendChild(fragment);
            mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
        }else{
        	so && mui.toast('抱歉,未搜索到');
            mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
        }
    },'json');
}

    function pullupRefresh(){
        setTimeout(function() {
            data(tag,0);
        },1000);
        mui.init();
    }

    function pulldownRefresh() {
        setTimeout(function() {
            mui('#pullrefreshs').pullRefresh().endPulldownToRefresh(); //refresh completed
            mui('#pullrefreshs').pullRefresh().refresh(true); //激活上拉加载
        }, 1500);
    }
    mui('body').on('change','.search',function(){
    	tag = this.value;
    	data(tag,1);
    	var li = document.querySelector('.mui-table-view').querySelectorAll('li');
    	mui.each(li,function(index, el) {
    		el.remove();
    	});
    	console.log(li);
    })

    mui('body').on('tap','a',function(){
	    window.top.location.href=this.href;
	});
		</script>
	</body>
</html>