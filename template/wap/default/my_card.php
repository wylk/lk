<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>发布拼卡</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
  <style type="text/css">
  * { touch-action: none; }
  
   
    .cl-a{
        color: #29aee7;
    }
    .font-16-b{
        font-size: 16px;
        font-weight:bold;
    }
    .padd-10{
        padding: 10px;
    }

    .mui-card .mui-control-content {
        padding: 10px;
    }
    
    .mui-control-content {
        height: 600px;
    }
    .mui-pull-bottom-wrapper{
        text-align: center;
    }

  </style>

</head>
<body>
   <div class="content" style="padding-top:1px;">
         <div style="padding: 0px">
            <div id="segmentedControl" class="mui-segmented-control">
                <a class="mui-control-item mui-active" href="#item1">扔卡</a>
                <a class="mui-control-item" href="#item2">捞卡</a>
            </div>
        </div>
        <div class="card back-ff" style="border-radius: 2px;margin-top: 0px; ">
            <div>
                <div id="item1" class="mui-control-content mui-active">
                    <div id="scrol1" class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item2" class="mui-control-content ">
                    <div id="scrol2" class="mui-scroll-wrapper">
                        <div class="mui-scroll">
                            <ul class="mui-table-view">
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo STATIC_URL;?>mui/js/mui.min.js"></script>
<script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.js"></script>
<script src="<?php echo STATIC_URL;?>mui/js/mui.pullToRefresh.material.js"></script>
<script type="text/javascript">
    mui.init({
        swipeBack: true //启用右滑关闭功能
    });
 
    

    mui.init();
    (function($) {
        $.ready(function() {
            //循环初始化所有下拉刷新，上拉加载。
            $.each(document.querySelectorAll('.mui-control-content .mui-scroll'), function(index, pullRefreshEl) {
                //让对应的选项卡绑定事
                    $(pullRefreshEl).pullToRefresh({
                    up: {
                        auto:true,
                        contentrefresh: "正在加载..",
                        contentnomore: '没有更多数据了',
                        callback: function() {
                            var self = this;
                            console.log(324);
                            setTimeout(function() {
                                var ul = self.element.querySelector('.mui-table-view');
                                createFragment(ul, index, 5);
                                self.endPullUpToRefresh(0);
                            }, 100);
                        }
                    }
                });
            });
                    
                    
        });

        $(document.body).on('tap', '#release', function(e) {
                console.log(23432);
                
            });

            //核心渲染代码
            var createFragment = function(ul, index, count, reverse) {
                var length = ul.querySelectorAll('li').length;
                var fragment = document.createDocumentFragment();
                var li;
                for (var i = 0; i < count; i++) {
                    li = document.createElement('li');
                    li.className = 'mui-table-view-cell';
                    li.innerHTML = '第' + (index + 1) + '个选项卡子项-' + (length + (reverse ? (count - i) : (i + 1)));
                    fragment.appendChild(li);
                }
                ul.appendChild(fragment);
            };
    })(mui);
</script> 
</body>
</html>
