mui("body").on("tap","a",function(){
    document.location.href = this.href;
})
mui.init();
  var page = new Array();
  function inter(file,outContainer,container,content,attrName=null){
     $.each(document.querySelectorAll(outContainer), function(index, pullRefreshEl) {
      // console.log(attrName);
      if(attrName){
        var nameStr = $(pullRefreshEl).attr(attrName);
        var type = nameStr.substring(nameStr.indexOf("_")+1);
        var containerId = container+type;
        var contentId = content+type;
        var file1 = file+"?action="+type;
        // var file1 = file;
      }else{
        var type = "default_type";
        var contentId = content;
        var containerId = container;
        var file1 = file;
      }
        page[type] = 1;
        mui(containerId).pullRefresh({
            container:containerId,
            down: {
                callback: function(){
                    pulldownRefresh({type:type,containerId:containerId,contentId:contentId,file:file1});
                }
            },
            up: {
                height:50,
                auto:true,
                contentrefresh : "正在加载...",
                contentnomore:'没有更多数据了',
                callback :function(){
                    pullupRefresh({type:type,containerId:containerId,contentId:contentId,file:file1});
                }
            }
        }) 
    });
  }

  function pulldownRefresh(arr){
    setTimeout(function(){
      arr['action'] = 'down';
      arr['page'] = 1;
      data(arr);
    },1000);
  }
  function pullupRefresh(arr){
    setTimeout(function(){
      arr['action'] = "up";
      arr['page'] = page[arr["type"]];
      data(arr);
    },1000);
      mui.init();
  }

  function data(arr){
    $.post(arr["file"],{page:arr["page"]},function(res){
      console.log(res);
      if(!res['error']){
        page[arr["type"]] = res['data']['page'];

        // 1、加载HTML
        var htmlStr = "";
        $.each(res.data.data,function(){
          htmlStr += strFunc(this);
        });
        // 2、判断 上拉、下拉 操作
        if(arr['action'] == 'down'){
          $(arr["contentId"]).html(htmlStr);
          console.log(arr);
          mui(arr["containerId"]).pullRefresh().endPulldownToRefresh(); //refresh completed
          mui(arr["containerId"]).pullRefresh().refresh(true); //激活上拉加载
        }else if(arr['action'] == 'up'){
          $(arr["contentId"]).append(htmlStr);
          mui(arr["containerId"]).pullRefresh().endPullupToRefresh(false);
        }
        // 3、判断是否禁止上拉加载
        // if(res['data']['limit'] && res['data']['limit'] < res['data']['data'].length)
          // mui(arr["containerId"]).pullRefresh().disablePullupToRefresh();
      }else{
        mui(arr["containerId"]).pullRefresh().endPullupToRefresh(true);
        // mui(arr["containerId"]).pullRefresh().disablePullupToRefresh();  //禁止上拉加载
      }
    },"json");
  }
  // function endPullupToRefresh(finished){
  //   if(finished){

  //   }
  // }
function getTime(time=null){
  var date = new Date();
  if(time){
    date.setTime(time * 1000);
  }
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  m = m < 10 ? ("0"+m) : m;
  var d = date.getDate();
  d = d < 10 ? ("0" + d) : d;
  var h = date.getHours();
  h = h < 10 ? ("0" + h) : h;
  var i = date.getMinutes();
  i = i < 10 ? ("0" + i) : i;
  var s = date.getSeconds();
  s = s < 10 ? ("0" + s) : s;
  // console.log(time,time,y,m,d,h,s);
  return y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
}