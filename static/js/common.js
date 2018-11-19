var lk = {
	up_img:function(inputfile,up_path,backfunc,dataType){
		var data = new FormData();
        $.each(inputfile[0].files, function(i, file) {
            data.append('file', file);
        });
        $.ajax({
            url:up_path,
            type:'POST',
            data:data,
            dataType:dataType,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            success:backfunc
        });
	},
    checkbox_val:function(name){
        var standards = "";
        $("input:checkbox[name="+name+"]:checked").each(function() {
            standards += "," + $(this).val();
        });
        return standards;
    },
    is_weixin:function(){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            return true;
        }else{
            return false;
        }
    },
    tusi:function (txt, fun) {
        $('.tusi').remove();
        //var div = $('<div class="tusi" style="background: url(/template/index/default/images/tusi.png);max-width: 85%;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
        var div = $('<div class="tusi" style="background: #5A5B5C;padding:0px 20px;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
        $('body').append(div);
        div.css('zIndex', 9999999);
        div.css('left', parseInt(($(window).width() - div.width()) / 2));
        var top = parseInt($(window).scrollTop() + ($(window).height() - div.height()) / 2);
        div.css('top', top);
        setTimeout(function () {
            div.remove();
            if (fun) {
                eval("(" + fun + "())");
            }
        }, 1500);
    }
}

