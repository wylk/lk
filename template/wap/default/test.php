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
                /*background-color: #F2F2F2;*/
                background-color: rgba(2, 3, 5, 0.382);
            }
            

            .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
                color: #67ccf4;
                border-bottom: 2px solid #67ccf4;
                background: 0 0;
            }

            .mui-segmented-control.mui-scroll-wrapper .mui-control-item {  
                padding: 0 12px;
                color: #f1f1f1;
            }

            .padding-0{
                padding: 0px;
            }

            .icon-sousuo3:before {
                position: relative;
                top: 2px;
                margin-left: 5px;
                content: "\e68d";
                color: #fdfdfd;
            }

            .img-view{
                line-height: 0px;
                position: absolute;
                z-index: 20;
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

            
            /* 第一个模块 */
            .f_box{
                
                display: flex;
                justify-content:space-around;
                padding:21px 0px;

            }

           .f_box div{
                height: 68px;
                width: 110px;
                border-radius: 2px;
                background-size:100% 100%;  
            }
            .f_box .f-card-1{
                background-image: url(../static/images/00.png);
                box-shadow: #666 0px 0px 8px;
            }

            .f_box .f-card-2{
                background-image: url(../static/images/00.png);
                box-shadow: #666 0px 0px 8px;
            }

            .f_box .f-card-3{
                background-image: url(../static/images/00.png);
                box-shadow: #666 0px 0px 8px;
            }

            .f_box div .f-card-text{
                width: 20%;
                line-height: 15px;
                margin: 12px 0px 0px 19px;

            }


             

             /* 第二模块 */
            .t-title{
                line-height: 42px;
            }
            .t-img{
                height: 68px;
                display: flex;
                justify-content:space-around;
            }
            .t-store{
                height: 54px;
                padding: 8px 10px;
            }

            .t-img div{
                height: 68px;
                width: 110px;
                border-radius: 2px;
            }

            
            .t-img .t-card{
                background-image: url(../static/images/5.png?r=22);
            }
            .t-store div{
                height: 100%;
            }
            .t-store .t-srore-info{
                display: flex;
                justify-content:space-between;
            }
            .t-store .t-srore-info div{
                padding: 0px;
                height: 100%;
                width: 12%;
            }
            .t-store .t-srore-info div:nth-child(3){
                text-align: right;
            }
            .mui-icon-arrowright:before {
                font-size: 20px;
            }
            .t-store-info-tag{
                flex-grow:1;
                line-height: 35px;
            }

            .t-card .t-card-val{
                width: 61.8%;
                line-height: 68px;
                text-align: center;
                font-size: 22px;
                color: red;
                text-align: right;
                padding-right:5px;

            }
            .t-card .t-total-val{
                width: 38.2%;
                padding-left: 2px;

            }
            .t-card .t-total-val span{
                text-align: center;
                width: 100%;
                color: #fff;
                font-size: 12px;
                margin-bottom: 2px;
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
    </style>
</head>
<body>
    <div class="mui-content">
        <div id="slider" class="mui-slider mui-fullscreen">
            <div style="display: flex;justify-content:space-between;position: absolute;z-index: 22">
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
            <div class="img-view box-shadow-13" id="videobox" >
                <img id="vodeobox-img" src="../static/images/index/0.jpg?r=2" data-id="0">
            </div>
            <div id="content-box" style="background-color: #ffffff;"></div>
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
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                <li class="mui-table-view-cell padding-0">
                                   <div class="f_box font-6" data-id="1">
                                       <div class="f-card f-card-1 box-shadow-8"> <div class="f-card-text">好评店</div></div>
                                       <div class="f-card f-card-2 box-shadow-8"><div class="f-card-text">零花钱</div></div>
                                       <div class="f-card f-card-3 box-shadow-8"><div class="f-card-text">明星店</div></div>
                                   </div> 
                                </li>
                               <!--<li class="mui-table-view-cell padding-0">
                                   <div class="t-box">
                                       <div class="t-title font-3 padding-10 lk-ellipsis">用会员卡购买拉面可省3元</div>
                                       <div class="t-img">
                                           <div class="t-card flex">
                                               <div class="t-card-val lk-ellipsis"> 500</div>
                                               <div class="t-total-val flex  ai-fe"> <span>¥400</span></div>
                                           </div>
                                           <div class="t-card flex">
                                                <div class="t-card-val lk-ellipsis"> 500</div>
                                               <div class="t-total-val flex  ai-fe"> <span>¥400</span></div>
                                           </div>
                                           <div class="t-card flex">
                                                <div class="t-card-val lk-ellipsis"> 500</div>
                                               <div class="t-total-val flex  ai-fe"> <span>¥400</span></div>
                                           </div>
                                       </div>
                                       <div class="t-store">
                                           <div class="t-srore-info">
                                               <div ><img class="t-store-info-logo" src="../static/images/21.jpg" style="width: 35px;height: 35px ;border-radius: 50%;"></div>
                                               <div class="t-store-info-tag flex"><div class="font-3 t-store-name lk-ellipsis">老王咖啡fads申达股份电饭锅</div>  <div class="t-store-btn">   <a href="" class="font-9">关注</a> | <a href="" class="font-9">购物</a> | <span href="" class="font-6">10km</span></div></div>
                                               <div > <span class="mui-icon mui-icon-arrowright"></span></div>
                                           </div>
                                       </div>
                                   </div>
                               </li> --> 
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

        var _h = window.innerHeight;
        var _w = window.innerWidth;
        var f_out = 1;
        var f_in = 0;
        var videobox = document.getElementById('videobox');
        var content_box = document.getElementById('content-box');
        var hjfgx_height = (_h/2.618)-42;
        videobox.style.height = hjfgx_height + 'px';
        videobox.style.width = (_w-6)+'px';
        content_box.style.height = (hjfgx_height+2) + 'px';

        $(document).ready(function(){ 
            $(window).scroll(function(){
                var s = $(window).scrollTop();
                $('.mui-control-item').each(function(index, el) {
                    var cla = $(this).attr("class");
                    if(cla.indexOf('mui-active') != -1){
                        $('#item'+(index + 1)+'mobile li').each(function(index, el) {
                            var self_top = $(this).offset().top;
                            console.log(self_top);
                            console.log(hjfgx_height);
                            if( self_top < (hjfgx_height+3) &&  self_top > (hjfgx_height-20)){
                                var id = $(this).find('div').data('id');
                                var imgobj = $('#vodeobox-img');
                                var img_data_id = imgobj.data('id');
                                
                                (img_data_id != index) && f_out && imgobj.fadeOut(0,function () {
                                    imgobj.attr('src','../static/images/index/'+ index +'.jpg?r=2');
                                    imgobj.data('id',index);
                                    imgobj.fadeIn(0.382,function () {
                                        f_out = 1;
                                    }); 
                                }) 
                            }
                        });
                    }
                });
               
            });
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
                            auto:true,
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
                        li.innerHTML = '<div class="t-box" data-id="'+ (length + (reverse ? (count - i) : (i + 1))) +'"><div class="t-title font-3 padding-10 lk-ellipsis">用会员卡购买拉面可省3元</div><div class="t-img"><div class="t-card flex box-shadow-8"><div class="t-card-val lk-ellipsis">500</div><div class="t-total-val flex ai-fe"><span>¥400</span></div></div><div class="t-card flex box-shadow-8"><div class="t-card-val lk-ellipsis">500</div><div class="t-total-val flex ai-fe"><span>¥400</span></div></div><div class="t-card flex box-shadow-8"><div class="t-card-val lk-ellipsis">500</div><div class="t-total-val flex ai-fe"><span>¥400</span></div></div></div><div class="t-store"><div class="t-srore-info"><div><img class="t-store-info-logo" src="../static/images/8.jpg" style="width:35px;height:35px;border-radius:50%"></div><div class="t-store-info-tag flex"><div class="font-3 t-store-name lk-ellipsis">老王咖啡fads申达股份电饭锅</div><div class="t-store-btn"><a href="" class="font-9">关注</a> | <a href="" class="font-9">购物</a> | <span href="" class="font-6">10km</span></div></div><div><span class="mui-icon mui-icon-more"></span></div></div></div></div>';
                        fragment.appendChild(li);
                    }
                    return fragment;
                };
            });
        })(mui);
    </script>
   	
</body>
</html>
