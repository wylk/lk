<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>乐卡</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">

    <style type="text/css">
    * { touch-action: pan-y; } 
      html,
            body {
                background-color: #efeff4;
                height: 100%;
            }
            .mui-bar~.mui-content .mui-fullscreen {
                top: 44px;
                height: auto;
            }
            .mui-pull-top-tips {
                position: absolute;
                top: -20px;
                left: 50%;
                margin-left: -25px;
                width: 40px;
                height: 40px;
                border-radius: 100%;
                z-index: 1;
            }
            .mui-bar~.mui-pull-top-tips {
                top: 24px;
            }
            .mui-pull-top-wrapper {
                width: 42px;
                height: 42px;
                display: block;
                text-align: center;
                background-color: #efeff4;
                border: 1px solid #ddd;
                border-radius: 25px;
                background-clip: padding-box;
                box-shadow: 0 4px 10px #bbb;
                overflow: hidden;
            }
            .mui-pull-top-tips.mui-transitioning {
                -webkit-transition-duration: 200ms;
                transition-duration: 200ms;
            }
            .mui-pull-top-tips .mui-pull-loading {
                /*-webkit-backface-visibility: hidden;
                -webkit-transition-duration: 400ms;
                transition-duration: 400ms;*/
                
                margin: 0;
            }
            .mui-pull-top-wrapper .mui-icon,
            .mui-pull-top-wrapper .mui-spinner {
                margin-top: 7px;
            }
            .mui-pull-top-wrapper .mui-icon.mui-reverse {
                /*-webkit-transform: rotate(180deg) translateZ(0);*/
            }
            .mui-pull-bottom-tips {
                text-align: center;
                background-color: #efeff4;
                font-size: 15px;
                line-height: 40px;
                color: #777;
            }
            .mui-pull-top-canvas {
                overflow: hidden;
                background-color: #fafafa;
                border-radius: 40px;
                box-shadow: 0 4px 10px #bbb;
                width: 40px;
                height: 40px;
                margin: 0 auto;
            }
            .mui-pull-top-canvas canvas {
                width: 40px;
            }
            .icon-sousuo3,.mui-slider-indicator.mui-segmented-control {
                background-color: #ffffff;
                /* background-color: rgba(2, 3, 5, 0.382); */
            }
            

            .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
                color: #67ccf4;
                border-bottom: 2px solid #67ccf4;
                background: 0 0;
            }

            .mui-segmented-control.mui-scroll-wrapper .mui-control-item {  
                padding: 0 12px;
                color: #999;
            }

            .padding-0{
                padding: 0px;
            }

            .icon-sousuo3:before {
                position: relative;
                top: 2px;
                margin-left: 5px;
                content: "\e68d";
                color: #999;
            }

            .img-view{
                line-height: 0px;
                /* position: absolute;
                z-index: 20; */
                background-color: #f0f0f0;
                margin: 3px 3px;
                border-radius: 8px;
            }

            .img-view img{
                height: 100%;
                width: 100%;
                border-radius: 8px;
            }

            .mui-table-view-cell:after {
                left: 0px;
            }

            .font-3{
                color: #333;
            }
            
            .font-9{
                color: #999;
            }
            .box-shadow-8{
                    box-shadow: #666 0px 2px 8px;
            }
            .box-shadow-13{
                    box-shadow: #666 0px 2px 13px;
            }

            .font-6{
                color: #666;
            }
            .padding-10{
                padding:0px 10px;
            }

            .col-r1{
                color: #e62323;
            }
            .font-24{
                font-size: 21px;
            }
            .col-f1{
                color: #f1efef;
            }

            .flex{
                display: flex;
            }

            .ju-sb{
                justify-content:space-between; 
            }
            
            .ju-sa{
                justify-content:space-around; 
            }

            .ai-fe{
                align-items: flex-end;
            }

            .lk-ellipsis {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }

            .mui-table-view {
                position: relative;
                margin-top: 0;
                margin-bottom: 0;
                padding-left: 0;
                list-style: none;
                background-color: #ececec;
            }

            .mui-table-view-cell {
                padding: 0px;
            }
             .t-store .t-srore-info div .t-store-name{
                width: 25%;
                margin-right: 5px;
            }
            .t-store .t-srore-info div .t-store-btn{
                width: 70%;
            }

            .bo{
                border: 1px solid red;
            }

            .mui-table-view-cell:after {    
                height: 0px; 
            }
            .card-box{
                margin:5px 10px 10px;
                height: 144px;
                border-radius: 8px;
                /* border: 1px solid #dad5d5; */
                background-color: #fff;
                box-shadow: #999 0px 0px 5px;
            }
            .card-top{
                height: 38.2%;
                border-radius: 8px 8px 0px 0px; 
                background-image: url(../static/images/top.jpg?r=332);
                background-size:100% 100%;
                display: flex;
                align-items:flex-end;
                padding: 10px 0px;
            }
            .c-logo{
                width: 30%;
                height: 100%;
                display: flex;
                align-items:center;
                justify-content:center;

            }
            .mui-slider .mui-slider-group .mui-slider-item .c-logo img{
                width: 60px;
                height: 50px;
                border-radius: 8px;
            }
            
            .c-title{
                 width: 70%;
                 height: 100%;
            }
            .c-title p{
                color: #fff;
                font-size: 16px;
                margin: 8px 0px 6px 0px;
            }
            .card-b{
                 height: 61.8%;
                 padding: 7px 3px;
                 display: flex;
                 justify-content: space-around;
            }

            .card-b-1 ,  .card-b-2{
                width: 48%;
                height: 100%;
                border-radius: 5px;
            }

            .card-info {
                margin-top: 30px;
                padding-left: 5px;
                width: 50%;
                float: right;
                line-height: 24px; 
            }

            .card-bc-img{
                background-image: url(../static/images/0.png?r=35); 
                background-size: 100% 100%;
                width: 100%;
                height: 100%;
                border-radius: 5px;
            }
