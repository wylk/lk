
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
    mui.init({
        pullRefresh : {
            container:'#pullrefreshs',
            down: {
                callback: pulldownRefresh
            },
            up : {
                height:50,
                auto:0,
                contentrefresh : "正在加载...",
                contentnomore:'没有更多数据了',
                callback :pullupRefresh 
            }
        }
    });

    function get_near_shops(){
        console.log();
        ($('#up-map-div').css('display') == 'none') && $('#up-map-div').css('display','block');
        $.post('index_ajax.php',{i:i,plugin:plugin,lng:lng,lat:lat},function(re){
            ++i;
           // console.log(del);
            if(del && re.error == 0){
                $('.stores').html('');
            }
            if(re.error == 0){
                $.each(re.mapinfo,function(i,val){
                    var content = '<div class="marker-route" ><p>'+val.enterprise+'</p></div>';
                    var marker = new AMap.Marker({
                        content: content,  // 自定义点标记覆盖物内容
                        position:  [val.lng, val.lat], // 基点位置
                        offset: new AMap.Pixel(15, -15), // 相对于基点的偏移位置
                        clickable:true,
                        title:"测试"+i,
                        map:map
                    });
                    marker.on('click', function(r){
                       //console.log(r);
                    });
                })


                $('.stores').append(re.msg);
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
                ref = 1;
            }else{
                ref = 0;
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
            }
        },'json');
    }

    function pullupRefresh(){
        setTimeout(function() {
            get_near_shops();
        },1000); 
        mui.init();
    }

    function pulldownRefresh() {
        ref && (del = 0);  
        setTimeout(function() {
            mui('#pullrefreshs').pullRefresh().endPulldownToRefresh(); //refresh completed
            mui('#pullrefreshs').pullRefresh().refresh(true); //激活上拉加载
            //window.location.reload();
        }, 1500);
    }

    mui('body').on('tap','a',function(){document.location.href=this.href;});
  //===========================================
    lk.divaction = function (lr,f){
         var type = '';
        $('.lk-titles div').each(function(i){
            var str = $(this).attr("class");
            if(str.indexOf("action") != -1 ){
                type = $(this).data('id'); 
            }
        })
        if(lr == 'right'){
            f(type == 1?{a:1,b:0}:{a:(type-1),b:1});
        }else{
            f(type == 4?{a:4,b:0}:{a:(type+1),b:1});
        }
    }  

     lk.slide = function (slide){
        document.getElementById('pullrefreshs').addEventListener("swipe"+slide,function() {
        lk.divaction(slide,function(res){
           if(res.b)window.document.location.href = 'index.php?plugin='+res.a;
        })
        });
    }

    lk.slide('left'); 
    lk.slide('right'); 
    //=======================================
    $(function(){
    // 添加地图全局移动事件
    // 移动中
    AMap.event.addListener(map, 'dragging', function() {
        $('#up-map-div').css('display','none');
        Marker.setPosition(map.getCenter())
    });
    // 停止移动
    AMap.event.addListener(map, 'dragend', function() {
        console.log(map.getCenter())
        // 利用地图地理编码查询地址
        geocoder.getAddress(map.getCenter(), function(status, data) {
        if (status === 'complete' && data.info === 'OK') {
            //获得了有效的地址信息:
            //即，
            var str = '';
            //var str = '<p>获取成功</p>';
            str += '<p>当前位置：' + data.regeocode.formattedAddress + '</p>';
            result.innerHTML = str;
            //console.log(data.regeocode.formattedAddress)
            //console.log(map.getCenter().getLat())
            //console.log(map.getCenter().getLng())
            lng = map.getCenter().getLng();
            lat = map.getCenter().getLat();
            del = 1;
            i = 1;
            get_near_shops();
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
          result.innerHTML = str;
        }
      });
      Marker.setPosition(map.getCenter());
      Marker.setAnimation('AMAP_ANIMATION_DROP');
    });

    // 加载地理位置编码插件
    AMap.service('AMap.Geocoder', function() { //回调函数
      //实例化Geocoder
      geocoder = new AMap.Geocoder({
        city: "010" //城市，默认：“全国”
      });
      //TODO: 使用geocoder 对象完成相关功能
    });
    // 加载定位插件
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
      //str += '<p>经度：' + data.position.getLng() + '</p>';
      //str += '<p>纬度：' + data.position.getLat() + '</p>';
      //str += '<p>精度：' + data.accuracy + ' 米</p>';
      //str += '<p>是否经过偏移：' + (data.isConverted ? '是' : '否') + '</p>';
      str += '<p>当前位置：' + data.formattedAddress + '</p>';
      //str += '<p>' + data.addressComponent.province + data.addressComponent.city + data.addressComponent.district + data.addressComponent.township + data.addressComponent.street + data.addressComponent.streetNumber + '</p>';
      // 初始化标记
      setTimeout(function() {
            get_near_shops();
        },1000); 
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

      result.innerHTML = str;
    };
    /*
     *解析定位错误信息
     */
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
      result.innerHTML = str;
    };
});