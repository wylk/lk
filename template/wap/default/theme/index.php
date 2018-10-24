<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <title>用乐卡更省钱</title>
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
        <style type="text/css">
        body, html,#allmap {
            width: 100%;height: 100%;overflow: hidden;margin:0px;padding:0px;font-family:"微软雅黑";
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
          color: #999;
        }
        .action{
          color: rgba(76, 76, 73, 1); 
          border-bottom: 1px solid #29aee7;
        }
        .stores{
            margin: 0 auto;
            text-align: center;
            width: 95%;
        }
        .store{
            margin-top:5px;
            display: flex;
            align-items:center;
            height: 80px;
            background-color: #fff;
            border-radius: 5px;
            color:#999;
        }
        .img{
            width: 20%;
            line-height: 75px;
            margin-left: 8px;
        }
        .price{
           width: 50%;
           height: 80px;
           font-size: 13px;
           border-right: 1px dashed #999;
        }
        .price div{
            line-height: 40px;
            margin-left: 10px;
            text-align: left;

        }
        .font18{
            font-size: 18px;
        }
        .font20{
            font-size: 18px;
        }
        .num{
            height:80px;
            width: 25%;
        }
        .num div{
            line-height: 40px;
            font-size: 13px;
        }
        .black{
                color: rgba(76, 76, 73, 1);
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
            height:560px;
            top:220px;
            left:0px;
            position:absolute;
            z-index:1;
            background-color:rgba(0, 0, 02, 0.6);
            display: none;
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
          left: 0;
          top: 30px;
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
        <div id="resultMapInfo"></div>
        <div class="map" id="map"></div>
    
        <div id="up-map-div">
            <div id="touch" class="touch">  
                <!-- <img src="../template/wap/default/images/icon_map.png?r=12" style="height:33px;margin-top:-5px;border-r:"> -->
            </div>     
            <div class="wind_f" id="work">
              <div id="pullrefreshs" style="touch-action: none;">
               
                      <div class="lk-content" style="padding-top:0px ">

                          <div class="stores" >

                          </div>

                      </div>
                 
              </div>
            </div>
        </div>

        <?php include display('public_menu');?>
    </body>
</html>
<script src="https://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script> -->
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.5&key=0bda08c2afb77bff30115186de665721&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js?r=<?=time();?>"></script>
<script>
var startX,//触摸时的坐标
    startY,
     x, //滑动的距离
     y,
     aboveY=220; //设一个全局变量记录上一次内部块滑动的位置

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
    document.getElementById("work").style.height = (hei-(aboveY+y+80-20))+'px';
    document.getElementById("up-map-div").style.height = (hei-(aboveY+y+80-30))+'px';
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