/* 
<div style="display: flex;justify-content:space-between;margin-bottom: 2px">
            <div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted" style="width: 85%">
                <div class="mui-scroll">
                    <a class="mui-control-item" href="#item1mobile">
                       关注
                    </a>
                    <a class="mui-control-item mui-active" href="#item2mobile">
                        推荐
                    </a>
                    <?php foreach ($res as $k => $v) {?>
                       
                        <a class="mui-control-item" href="#item3mobile">
                           <?php echo $v['name'] ?>
                        </a>
                    <?php } ?> 
                </div>
            </div>
            <div style="width: 15%;line-height: 35px;" class="iconfont icon-sousuo3"></div>
        </div> */


    </style>
</head>
<body>
    <div class="mui-content" >
        <div id="slider" class="mui-slider mui-fullscreen">
            <div style="display: flex;justify-content:space-between;margin-bottom: 2px">
                <div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted" style="width: 90%">
                    <div class="mui-scroll">
                        <a class="mui-control-item" href="#item1mobile">
                           关注
                        </a>
                        <a class="mui-control-item mui-active" href="#item2mobile">
                            推荐
                        </a>
                        <a class="mui-control-item" href="#item3mobile">
                            餐饮
                        </a>
                        <a class="mui-control-item" href="#item4mobile">
                            超市
                        </a>
                        <a class="mui-control-item" href="#item5mobile">
                            母婴
                        </a>
                        <a class="mui-control-item" href="#item6mobile">
                            服饰
                        </a>

                    </div>
                </div>
                <div style="width: 10%;line-height: 35px;" class="iconfont icon-sousuo3"></div>
            </div>
            <div class="mui-slider-group"  id="mui-scroll-wrapper">
                <div id="item1mobile" class="mui-slider-item mui-control-content ">
                    <div id="scroll1" class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0">
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item2mobile" class="mui-slider-item mui-control-content mui-active">
                    <div class="mui-scroll-wrapper" >
                        <div class="mui-scroll">
                            <ul class="mui-table-view" >
                                <?php for($i=1;$i<4;++$i){?>
                               <li class="mui-table-view-cell padding-0 ">
                                    <div class="card-box">
                                        <div class="card-top">
                                            <div class="c-logo">
                                                <img src="../static/images/8.jpg">
                                            </div>
                                            <div class="c-title">
                                                <p >老王咖啡</p>
                                                <span style="color: #d2c8c8">辉煌国际4号楼 - 21km</span>
                                            </div>
                                        </div> 
                                        <div class="card-b " >
                                            <div class="card-b-1" style="background-image: url(../static/images/index/0.jpg?r=1); background-size: 100% 100%;">
                                                <div class="card-bc-img">
                                                    <div class="card-info">
                                                        <span class="col-r1 font-24">1000</span ><span class="col-r1" >元</span><br>
                                                        <span class="col-f1">&nbsp;&nbsp;抵现券</span><br>
                                                        <span class="col-f1">&nbsp;&nbsp;8折</span>
                                                     </div>
                                                </div>
                                            </div>
                                            <div class="card-b-1" style="background-image: url(../static/images/index/1.jpg?r=1); background-size: 100% 100%;">
                                                <div class="card-bc-img">
                                                    <div class="card-info">
                                                        <span class="col-r1 font-24">1000</span ><span class="col-r1" >元</span><br>
                                                        <span class="col-f1">&nbsp;&nbsp;抵现券</span><br>
                                                        <span class="col-f1">&nbsp;&nbsp;8折</span>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </li> 
                               <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item3mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0" >
                                  
                                </li>  
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item4mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0">
                                  
                                </li>  
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item5mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0">
                                   
                                </li>  
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item6mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0">
                                   
                                </li>  
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php include display('public_menu');?>
    <script src="https://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
    <script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.js"></script>
    <script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.material.js"></script>
    <script>
        
        $(function(){
            var card_box = $('.card-box');
            var jiao = $('.jiao');
            card_box.height((card_box.width()*0.618)+'px');
            jiao.css('left',(card_box.width()*0.382)+'px');
        })

 

        mui.init();
        (function($) {
            //阻尼系数
            var deceleration = mui.os.ios?0.003:0.0009;
            $('.mui-scroll-wrapper').scroll({
                bounce: false,
                indicators: true, //是否显示滚动条
                deceleration:deceleration
            });
            $.ready(function() {
                //循环初始化所有下拉刷新，上拉加载。
                $.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function(index, pullRefreshEl) {
                    $(pullRefreshEl).pullToRefresh({
                        /*down: {
                            callback: function() {
                                var self = this;
                                setTimeout(function() {
                                    var ul = self.element.querySelector('.mui-table-view');
                                    ul.insertBefore(createFragment(ul, index, 10, true), ul.firstChild);
                                    self.endPullDownToRefresh();
                                }, 1000);
                            }
                        },*/
                        up: {
                            //auto:true,
                            callback: function() {
                                var self = this;
                                index_action = index;
                                setTimeout(function() {
                                    var ul = self.element.querySelector('.mui-table-view');
                                    ul.appendChild(createFragment(ul, index, 5));
                                    self.endPullUpToRefresh();
                                }, 1000);
                            }
                        }
                    });
                });
                var createFragment = function(ul, index, count, reverse) {
                    var length = ul.querySelectorAll('li').length;
                    var fragment = document.createDocumentFragment();
                    var li;
                    for (var i = 0; i < count; i++) {
                        li = document.createElement('li');
                        li.className = 'mui-table-view-cell';
                        /*li.innerHTML = '第' + (index + 1) + '个选项卡子项-' + (length + (reverse ? (count - i) : (i + 1)));*/
                        li.innerHTML = 'sdgdr';
                        fragment.appendChild(li);
                    }
                    return fragment;
                };
            });
        })(mui);
    </script>
   	
</body>
</html>
