<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <title>乐卡</title>
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
        <style type="text/css">
        body, html,#allmap {
        width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";
        }
        .lk-titles{
          border-bottom: 1px solid #f0f0f0;
          height: 42px;
          display: flex;
          z-index:2;
          overflow:auto;
        }
        .lk-ti{
          /*width: 25%;*/
          width: 62px;
          line-height: 40px;
          text-align: center;
          color: #000;
        }
        .action{
          color: #f6bc00;
          border-bottom: 1px solid #f6bc00;
        }
        .stores{
            margin: 0 auto;
            text-align: center;
            width: 95%;
        }
        .store{
            margin-top:10px;
            display: flex;
            align-items:center;
            height: 80px;
            background-color: #fff;
            border-radius: 5px;
            color:#000;
        }
        .img{
            width: 20%;
            line-height: 75px;
            margin-left: 8px;
        }
        .price{
           width: 50%;
           height: 80px;
           font-size: 12px;
           border-right: 1px dashed #00000040;
        }
        .price div{
            line-height: 40px;
            margin-left: 10px;
            text-align: left;

        }
        .num{
            height:80px;
            width: 25%;
        }
        .num div{
            line-height: 40px;
        }
        .imgs{
            height: 65px;
            width: 65px;
            margin: auto 0;
            border-radius:5px;
        }
        .num a{
          border-radius: 5px;
        }
        .map{
            height: 100%;
            width: 100%;
        }

        #up-map-div{
            width:100%;
            height:700px;
            top:200px;
            left:0px;
            position:absolute;
            z-index:1;
            background-color:rgba(12, 12, 12, 0.8);
        }
        .wind_f{
          overflow:scroll;
          height: 560px;
        }

        .marker-route{
            width: 70px;
            height: 27px;
            color: red;
            border:1px solid #f6bc00;
            background-color: #f6bc00;
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
            border-right: 8px solid #f6bc00;
            left: -16px;
        }


        #resultMapInfo {
          position: absolute;
          left: 0;
          top: 30px;
          z-index: 1;
        }
        p{
            color: #000;
        }
        .amap-geo{
            display: none;
        }
        </style>
        <script type="text/javascript">
            var plugin = '<?php echo isset($_GET['id'])?$_GET['id']:'';?>';
        </script>
    </head>
    <body>
        <div class="lk-titles">
            <a href="index.php"><div class="lk-ti <?php echo  empty($_GET['id'])?'action':''; ?>" id="stree">全部</div></a>                       
            <?php foreach ($res as $k => $v) {?>
                <a href="index.php?id=<?php echo $v['id'];?>"><div class="lk-ti <?php echo ($_GET['id'] == $v['id'])?'action':'';?>" id="stree"><?php echo $v['name'] ?></div></a>
            <?php } ?>            
        </div>
        <div id="resultMapInfo">请使用4G网络获取定位精确度高</div>
        <div class="map" id="map"></div>
    
        <div id="up-map-div">
            <div id="touch" style="height: 20px;width: 100%;"></div>
            <div class="wind_f" id="work">
              <div id="pullrefreshs" style="touch-action: none;">
               
                      <div class="lk-content" style="padding-top:0px ">

                          <div class="stores" >

                          </div>

                      </div>
                 
              </div>
            </div>
        </div>
        <div class="mui-loading" v-if="loading">
            <div class="mui-spinner">
            </div>
            玩命加载中...
        </div>

        <?php include display('public_menu');?>
    </body>
</html>
<script src="http://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script> -->
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.5&key=0bda08c2afb77bff30115186de665721&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js?r=<?=time();?>"></script>

<!-- <script type="text/javascript">
    $(function(){
        var lng = 116.397428;
        var lat = 39.90923;
        var map = new AMap.Map("map", {
            resizeEnable: true,
            center: [lng, lat],
            zoom: 15
        });
        var marker = new Array();
        marker1 = new AMap.Marker({
            position: [lng, lat],
            draggable:1,
            raiseOnDrag:1,
            clickable:1
        });
        marker1.setMap(map);

        var endIcon = new AMap.Icon({
            size: new AMap.Size(25, 34),
            image: '//a.amap.com/jsapi_demos/static/demo-center/icons/dir-marker.png',
            imageSize: new AMap.Size(135, 40),
            imageOffset: new AMap.Pixel(-95, -3)
        });

        // 将 icon 传入 marker
        var endMarker = new AMap.Marker({
            position: new AMap.LngLat(116.45,39.93),
            icon: endIcon,
            offset: new AMap.Pixel(-10, -10)
        });

        var content = '<div class="marker-route" >老王咖啡</div>';

        var marker2 = new AMap.Marker({
            content: content,  // 自定义点标记覆盖物内容
            position:  [lng, lat], // 基点位置
            offset: new AMap.Pixel(-10, -10) // 相对于基点的偏移位置
        });


        map.add([marker2,endMarker]);

        marker1.on('click', function(r){
            console.log(r);
        });
    });
</script> -->
<script>
var startX,//触摸时的坐标
    startY,
     x, //滑动的距离
     y,
     aboveY=200; //设一个全局变量记录上一次内部块滑动的位置

var inner=document.getElementById("up-map-div");

function touchSatrt(e){//触摸
    e.preventDefault();
    var touch=e.touches[0];
    startY = touch.pageY;   //刚触摸时的坐标
}
function touchMove(e){//滑动
     e.preventDefault();
     var  touch = e.touches[0];
     y = touch.pageY - startY;//滑动的距离
    //inner.style.webkitTransform = 'translate(' + 0+ 'px, ' + y + 'px)';  //也可以用css3的方式
    //console.log(inner.style.top);
    //console.log(aboveY+y);
    var hei = document.documentElement.clientHeight;
    document.getElementById("work").style.height = (hei-(aboveY+y+80))+'px';
    if((aboveY+y) < 40){
        inner.style.top="40px"; //这一句中的aboveY是inner上次滑动后的位置
    } else{
        inner.style.top=aboveY+y+"px"; //这一句中的aboveY是inner上次滑动后的位置
    }
}
function touchEnd(e){//手指离开屏幕
  e.preventDefault();
  aboveY=parseInt(inner.style.top);//touch结束后记录内部滑块滑动的位置 在全局变量中体现 一定要用parseInt()将其转化为整数字;
}//
 document.getElementById("touch").addEventListener('touchstart', touchSatrt,false);
 document.getElementById("touch").addEventListener('touchmove', touchMove,false);
 document.getElementById("touch").addEventListener('touchend', touchEnd,false);
</script>
