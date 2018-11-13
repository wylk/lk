<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/sweetalert/css/sweet-alert.css">
    
    <style type="text/css">
        *{
            padding: 0px;
            margin: 0px;
        }
        html,body{
            height: 100%;
        }
        .content{
            height: 100%;
        }
        input{
            height: 31px;
            width: 80%;
            position: absolute;
            top: 6px;
            left: 10%;
            z-index: 1;
            border: 1px solid #01AAED;
            border-radius: 5px;
            text-align: center;
        }
        .button{
            width: 130px;
            line-height: 36px;
            background-color: #01AAED;
            border: 0px;
            border-radius: 5px;
            text-align: center;
        }
        .up{
            position: absolute;
            bottom: 25px;
            z-index: 1px;
            width: 100%;
        }
        .btns{
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
<div class="content">
   <input type="text" name="" id="tipinput" placeholder="请输入店铺位置">
    <div id="container" style="height:100%;"></div>
</div>
<div class="up">
    <div class="btns">
        <div class="button" id="delete">取消</div>
        <div class="button" id="addmap">确认</div>
    </div>
</div>
<input type="hidden" name="lng" value="">
<input type="hidden" name="lat" value="">
<input type="hidden" name="address" value="">

</body>
</html>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>/sweetalert/js/sweet-alert.min.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.5&key=0bda08c2afb77bff30115186de665721&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
<script type = "text/javascript" >
var Marker = null;
var geocoder = null;
var url = "<?=$referer?>";
// 地图定位
var map = new AMap.Map("container", {
    resizeEnable: true,
    zoom: 16
});

$(function() {

    var auto = new AMap.Autocomplete({input: "tipinput"});
    AMap.event.addListener(auto, "select", select); //注册监听，当选中某条记录时会触发


    function select(e) {  
        map.setCenter([e.poi.location.lng, e.poi.location.lat]);
        var marker = new AMap.Marker({
            position: [e.poi.location.lng, e.poi.location.lat],
            zoom: 15
        });
        Marker.setPosition(map.getCenter());
        Marker.setAnimation('AMAP_ANIMATION_DROP');

        ediell(e.poi.location.lng, e.poi.location.lat, e.poi.address)
    }
    $('#addmap').click(function(e) {
        var lng_data = $("input[name='lng']").val();
        var lat_data = $("input[name='lat']").val();
        var address_data = $("input[name='address']").val();
        if (lng_data.length < 1) {

        }
        var post_data = {lng:lng_data,lat:lat_data,address:address_data}
        
        $.post('./map.php', post_data, function(re) {
            if(re.error == 0){
                swal("提示!", re.msg, "success");
                setTimeout(function(){
                    window.location.href=url;
                },1000);
            }else{
                swal('提示！',re.msg,'error');
            }

        }, 'json');
    })
    $('#delete').click(function() {
        window.location.href = "./setup.php";
    })

    AMap.event.addListener(map, 'dragging', function() {
        Marker.setPosition(map.getCenter())
    });
    // 停止移动
    AMap.event.addListener(map, 'dragend', function() {
        // 利用地图地理编码查询地址
        geocoder.getAddress(map.getCenter(), function(status, data) {
            if (status === 'complete' && data.info === 'OK') {
                lng = map.getCenter().getLng();
                lat = map.getCenter().getLat();
                ediell(lng, lat, data.regeocode.formattedAddress);
            } else {
                //获取地址失败
                var str = '<p>定位失败</p>';
                str += '<p>错误信息：'
                switch (data.info) {
                case 'INVALID_UESR_KEY':
                    str += '用户key非法或过期';
                    break;
                case 'SERVICE_UNAVAILABLE':
                    str += '请求服务不可用';
                    break;
                case 'INSUFFICIENT_PRIVILEGES':
                    str += '无权限访问此服务';
                    break;
                case 'INVALID_PARAMS':
                    str += '请求参数非法';
                    break;
                default:
                    str += '无网络或其他未知错误';
                    break;
                }
                str += '，请重新获取当前位置。</p>';
            }
        });
        Marker.setPosition(map.getCenter());
        Marker.setAnimation('AMAP_ANIMATION_DROP');
    });

    AMap.service('AMap.Geocoder', function() { //回调函数
        
        geocoder = new AMap.Geocoder({
            city: "010" //城市，默认：“全国”
        });
        
    });

    // 加载定位插件
    map.plugin('AMap.Geolocation', function() {
        // 初始化定位插件
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,
            //是否使用高精度定位，默认:true
            timeout: 10000,
            //超过10秒后停止定位，默认：无穷大
            maximumAge: 0,
            //定位结果缓存0毫秒，默认：0
            convert: true,
            //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
            showButton: true,
            //显示定位按钮，默认：true
            buttonPosition: 'LB',
            //定位按钮停靠位置，默认：'LB'，左下角
            buttonOffset: new AMap.Pixel(10, 20),
            //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            showMarker: false,
            //定位成功后在定位到的位置显示点标记，默认：true
            showCircle: false,
            //定位成功后用圆圈表示定位精度范围，默认：true
            panToLocation: true,
            //定位成功后将定位到的位置作为地图中心点，默认：true
            zoomToAccuracy: true //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
        });
        // 把定位插件加入地图实例
        map.addControl(geolocation);

        // 添加地图全局定位事件
        AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
        AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息
        // 调用定位
        geolocation.getCurrentPosition();
    });

    /*
     *解析定位结果
     */

    function onComplete(data) {
        Marker = null;
        var str = '';
        //var str = '<p>定位成功</p>';
        lng = data.position.getLng();
        lat = data.position.getLat();

        str += '<p>当前位置：' + data.formattedAddress + '</p>';
        if (Marker) {
            // 标记存在则把地图中心点设置给标记
            Marker.setPosition(map.getCenter())
            Marker.setAnimation('AMAP_ANIMATION_DROP')
        } else {
            // 标记不存在则实例化一个新的标记，且把当前地图中心点设置给标记
            Marker = new AMap.Marker({
                position: map.getCenter(),
                animation: 'AMAP_ANIMATION_DROP'
            });
            // 把标记加入地图实例
            Marker.setMap(map);
        }

    };

    function onError(data) {
        var str = '';
        //var str = '<p>定位失败</p>';
        str += '<p>错误信息：'
        switch (data.info) {
        case 'PERMISSION_DENIED':
            str += '浏览器阻止了定位操作';
            break;
        case 'POSITION_UNAVAILBLE':
            str += '无法获得当前位置';
            break;
        case 'TIMEOUT':
            str += '定位超时';
            break;
        default:
            str += '无网络或其他未知错误';
            break;
        }
        str += '，请重新获取当前位置。</p>';
        // 初始化标记
        if (Marker) {
            // 标记存在则把地图中心点设置给标记
            Marker.setPosition(map.getCenter())
            Marker.setAnimation('AMAP_ANIMATION_DROP')
        } else {
            // 标记不存在则实例化一个新的标记，且把当前地图中心点设置给标记
            console.log(map);
            Marker = new AMap.Marker({
                position: map.getCenter(),
                animation: 'AMAP_ANIMATION_DROP'
            });
            // 把标记加入地图实例
            Marker.setMap(map);
        }
    };
    $('.amap-geo').css({'display':'none'});
})

function ediell(lng, lat, address) {
    $("input[name='lng']").val(lng);
    $("input[name='lat']").val(lat);
    $("input[name='address']").val(address);
} 
</script>




