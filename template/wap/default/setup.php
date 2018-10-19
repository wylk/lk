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
     <header class="lk-bar lk-bar-nav">
    <i onclick="javascript:history.back(-1);" class="iconfont" style="font-size: 20px;">&#xe697;</i>
    <h1 class="lk-title">设置</h1>
  </header>
<div class="lk-content" style="background-color: #f0f0f0;">
    <a href="./pay_pw.php">
        <div class="item-row lk-container-flex" style="margin: 20px auto 0px;">
            <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe71c;</i></div>
            <div class="item-row-title row" >账户安全设置</div>
            <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
        </div>
    </a>
    <hr class="layui-bg-gray">
    <a href="./pay_zf.php">
         <div class="item-row lk-container-flex" style="margin: 0px auto">
            <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe71c;</i></div>
            <div class="item-row-title row" >支付管理</div>
            <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
        </div>
    </a>
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6ba;</i></div>
        <div class="item-row-title row" >消息设置</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>

    <div class="item-row lk-container-flex" style="margin: 20px auto 0px;" id="map">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe715;</i></div>
        <div class="item-row-title row"  >地理位置设置</div>
        <div class="item-row-arrow row center" ><i class="iconfont"   style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6c7;</i></div>
        <div class="item-row-title row" >联系客服</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <hr class="layui-bg-gray">
    <div class="item-row lk-container-flex" style="margin: 0px auto">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe6f5;</i></div>
        <div class="item-row-title row" >关于我们</div>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    <a href="javascript:;" id = "signOut">
     <div class="item-row lk-container-flex" style="margin: 40px auto 10px;">
        <div class="item-row-icon row center"><i class="iconfont" style="font-size: 20px;">&#xe718;</i></div>
           <?php if(is_weixin()){?>
              <div class="item-row-title row" >清除缓存</div>
        <?php }else{?>
             <div class="item-row-title row" >退出登录</div>
         <?php } ?>
        <div class="item-row-arrow row center"><i class="iconfont" style="font-size: 20px;">&#xe6a7;</i></div>
    </div>
    </a>
    <div class="row-flow"></div>
</div>
<div class="cont" style="display: none;margin-top:30px; ">
    <div style="margin-top:76px ">
        <span style="color: #40753a;margin-left: 15px;font-size: 18px;">请输入您的位置：</span><input type="text" name="" id="tipinput" style="z-index: 9999;float: right;width: 174px;height: 35px;margin-right: 22px;"></div>
    <div id="container" style="height: 386px;width: 100%;border: 1px solid #2e8a2f;position: relative;background: rgb(252, 249, 242);margin-top: 40px;"></div>
    <div style="margin-left: 27%;margin-top: 22px;"><button style="margin-top: 15px;margin-right: 25px;width: 73px;height: 32px;background-color: #1f9407" id="addmap">确认</button><button style="margin-top: 15px;margin-right: 25px;width: 73px;height: 32px;background-color: #1f9407" id="delete">取消</button></div>
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

        layui.use(['form','layer'], function(){
            var layer = layui.layer;
            //退出登录
            $("#signOut").bind("click",function(){
                var phone = <?php echo $wap_user['phone'];?>;
                $.post("./login.php",{phone:phone,type:"signOut"},function(res){
                    if(res.error == 0){
                        layer.msg(res.msg,{icon:1,time:2000},function(){
                            window.location.href = "./login.php";
                        });
                    }
                },'json')
            })
        });
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
                    url:"http://lk.com/wap/add_map.php",
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
                        url:"http://lk.com/wap/map_name.php",
                        data:{name:input},
                        dataType:'json',
                        success:function(r){
                            if(r.res=1){
                                alert(r.msg);
                                window.location.href = "http://lk.com/wap/setup.php";
                            }
                        }
                    });
                }
            })
            $('#delete').click(function(){
               $('.cont').css('display', 'none');
            })
</script>



