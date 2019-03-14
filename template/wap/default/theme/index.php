<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <title>用乐卡更省钱</title>
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
        <style type="text/css">
          * { touch-action: pan-y; } 
        body, html,#allmap {
            width: 100%;height: 100%;overflow: hidden;margin:0px;padding:0px;
        }
        .lk-titles{
          height: 42px;
          display: flex;
          z-index:2;
          overflow:auto;
          background: #fcfcfc;
        }
        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            color: #67ccf4;
            border-bottom: 2px solid #67ccf4;
            background: 0 0;
        }
        .mui-segmented-control.mui-scroll-wrapper .mui-control-item {  
            padding: 0 8px;
            color: #888;
        }
        .mui-table-view-cell {
            position: relative;
            overflow: hidden;
            padding: 5px 15px;
            -webkit-touch-callout: none;
        }
        .mui-toast-container {
            line-height: 17px;
            position: fixed;
            z-index: 9999;
            bottom: 50%;
            left: 50%;
            -webkit-transition: opacity .3s;
            transition: opacity .3s;
            -webkit-transform: translate(-50%,0);
            transform: translate(-50%,0);
            opacity: 0
        }

        .icon-sousuo3,.mui-slider-indicator.mui-segmented-control {
                background-color: #ffffff;
                /* background-color: rgba(2, 3, 5, 0.382); */
        }
        .mui-icon-search:before {
            content: '\e466';
            font-size: 20px;
            position: relative;
            top: 3px;
            left: 6px;
        }
        .action{
          color: #29aee7; 
          border-bottom: 1px solid #29aee7;
        }
        .stores{
            margin: 0 auto;
            text-align: center;
            width: 95%;
        }

        .store{
            display: flex;
            align-items:center;
            height: 70px;
            color:#999;
        }
        .price{
           width: 46.2%;
           font-size: 13px;
           /* border-right: 1px dashed #999; */
        }
        .price div{
            line-height: 25px;
            margin-left: 10px;
            text-align: left;

        }
        .font18{
            font-size: 16px;
        }
        .font20{
            font-size: 18px;
        }
        .num{
            height:50px;
            width: 40%;
            text-align: right;
        }
        .num div{
            font-size: 13px;
        }
        .black_3{
            color:#333;
        }
        .black_9{
            color:#888;
        }
        .black_6{
            color:#555;
        }
        .red{
            color: red;
        }
        .mui-slider .mui-slider-group .mui-slider-item img {
            height: 50px;
            width: 50px;
            border-radius:3px;
        }
        
        .num a{
          border-radius: 5px;
        }
        .black-status{
            color: #95ad6e;
        }
        .map{
            height: 160px;
            width: 100%;
        }
        .wind_f{
          overflow:scroll;
          height: 560px;
        }

        .marker-route{
            width: 70px;
            height: 27px;
            color: #999;
            border:1px solid #29aee7;
            background-color: #29aee7;
            border-radius: 7px;
            overflow:hidden;
            font-size: 14px;
            text-align: center;
        }

        .left > p,.right > p{    /*使内容居中*/
            display: table-cell;
            vertical-align: middle;
            padding: 0 10px;
        }
        .marker-route:before{   /*用伪类写出小三角形*/
            content: '';
            display: block;
            width: 0;
            height: 0;
            border: 8px solid transparent;
            position: absolute;
            top: 5px;
            border-right: 8px solid #29aee7;
            left: -16px;
        }
        .marker-route p{
            line-height: 25px;
            color: #000;
        }

        #resultMapInfo {
          position: absolute;
          left: 0px;
          top: 0px;
          z-index: 1;
        }
        #resultMapInfo p{
            color: #000;
            margin-top: 15px;
        }
        .amap-geo{
            display: none;
        }
        .touch{
            height: 20px;
            width:100%;
            display: flex;
            justify-content:center;
        }

        .mui-scroll {
            position: absolute;
            z-index: 223;
            width: 100%;
        }

        .mui-pull-bottom-wrapper {
            text-align: center;
        }
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
                        <?php foreach ($res as $k => $v) {?>
                           
                            <a class="mui-control-item" href="#item<?php echo ($k+3);?>mobile">
                               <?php echo $v['name'] ?>
                            </a>
                        <?php } ?> 

                        </div>
                    </div>
                    <div style="width: 10%;line-height: 35px;background-color: #ffffff;" class="mui-icon mui-icon-search" id="search"></div>
                </div>
               
                <div class="mui-slider-group"  id="mui-scroll-wrapper">
                    <div id="item1mobile" class="mui-slider-item mui-control-content ">
                        <div id="scroll1" class="mui-scroll-wrapper">
                             
                            <div class="mui-scroll">
                                <ul class="mui-table-view" id="ul0">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="item2mobile" class="mui-slider-item mui-control-content mui-active">
                        <div class="mui-scroll-wrapper" >
                           <!--  <div id="resultMapInfo"></div>
                           <div class="map" id="map"></div> -->
                            <div class="mui-scroll" >
                                <ul class="mui-table-view"  id="mui-ac">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($res as $k => $v) {?>
                    <div id="item<?=($k+3);?>mobile" class="mui-slider-item mui-control-content">
                        <div class="mui-scroll-wrapper">
                            <div class="mui-scroll">
                                <ul class="mui-table-view" id="ul<?=($k+3);?>">
                                     
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <input type="hidden" name="" id="lng" value="116.40717">
        <input type="hidden" name="" id="lat" value="39.90469">
        <?php include display('public_menu');?>
    </body>
</html>
<script src="https://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.5&key=0bda08c2afb77bff30115186de665721&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
 <script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.js"></script>
<script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.material.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js?r=<?=time();?>"></script>


   
