<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>卡包</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/css/base.css?r=1">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/iconfont.css?r=<?php echo time();?>">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style type="text/css">
        body{
            background-color: #f2f2f2;
        }
        ul{padding:0px; margin: 0px}
        ul.lk-container-flex {width: 100%}
        .lk-content{margin: 0;padding:0px;}
        .lk-card-package{margin: 0 5px 8px;border:1px solid #dedede; border-radius: 3px; height: 125px;background-color: #fff;}
        .card-info{width:80%;line-height: 25px; padding:0 10px;height:73px;}
        .card-logo p{width:50px; height: 50px; border-radius: 50%; border:0px solid #000;
                    background: url("/static/sweetalert/images/vs_icon@2x.png") no-repeat;
                    background-size: 110% 110%;
                }
        .card-handle{width:20%; border-right:1px solid #ded5d5; line-height: 30px; margin:5px 0; text-align: center; color: #666;font-size: 14px;}
        hr{background-color: #e6e6e6;}
        hr.cut-off-rule{margin:10px 0;}
        .no-border{
            border-right: 0px;
        }
        .mui-search {
            position: relative;
            margin: 0px 8px;
        }
        p{color: #333}
        /*.mui-scroll-wrapper,.mui-scroll,.mui-scrollbar{position: relative;}*/
    </style>
</head>

<body >
    <div class="lk-content">
        <!-- <div class="lk-container-flex" style="padding-left: 15px;height: 15px;"> -->
          <!--  <i class="layui-icon layui-icon-layer" style="font-size: 35px; color:#1E9FFF">&#xe638;</i>
          <h1 style="font-size:18px; line-height: 38px; margin-left:15px">卡包</h1> -->
        <!-- </div> -->


        <div id="pullrefreshs" class="mui-content mui-scroll-wrapper"  >
            <div class="mui-scroll"  >

                <div class="mui-input-row mui-search" style="margin-top: 10px">
                    <input type="search" class="mui-input-clear" placeholder="输入卡券名">
                </div>
        
                <div id="content"></div>
            </div>
        </div>

        <!-- <?php foreach($cardList as $key=>$value){ ?>

        <div class="lk-container-flex lk-card-package lk-flex-direction-c">
            <?php if($value['type'] == option("hairpan_set.platform_type_name")){ ?>
            <a href="card_buy.php?uid=<?php echo $value['uid'] ?>" class="lk-container-flex" style="padding:10px 0;border-bottom: 1px solid #e6e6e6;">
            <?php }else{ ?>
            <a href="home.php?card_id=<?php echo $value['card_id'] ?>&plugin=<?php echo $value['type'] ?>&shoreUid=<?php echo $cardAttrArr[$value['card_id']]['uid'] ?>" class="lk-container-flex" style="padding:10px 0;border-bottom: 1px solid #e6e6e6;">
            <?php } ?>
                <div class="item-flex card-info">
                    <p><?php echo $value['type']==option("hairpan_set.platform_type_name") ? '乐卡' : $cardType[$cardAttrArr[$value['card_id']]['uid']]; ?>
                    ：
                        <?php echo isset($cardAttrArr[$value['card_id']]['name']) ? $cardAttrArr[$value['card_id']]['name'] : $value['type'] ?>
                    </p>
                    <p style="font-size: 13px;color: #999"><span style="margin-right: 20px;">可用：<i style="font-size: 14px;color: #333;"><?php echo number_format($value['num'],2) ?></i></span> 锁定：<?php echo number_format($value['frozen']+$value['bail'],2) ?></p>
                </div>
                <div class="item-flex card-logo">
                    <p <?php echo isset($cardAttrArr[$value['card_id']]['card_log']) ? 'style="background:url('.$cardAttrArr[$value['card_id']]['card_log'].') no-repeat;background-size: 100% 100%;"' : '' ?> ></p>
                </div>
            </a>

            <div class="lk-container-flex lk-flex-direction-r">
                <ul class="lk-container-flex lk-justify-content-sa">
                    <a class="card-handle" href="./transferBill.php?cardId=<?php echo $value['card_id'] ?>">核销</a>
                    <a class="card-handle" href="./changeInto.php?id=<?php echo $value['id'] ?>">充值</a>

                    <a class="card-handle" href="./recordBooks.php?cardId=<?php echo $value['card_id']; ?>">账单</a>
                    <?php if($value['type'] == option("hairpan_set.platform_type_name")){ ?>
                    <a class="card-handle no-border" href="card_buy.php?uid=<?php echo $value['uid'] ?>">交易</a>
                    <?php }else{ ?>
                    <a class="card-handle no-border" href="./transaction.php?cardId=<?php echo $value['card_id'] ?>">出售</a>
                    <?php } ?>
                </ul>
            </div>

    </div> -->
       <!--  <hr class="cut-off-rule"> -->
        <!-- <?php } ?> -->
    </div>
          </div>
        </div>

    <?php  include display('public_menu');?>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js"></script>
</body>

</html>
<script type="text/javascript">
    mui('body').on('tap','a',function(){
        window.top.location.href=this.href;
    });
</script>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script> -->

<script>
 
    var i = 1;
    var cardlist = "<?php echo count($cardlist) ?>";
    mui.init({
        pullRefresh : {
            container:'#pullrefreshs',
            down: {
                callback: pulldownRefresh
            },
            up : {
                height:50,
                auto:true,
                contentrefresh : "正在加载...",
                contentnomore:'没有更多数据了',
                callback :pullupRefresh
            }
        }
    });

    // function data(){
    //     var i = 1;
    //     $.post('cardList_cart.php',{},function(re){
    //         ++i;
    //         var arr = []
    //         for(let i in re) {
    //             arr.push(re[i])
    //         }
    //         if(cardlist > i){
    //              mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
    //          }else{
    //              mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
    //          }
    //         // $('#scroller').hide();
    //         // $('#scroller').append('乔');
    //         console.log(arr);

    //     },'json');
    // }
$(".mui-search input").keyup(function(){
    var search = $(".mui-search input").val();
    // mui.toast(search);
    console.log(search);
    var data = {type:"page",page:1,search:search};
    $.post("./card_package.php",data,function(result){
        console.log(result);
        if(result.error == 0 && result.data.cardlist.length>0){
            var htmlStrs = "";
            $.each(result.data.cardlist,function(key,value){
                htmlStrs += htmlStr(value,result.data.cardAttrArr,result.data.cardType);
            })
            $(".mui-scroll #content").html(htmlStrs);
            page = 2;
        }
    },"json");
});
var originalHeight = document.documentElement.clientHeight || document.body.clientHeight;
window.onresize = function(){
    var resizeHeight = document.documentElement.clientHeight || document.body.clientHeight;
    if(resizeHeight-0 < originalHeight-0){
        $(".mui-bar-tab").hide();
    }else{
        $(".mui-bar-tab").show();
    }
}


var page = 1;
    function pullupRefresh(){
        var search = $(".mui-search input").val();
        console.log(search);
        var search = $(".mui-search input").val();
        var data = {type:"page",page:page,search:search};
        $.post('./card_package.php',data,function(result){
            console.log(result);
            var htmlStrs = '';
            console.log(result.data.cardlist.length);
            if(result.error == 0 && result.data.cardlist.length>0){
                $.each(result.data.cardlist,function(key,value){
                    htmlStrs += htmlStr(value,result.data.cardAttrArr,result.data.cardType);
                })
                page++;
                $(".mui-scroll #content").append(htmlStrs);
                 mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
            }else{
                 mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
            }
        },"json");
    }

    function pulldownRefresh() {
       // i = 1;//当前页码数
       var data = {type:"page",page:1}
       $.post('./card_package.php',data,function(result){
        console.log(result);
            if(result.error == 0 && result.data.cardlist.length > 0){
                var htmlStrs = '';
                $.each(result.data.cardlist,function(key,value){
                    htmlStrs += htmlStr(value,result.data.cardAttrArr,result.data.cardType);
                })
                $(".mui-scroll #content").html(htmlStrs);
                page = 2;
                mui("#pullrefreshs").pullRefresh().endPulldownToRefresh(false);
                mui("#pullrefreshs").pullRefresh().refresh(true);
                // mui("#pullrefreshs").pullRefresh().enablePullupToRefresh();
            }
       },"json");
    }
var platform_type_name = "<?php echo option("hairpan_set.platform_type_name") ?>";
function htmlStr(data,cardAttrArr,cardType){
    var num = new Number(data['num']);
    var frozen = new Number(data['frozen']);
    var bail = new Number(data['bail']);

    var str = '';
    str += '<div class="lk-container-flex lk-card-package lk-flex-direction-c">';
    if(data['type'] == platform_type_name){
    str += '<a href="card_buy.php?uid='+data['uid']+'" class="lk-container-flex" style="padding:10px 0;border-bottom: 1px solid #e6e6e6;">';
    }else{
        str += '<a href="home.php?card_id='+data['card_id']+'&plugin='+data['type']+'&shoreUid='+cardAttrArr[data['card_id']]['uid']+'" class="lk-container-flex" style="padding:10px 0;border-bottom: 1px solid #e6e6e6;">';
    }
        str += '<div class="item-flex card-info">';
            if(data['type'] == platform_type_name) str += '<p>乐卡：leka </p>';
        else str += '<p>'+cardType[cardAttrArr[data['card_id']]['uid']]+"："+cardAttrArr[data['card_id']]['name']+"</p>";
            str += '<p style="font-size: 13px;color: #999"><span style="margin-right: 20px;">可用：<i style="font-size: 14px;color: #333;">332</i></span> 锁定：'+(frozen+bail).toFixed(2)+'</p>';
        str += '</div>';
        str += '<div class="item-flex card-logo"><p ';
        if(data['type'] != platform_type_name){
            if(cardAttrArr.hasOwnProperty(data['card_id']) && cardAttrArr[data['card_id']].hasOwnProperty('card_log')){
                str += 'style="background:url('+cardAttrArr[data['card_id']]['card_log']+') no-repeat;background-size: 100% 100%;"';
            }
        }
        str += ' ></p>';
        str += '</div>';
    str += '</a>';
    str += '<div class="lk-container-flex lk-flex-direction-r">';
        str += '<ul class="lk-container-flex lk-justify-content-sa">';
            str += '<a class="card-handle" href="./transferBill.php?cardId='+data['card_id']+'">核销</a>';
            str += '<a class="card-handle" href="./changeInto.php?id='+data['id']+'">充值</a>';
            str += '<a class="card-handle" href="./recordBooks.php?cardId='+data['card_id']+'">账单</a>';
            if(data['type'] == platform_type_name){
            str += '<a class="card-handle no-border" href="card_buy.php?uid='+data['uid']+'">交易</a>';
            }else{
            str += '<a class="card-handle no-border" href="./transaction.php?cardId='+data['card_id']+'">出售</a>';
            }
            str += '</ul>';
    str += '</div>';
    str += '</div>';
    return str;

}

    document.getElementById('pullrefreshs').addEventListener("swiperight",function() {
           document.location.href='./index.php';
  });

   // (function($){
   //      $(".mui-scroll-wrapper").scroll({
   //          bounce:false,
   //          indicators:false
   //      })
   //  })
</script>

