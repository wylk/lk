<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    body,html {
      margin: 0;
      padding: 0;
      height: 100%;
      color: #fff;
    }
    .left,
    .right {
      float: left;
      width: 49%;
      height: 100%;
    }
    .left { border:1px solid #D3D3D3; }
    .right { border:1px solid #D3D3D3;}
    .lk-container-flex {padding: 0 5px;}
        .lk-content hr{margin: 0}
        .lk-nav-link a{width:30%;text-align: center; line-height: 45px; font-size:.5rem;}
        .lk-deal-link a{text-align: center; line-height: 45px; font-size:.5rem;padding: 0 20px;}
        .lk-deal-link a input[type='text']{
            display: inline;
            border:none;
        }
        .lk-justify-content-c{padding:25px;}
        .lk-bazaar-sell p{width:38%; padding-left:3%; line-height: 25px}
        .item-buy{align-self:center;  border:1px solid #FF5722; width:45px; border-radius: 50px; line-height: 45px; text-align: center;}
  </style>
  </head>

  <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>

    <div class="left">
        <ul class="layui-nav" lay-filter="">
            <li class="layui-nav-item layui-this"><a href="" class="site-demo-active">买入</a></li>
            <li class="layui-nav-item"><a href="" class="site-demo-active">买出</a></li>
        </ul>
        <div class="lk-content" style="margin-top: -50px;">
            <hr>
            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                    <a href="javascript:;">买入价：<input type='text' name="buyPrice" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')"></a>
                    <a href="javascript:;">余额：<?= number_format($card['num'],2); ?></a>
            </div>
            <hr>
            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                    <a href="javascript:;">买入数量：<input type='text' name="buyNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                    <a href="javascript:;">WLK</a>
            </div>
            <hr>
            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                    <a href="javascript:;">最低买入量：<input type='text' name="limitNum" value='' placeholder="0.00" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" />
                    <a href="javascript:;">WLK</a>
            </div>
            <hr>
            <div class="lk-container-flex lk-justify-content-sb lk-deal-link">
                    <a href="javascript:;">兑换资金：<span id="money">0.00</span></a>
                    <a href="javascript:;">CNY</a>
            </div>
            <hr>
            <div class="lk-container-flex lk-justify-content-c">
                <a href="javascript:;" id="buyTran" class="layui-btn" style="width: 90%">买入</a>
            </div>
        </div>
        <div class="lk-container-flex">
            <h1 style="font-size:16px; font-weight: 600; padding:20px 0 10px 20px">市场卖单</h1>
        </div>
        <hr>
        <div class="lk-container-flex">
            <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
                <p class="item-flex">王**</p>
                <p class="item-flex">900WLK</p>
                <p class="item-flex">在线</p>
                <p class="item-flex">价格：1</p>
                <p class="item-flex">logo</p>
                <p class="item-flex">限额：100-900</p>
            </div>
        </div>
  </div>
  <div class="right" style="color:#000000">
        <div class="lk-container-flex">
            <h1 style="font-size:16px; font-weight: 600; padding:20px 0 10px 20px">市场卖单</h1>
        </div>
        <hr>

        <?php foreach($buyList as $k=>$v){ ?>
        <hr>
        <div class="lk-container-flex">
            <div class="lk-container-flex lk-flex-wrap-w lk-bazaar-sell">
                <p class="item-flex">王**</p>
                <p class="item-flex"><?= number_format($v['num'],2) ?>WLK</p>
                <p class="item-flex">在线</p>
                <p class="item-flex">价格：<?= number_format($v['price'],2) ?></p>
                <p class="item-flex">logo</p>
                <p class="item-flex">限额：<?= number_format($v['limit'],2) ?> - <?= number_format($v['num'],2) ?></p>
            </div>
            <div class="lk-container-flex">
                <p class="item-buy"><a href="">买入</a></p>
            </div>
        </div>
        <?php } ?>
        <hr>
    </div>
    <script type="text/javascript">
    layui.use(['layer'],function(){
        $("#buyTran").bind("click",function(){
            layer.load();
            var buyPrice = $("[name=buyPrice]").val();
            var buyNum = $("[name=buyNum]").val();
            var limitNum = $("[name=limitNum]").val();
            var money = buyPrice*buyNum;
            var id = "<?php echo $card['id']; ?>";
            var data = {"buyPrice":buyPrice,"buyNum":buyNum,'id':id,"limitNum":limitNum};
            $.post("?c=hairpin&a=index",data,function(result){
                console.log(result);
                layer.closeAll("loading");
                if(!result.res){
                    layer.msg(result.msg,{icon:1,skin:"demo-class"});
                }else{
                    layer.msg(result.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
        });
        $("input[name^=buy]").bind("keyup",function(){
            var buyPrice = $("[name=buyPrice]").val();
            var buyNum = $("[name=buyNum]").val();
            var money = buyPrice*buyNum;
            $("#money").html(money);
        })
        // $("[name=limitNum]").bind("keyup",function(){
        //     var buyNum = $("[name=buyNum").val();
        //     var limitNum = $("[name=limitNum]").val();
        //     if(limitNum > buyNum){
        //         layer.msg('最低购买数量不得大于购买数量',{icon:5,skin:"demo-class"});
        //     }
        // });
    })
    //注意：导航 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element', 'layer', 'jquery'], function () {
        var element = layui.element;
        // var layer = layui.layer;
        var $ = layui.$;
        // 配置tab实践在下面无法获取到菜单元素
        $('.site-demo-active').on('click', function () {
            var dataid = $(this);
            //这时会判断右侧.layui-tab-title属性下的有lay-id属性的li的数目，即已经打开的tab项数目
            if ($(".layui-tab-title li[lay-id]").length <= 0) {
                //如果比零小，则直接打开新的tab项
                active.tabAdd(dataid.attr("data-url"), dataid.attr("data-id"), dataid.attr("data-title"));
            } else {
                //否则判断该tab项是否以及存在
                var isData = false; //初始化一个标志，为false说明未打开该tab项 为true则说明已有
                $.each($(".layui-tab-title li[lay-id]"), function () {
                    //如果点击左侧菜单栏所传入的id 在右侧tab项中的lay-id属性可以找到，则说明该tab项已经打开
                    if ($(this).attr("lay-id") == dataid.attr("data-id")) {
                        isData = true;
                    }
                })
                if (isData == false) {
                    //标志为false 新增一个tab项
                    active.tabAdd(dataid.attr("data-url"), dataid.attr("data-id"), dataid.attr("data-title"));
                }
            }
            //最后不管是否新增tab，最后都转到要打开的选项页面上
            active.tabChange(dataid.attr("data-id"));
        });

        var active = {
            //在这里给active绑定几项事件，后面可通过active调用这些事件
            tabAdd: function (url, id, name) {
                //新增一个Tab项 传入三个参数，分别对应其标题，tab页面的地址，还有一个规定的id，是标签中data-id的属性值
                //关于tabAdd的方法所传入的参数可看layui的开发文档中基础方法部分
                element.tabAdd('demo', {
                    title: name,
                    content: '<iframe data-frameid="' + id + '" scrolling="auto" frameborder="0" src="' + url + '" style="width:100%;height:99%;"></iframe>',
                    id: id //规定好的id
                })
                FrameWH();  //计算ifram层的大小
            },
            tabChange: function (id) {
                //切换到指定Tab项
                element.tabChange('demo', id); //根据传入的id传入到指定的tab项
            },
            tabDelete: function (id) {
                element.tabDelete("demo", id);//删除
            }
        };
        function FrameWH() {
            var h = $(window).height();
            $("iframe").css("height",h+"px");
        }
    });
</script>



    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>
