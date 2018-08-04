        
    var lk = {};
    var i = 1;
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

    function data(){
        $.post('index_ajax.php',{i:i,plugin:plugin},function(re){
            ++i;
            if(re.error == 0){
                $('.stores').append(re.msg);
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(false);
            }else{
                mui("#pullrefreshs").pullRefresh().endPullupToRefresh(true);
            }
        },'json');
    }

    function pullupRefresh(){
        setTimeout(function() {
            data();
        },1000); 
        mui.init();
    }

    function pulldownRefresh() {
        i = 1;//当前页码数
        setTimeout(function() {
            //mui('#pullrefreshs').pullRefresh().endPulldownToRefresh(); //refresh completed
            //mui('#pullrefreshs').pullRefresh().refresh(true); //激活上拉加载
            window.location.reload();
        }, 1500);
    }

    mui('body').on('tap','a',function(){document.location.href=this.href;});
  
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