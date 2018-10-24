<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
    <style type="text/css">

        .item-row{
            background-color: #fff;
            width: 100%;
            line-height: 45px;
        }
        .item-row-title{
           flex-grow: 1;
        }
        .center{
            text-align: center;
        }
        .row{
            width: 18%;
        }
        .layui-bg-gray{
            margin: 0px 0px;
        }
        .row-flow{
            height: 10px;
        }
    </style>
</head>
<body>
<div class="cont" style="display: block;margin-top:30px; ">

    <div id="container" style="height: 100%;width: 100%;border: 1px solid #94bef1;position: relative;background: rgb(252, 249, 242);margin-top: -40px;"></div>
     <div style="margin-top:76px ">
       <input type="text" name="" id="tipinput" style="border-style: none;border-bottom-style: solid;border-bottom-width: 3px;border-bottom-color: #168fbb;height: 47px;margin-left: 38px;width: 52%;" placeholder="请输入店铺位置">
  <button style="    width: 49px;
    height: 50px;
    background-color: #168fbb;
    border: 0px;
    border-radius: 99px;
    margin-left: 30px;" id="addmap">确认</button></div>
</div>
</body>
</html>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.5&key=0bda08c2afb77bff30115186de665721&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
<script type="text/javascript">
          var lng = lng || 116.39773;
          var lat = lat || 39.907815;

            $('#map').click(function(){
                $('.lk-bar').hide();
                $('.lk-content').hide();
                $('.cont').show();
            })
          // 地图定位
            var map = new AMap.Map("container", {
                resizeEnable: true,
                center: [lng, lat],
                zoom: 10
            });
            var marker = new AMap.Marker({
                    position: [lng, lat],
                    zoom: 10
                });
             // console.log(marker);
             //图标
             marker.setMap(map);
            //输入提示
            var autoOptions = {
                input: "tipinput"
            };


            var auto = new AMap.Autocomplete(autoOptions);

            var placeSearch = new AMap.PlaceSearch({
                map: map
            });  //构造地点查询类
             // console.log(placeSearch);
            AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
            function select(e) {
                setLenLat([e.poi.location.lng,e.poi.location.lat]);
            }
            map.on('click', function(e) {
                // console.log(e);
                lnglat = [e.lnglat.lng,e.lnglat.lat];
                setLenLat(lnglat);

            });
            function setLenLat(lnglat){
                map.clearMap();
                map.setCenter(lnglat);
                var marker = new AMap.Marker({
                    position: lnglat,
                    zoom: 10
                });
                marker.setMap(map);
                //经纬度入库
                $.ajax({
                    type:"post",
                    url:"./add_map.php",
                    data:{lnglat:lnglat},
                    dataType:'json',
                    success:function(r){
                         if(r.res=0){
                            alert(r.msg);
                         }
                    }
               })
                console.log(lnglat);
                ediell(lnglat[0],lnglat[1])
            }

            function ediell(lng,lat){
                $("input[name='lng']").val(lng);
                $("input[name='lat']").val(lat);
                $("input[name='lat_status']").val(1);
            }
            // 地图定位
            // 地址入库
            $('#addmap').click(function(e){
                var input=$('#tipinput').val();
                if(input==''){
                    alert('请填写您的位置');
                }else{
                   $.ajax({
                        type:"post",
                        url:"./map_name.php",
                        data:{name:input},
                        dataType:'json',
                        success:function(r){
                            if(r.res=1){
                                alert(r.msg);
                                window.location.href = "./setup.php";
                            }
                        }
                    });
                }
            })
            $('#delete').click(function(){
                window.location.href = "./setup.php";
            })
</script>




