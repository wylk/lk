<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>卡圈</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>mui/css/icons-extra.css" />
    <link rel="stylesheet" type="text/css" href="http://cdn.staticfile.org/webuploader/0.1.0/webuploader.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>LUploader/css/LUploader.css?r=2321">
    
    <style type="text/css">
        body{background: white;color: #333;}
        .mui-table-view:before{height:0;}
        .mui-media-object{border-radius: 5px;}
        .mui-ellipsis{white-space:normal;}

        .image_block{display: flex; flex-direction: column; justify-content: space-between;}
        .image_block .mui-media-object1{border-radius: 3px;}
        .img{max-width: 69%;}
        .img img{max-width: 100%;}

        .menu{float: right; width: 100%;align-items: flex-end; display: flex; flex-direction: row;justify-content: space-between;margin-bottom: 3px;}
        .mui-icon-extra-heart:before {float: right;font-size: 17px;}
        .mui-icon-trash:before{font-size: 16px;float: left;}
        .mui-icon-extra-heart{font-size: 19px;}
        .menu .points{font-size: 14px;margin:1px;position: inherit; top: -3px;}
   
        .menu button{float:right;border:0;padding: 0px 5px;color:#555;}
        .menu .time{color:#555; font-size: 14px;}

        .comment{font-size: 13px; width: 80%;}
        .comment_content {color: #8f8f94;white-space: normal}
        .comment_block{position: absolute; bottom: 0; left: 0; z-index: 2; background: white; padding: 5px 1px;width: 100%;display: none;box-shadow: 0px 1px 12px #999;}
        .mui-input-row label{width: 20%;text-align: right;font-size: 15px}
        .mui-input-row label~input{width: 65%;font-size: 15px}
        .mui-input-row button{width: 14%;float: right;line-height:1.1;padding:11px 0;border:0;font-size: 15px}
        .mui-input-row .mui-icon-clear{width: 23px;right: 12%;}
        .release {
            width: 45px;
            border: 1px solid #2aa1da;
            margin: 0 auto;
            text-align: center;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            line-height: 45px;
            color: #fff;
            border-radius: 50%;
            background-color: #2aa1da;
            box-shadow: 0px 0px 12px #999;
            background: linear-gradient(to top right, #4d91b1 0%, #48b4e8 25%, #1376a5 100%);
        }
        .release button{border:0;width: 80%;}
        .release_block{
            display: none;
        }
        .release_box {
            width: 100%;
            position: absolute;
            bottom: 0px;
            padding:10px 20px 20px;
            display: flex;
            flex-direction: column;
            align-self: center;
            background: #fff;
            border-radius: 5px;
            z-index: 105;
        }
        .LUploader{
            height: 135px;
        }
        .LUploader .LUploader-list {
            height: 100%;padding: 0px;margin:0px;
        }
        .release_block button{width: 15%;padding: 3px 0px 2px;}
        .btn_block{ margin-bottom: 10px;}
    </style>
</head>

<body>
    <div class="mui-content">
        <div class="release" onclick="release()">
            
            <span class="mui-icon mui-icon-compose"></span>
        </div>
        <div class="mui-scroll-wrapper" id="refreshId" style="touch-action: none">
            <div class="mui-scroll">
                
                <ul class="mui-table-view"></ul>
            </div>
        </div>
    </div>


    <!-- 留言 -->
    <div class="mui-input-row comment_block">
        <label>留言</label>
        <button type="button" name="sendBtn" onclick="sendMsg()">发送</button>
        <input type="text" name="sendMsg" placeholder="请输入留言内容">
    </div>

    <!-- 发布卡圈 -->
    <div class="release_block mui-backdrop" >
        <div  class="release_box" style="">
            <div class="btn_block">
                <button type="button" onclick="cancelRelease()">取消</button>
                <button type="button" style="float: right;color:#3ba5d8;border: 1px solid #3ba5d8; " onclick="sendRelease()">发布</button>
            </div>
            <textarea id="release_content" style="margin:10px auto;" autofocus="autofocus" maxlength="50" placeholder="这一刻你对卡的想法"></textarea>
            <div class="LUploader" id="up_img" >
                <div class="LUploader-container">
                    <input data-LUploader="up_img" data-form-file='basestr' data-upload-type='front' type="file" />
                    <ul class="LUploader-list"></ul>
                </div>
                <div style="background-image: url('<?php echo $pay_img['img']; ?>');background-repeat: no-repeat;background-size: contain; background-position: center;">
                    <div class="icon icon-camera font20"></div>
                    <p>图片上传</p>
                </div>
            </div>
            
        </div>
    </div>

<script src="<?php echo STATIC_URL;?>LUploader/js/LUploader.js?r=324433343445"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="http://cdn.staticfile.org/webuploader/0.1.0/webuploader.js"></script>
<script src="<?php echo STATIC_URL;?>/js/exif.js"></script> -->
<script type="text/javascript">
    mui.init({
        pullRefresh:{
            container:"#refreshId",
            down:{
                callback:downRefresh,
            },
            up:{
                auto:true,
                contentrefresh:"正在加载……",
                callback:upRefresh,
            }
        }
    });
    var page = 1;
    function downRefresh(){
        var strHtml = '';
        var data = {type:'page',page:1};
        mui.post("./find_circle.php",data,function(result){
            console.log(result);
            if(!result.error && result.data.list.length > 0){
                $.each(result.data.list,function(key,value){
                    strHtml += dataFunc(value,result.data.comment_list,result.data.userinfo,result.data.userId);
                })
                page = 2;
                $(".mui-table-view").html(strHtml);
                mui("#refreshId").pullRefresh().endPulldownToRefresh(false);
            }
            mui("#refreshId").pullRefresh().refresh(true);
        },"json");
    }
    function upRefresh(){
        var strHtml = '';
        var data = {type:"page","page":page};
        console.log(data);
        mui.post("./find_circle.php",data,function(result){
            console.log(result);
            if(!result.error && result.data.list.length > 0){
                $.each(result.data.list,function(key,value){
                    strHtml += dataFunc(value,result.data.comment_list,result.data.userinfo,result.data.userId);
                })
                page++;
                $(".mui-table-view").append(strHtml);
                mui("#refreshId").pullRefresh().endPullupToRefresh(false);
            }else{
                mui("#refreshId").pullRefresh().endPullupToRefresh(true);
            }
        },"json");
    }
    function dataFunc(data,comment,userinfo,userId=null){
        
        var str = "";
        // str += '<li class="mui-table-view-cell mui-media" ><a href="javascript:;">';
        str += '<li class="mui-table-view-cell mui-media" id="li_'+data['id']+'"><div >';
            str += '<img class="mui-media-object mui-pull-left" ';
            if(userinfo[data['uid']] && userinfo[data['uid']]['avatar']){
                str += ' src="'+userinfo[data['uid']]['avatar']+'">';
            }else{
                str += ' src="<?php echo STATIC_URL;?>images/1.jpg">';
            }
            str += '<div class="mui-media-body" id="content_'+data['id']+'">';
            if(userinfo[data['uid']] && userinfo[data['uid']]["name"] != null){
                str += userinfo[data['uid']]['name'];
            }else{
                str += "匿名";
            }
                str += '<p class="mui-ellipsis">'+data['content']+'</p>';
                str += '<div class="image_block">';
                    str += '<div class="img">';
                    if(data['img'] && data['img'] != 'undefined'){
                        str += '<img class="mui-media-object1" src="'+data['img']+'" />';
                    }
                    str += '</div>';
                    str += ' ';
                    str += '<div class="menu">';
                    str += '<div><span class="time">'+getTime(data['createtime'])+'</span></div>';
                    str += '<div><button type="button" onclick="comment('+data['id']+')">留言</button><button id="heart_'+data['id']+'" onclick="gitHeart('+data['id']+')" class="mui-icon-extra mui-icon-extra-heart"><span class="points">'+data['heart']+'</span></button>';
                    if(data['uid'] == userId){
                        str += '<button type="button" class="mui-icon mui-icon-trash" style="color:#999" onclick="deleteSet('+data['id']+')" ></button></div>';
                    }
                    str +='</div>';
                str += '</div>';

                if(comment){
                    $.each(comment[data['id']],function(key,val){
                        str += '<div class="comment">';
                        if(userinfo[val['uid']] && userinfo[val['uid']]['name']){
                            str += '<span style="color:#666;">'+userinfo[val['uid']]['name']+'：</span>';
                        }else{
                            str += '<span>匿名：</span>';
                        }
                        str += '<span class="comment_content">'+val['content']+'</span></div>';
                    })
                }
            str += '</div>';
        str += '</div></li>';
        // str += '</a></li>';
        return str; 
    }

    function release(){
        console.log("release");
        var data = {type:"check"};
        mui.post("./find_circle.php",data,function(result){
        	console.log(result);
        	if(result.error){
        		mui.toast("请先登录");
        		setTimeout(function(){
        			window.location.href = result.data.url;
        		},1000);
        		return false;
        	}else{
        		$(".release_block").css("display","block");
        	}
        },"json");
    }

    function sendRelease(){
        var content = $("#release_content").val();
        var img = $("input[name='up_img']").val();
        if(!content){
            mui.toast("请输入内容");
            return false;
        }
        var data = {type:"release",content:content,img:img};
        // console.log(data);
        // return false;
        mui.post("./find_circle.php",data,function(result){
            console.log(result);
            if(result.error){
                mui.toast("发布失败");
            }else{
                $(".release_block").css("display","none");
                mui.toast("发布成功");
                setTimeout(function(){
                    window.location.reload(true);
                },1000);
            }
        },"json");
    }

    function cancelRelease(){
    	$(".release_block").css("display","none");
    }
    // 删除帖子
    function deleteSet(id){
        var data = {id:id,type:"delete"};
        mui.post("./find_circle.php",data,function(result){
            console.log(result);
            if(!result.error){
                var child = document.getElementById("li_"+id);
                child.parentNode.removeChild(child);
                mui.toast("删除成功");
            }else{
                if(result.hasOwnProperty("data") && result.data.hasOwnProperty("url") ){
                    mui.toast("请先登录");
                    setTimeout(function(){
                        window.location.href = result.data.url;
                    },1000);
                }else{
                    mui.toast("删除失败");
                }
            }
        },"json");
    }

    var sendContent = [];
    function comment(id){
    	var data = {type:"check"};
    	mui.post("find_circle.php",data,function(result){
    		console.log(result);
    		if(result.error){
    			mui.toast("请先登录");
    			setTimeout(function(){
    				window.location.href = result.data.url;
    			},1000);
    			return false;
    		}else{
    		    $(".comment_block").show();
    		    $("[name=sendBtn]").attr("val",id);
    		    $("[name=sendMsg]").val("");
    		}
    	},"json");
    }
    function sendMsg(){
        var id = $("[name=sendBtn]").attr("val");
        var content = $("[name=sendMsg]").val();
        if(!content){
            mui.toast("请输入内容在发送");
            return false;
        }
        // sendContent[id] = content;
        var data = {type:"comment",id:id,content:content};
        mui.post("./find_circle.php",data,function(result){
            console.log(result);
            if(result.error){
                mui.toast("留言失败");
            }else{
                // $(".comment_block").hide();
                var str_content = '<div class="comment"><span>'+result.data.userinfo.name+'：</span><span class="comment_content">'+content+'</span></div>';
                $("#content_"+id).append(str_content);
                mui.toast("留言成功");
                // sendContent[id] = "";
                $(".comment_block").hide();
            }
        },"json");
    }

    var clickHeart = [];
    var option = "add";
    function gitHeart(id){
        var heart = $("#heart_"+id+ " span ").html();
        if(clickHeart[id] == null || clickHeart[id]){
            clickHeart[id] = false;
            heart++;
            option = "add";
        }else{
            clickHeart[id] = true;
            heart--;
            option = "cancel";
        }
        $("#heart_"+id+ " span ").html(heart);
        var data = {type:"heart",id:id,option:option};
        mui.post("./find_circle.php",data,function(result){
            if(result.error){
                mui.toast("支持失败");
            }else{
                mui.toast(result.msg);
            }
        },"json");
    }
              
    [].slice.call(document.querySelectorAll('input[data-LUploader]')).forEach(function(el) {
        new LUploader(el, {
            url: './upload.php',//post请求地址
            multiple: false,//是否一次上传多个文件 默认false
            maxsize: 102400,//忽略压缩操作的文件体积上限 默认100kb
            accept: 'image/*',//可上传的图片类型
            quality: 0.5,//压缩比 默认0.1  范围0.1-1.0 越小压缩率越大
            //showsize:true//是否显示原始文件大小 默认false
        });
    });

    function getTime(time){
        var time = new Date(time*1000);
        var now = new Date();
        var y = time.getFullYear();
        var m = time.getMonth();
        var d = time.getDate();
        var h = time.getHours();
        var i = time.getMinutes();
        var s = time.getSeconds();
        if(y != now.getFullYear()){
            return y+'年'+m+'月'+d+'日';
        }else if(d != now.getDate()){
            return m+'月'+d+'日';
        }else{
            return h+":"+i;
        }
    }

    $(document).ready(function(){
        $(window).scroll(function(){
             $(".comment_block").hide();;
        }) 
    })
</script>
</body>
</html>