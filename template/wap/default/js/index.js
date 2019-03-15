
    var lk = {};
    var i = 1,
    geolocation = null,
    Marker = null,
    geocoder = null,
    lng = null,
    lat = null,
    geocoder = null,
    del = 0,
    ref = 1,
    result = document.getElementById('resultMapInfo');
    var map = new AMap.Map('map', {
        resizeEnable: true,
        zoom: 16
      });
    mui('body').on('tap','a',function(){
        var url = this.href;
        if(url.indexOf("#") == -1){
            document.location.href = url;
        }
        
    });
  mui.init();
    //=======================================


    (function($) {
        //阻尼系数
        var deceleration = mui.os.ios?0.003:0.0009;
        $('.mui-scroll-wrapper').scroll({
            bounce: false,
            indicators: true, //是否显示滚动条
            deceleration:deceleration
        });

         map.plugin('AMap.Geolocation', function() {
      // 初始化定位插件
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true, //是否使用高精度定位，默认:true
            timeout: 10000, //超过10秒后停止定位，默认：无穷大
            maximumAge: 0, //定位结果缓存0毫秒，默认：0
            convert: true, //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
            showButton: true, //显示定位按钮，默认：true
            buttonPosition: 'LB', //定位按钮停靠位置，默认：'LB'，左下角
            buttonOffset: new AMap.Pixel(10, 20), //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            showMarker: false, //定位成功后在定位到的位置显示点标记，默认：true
            showCircle: false, //定位成功后用圆圈表示定位精度范围，默认：true
            panToLocation: true, //定位成功后将定位到的位置作为地图中心点，默认：true
            zoomToAccuracy: true //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
        });
        // 把定位插件加入地图实例
        map.addControl(geolocation);
        // 添加地图全局定位事件
        AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
        AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息

        // 调用定位
        geolocation.getCurrentPosition();
        mui.toast('定位中...',{ duration:'long', type:'div' }) 
    });

    /*
     *解析定位结果
     */
    function onComplete(data) {
        lng = data.position.getLng();
        lat = data.position.getLat();  
        document.getElementById('lng').value = lng;
        document.getElementById('lat').value = lat;
        pull();
       
    };
    /*
     *解析定位错误信息
     */
    function onError(data) {
        lat = 39.90469;
        lng = 116.40717;
        pull();
    };

       function pull(){
            //循环初始化所有下拉刷新，上拉加载。
            $.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function(index, pullRefreshEl) {
                $(pullRefreshEl).pullToRefresh({
                    up: {
                    auto: true,
                        callback: function() {
                            var self = this;
                            console.log(self);
                            setTimeout(function() {
                                var ul = self.element.querySelector('.mui-table-view');
                                console.log(ul);
                                createFragment(ul, index,self);
                                
                            }, 1000);
                        }
                    }
                });
            });
       }

         
    })(mui);

$(function(){
    $('#search').click(function(event) {
        document.location.href = './search.php'
    });
})
        


var createFragment = function(ul, index, self) {
    lng = document.getElementById('lng').value;
    lat = document.getElementById('lat').value;
    var length = ul.querySelectorAll('li').length;
    $.post('index_ajax.php',{i:length,plugin:index,lng:lng,lat:lat},function(re){
        if(re.error == 0){
            $(ul).append(re.msg);
            self && self.endPullUpToRefresh(0);
        }else{
            self && self.endPullUpToRefresh(1);
        }
    },'json');
}