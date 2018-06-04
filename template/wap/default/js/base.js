var motify = {
	timer:null,
	log:function(msg){
		$('.motify').hide();
		if(motify.timer) clearTimeout(motify.timer);
		if($('.motify').size() > 0){
			$('.motify').show().find('.motify-inner').html(msg);
		}else{
			$('body').append('<div class="motify" style="display:block"><div class="motify-inner">'+msg+'</div></div>');
		}
		motify.timer = setTimeout(function(){
			$('.motify').hide();
		},3000);
	},
	checkMobile:function(){
		if(/(iphone|ipad|ipod|android|windows phone)/.test(navigator.userAgent.toLowerCase())){
			return true;
		}else{
			return false;
		}
	},
};

/*var motify1 = {
    ewm:function(msg){
        var  height = $(window).height();
        var width = $(window).width();
        $('body').append('<div class="motify" style="display:block;position:fixed;top:0px;left:0px;margin:0 0 0 0;height:'+height+'px;width:100%"><p id="del"style="position:fixed;top:42px;left:'+(width-15)+'px;">X</p><div style="margin-top:40px;background:#fff;width:'+width+'px;height:'+(width+100)+'px;"><img src="my_memcard.php?action=wx_ewm&id='+msg+'" style="width:'+width+'px;height:'+width+'px;"/><p style="padding-left:10px;">请长按二维码,识别二维码,打开完成支付</p></div></div>');
        $('#del').click(function(){
            $('.motify').hide();
        })
    }
};*/
var motify1 = {
	ewm:function(msg){
		var  height = $(window).height();
		var width = $(window).width();
		$('body').append('<div class="motify" style="display:block;background:#f6bc00;position:fixed;top:0;left:0;margin:0;height:100%;width:100%;border-radius:0;"><p id="del">X</p><div class="qrpic"><img src="my_memcard.php?action=wx_ewm&id='+msg+'"/><p class="qrtext"><em class="l_cricle"></em><em class="r_cricle"></em>请长按二维码,识别二维码,打开完成支付</p></div></div>');
		$('#del').click(function(){
			$('.motify').hide();
		})
	}
};

/*计算JSON对象长度*/
function getJsonObjLength(obj){
	var l = 0;
	for (var i in obj){
		l++;
	}
	return l;
}

$(function(){


	if(motify.checkMobile() === false && $('.headerbar').size() == 0){
		$('html').removeClass('responsive-320').addClass('responsive-540 responsive-800');
	}
	if($('.js-navmenu').size() > 0){
		$('.content').css('min-height',$(window).height()-$('.container > .header').height()-$('.js-navmenu').height()-$('.js-footer').height()+'px');
		$('.js-mainmenu').click(function(e){
			e.stopPropagation();
			var submenu = $(this).next('.js-submenu:hidden');
			$(this).closest('.nav-item').siblings('.nav-item').find('.js-submenu').hide();
			if(submenu.size() > 0){
				submenu.show();
				var subleft = $(this).offset().left+(($(this).width()-submenu.width())/2)-7;
				var arrowleft = (submenu.width()+6)/2;
				submenu.css({'opacity':1,'left':(subleft > 5 ? subleft : 5) + 'px','right':'auto'}).find('.before-arrow,.after-arrow').css({'left':arrowleft+'px'});
			} else {
				$(this).next('.js-submenu').hide();
			}
		});

		$('body').click(function(e){
			$('.js-navmenu .js-submenu').hide();
		});
	}else{
		$('.content').css('min-height',$(window).height()-$('.container > .header').height()-$('.js-footer').height()-($('.js-bottom-opts').size() ? '40' : '0')+'px');
	}
	if(typeof(noCart) == 'undefined'){
		$.post('./saveorder.php?action=cart_count',function(result){
			if(result.err_code == 0 && result.err_msg.count != '0'){
				$('body').append('<div id="right-icon" class="js-right-icon icon-hide no-border" data-count="'+result.err_msg.count+'"><div class="right-icon-container clearfix"><a id="global-cart" href="./cart.php?id='+result.err_msg.store_id+'" class="no-text new showcart"><p class="right-icon-img"></p><p class="right-icon-txt">购物车</p></a></div></div>');
			}
		});
	}
	//检测滚动公告
	if($('.js-scroll-notice').size() > 0){
		$.each($('.js-scroll-notice'),function(i,item){
			var nowDom = $(item);
			var nowWidth = nowDom.width();
			var fWidth = $(item).closest('.custom-notice-inner').width();
			if(nowWidth > fWidth){
				nowDom.css('position','relative');
				var nowLeft = 0;
				window.setInterval(function(){
					if(nowLeft+nowWidth<0){
						nowLeft = fWidth;
					}else{
						nowLeft = nowLeft-1;
					}
					nowDom.css('left',nowLeft + 'px');
				},30);
			}
		});
	}
	//检测图片广告
	if($('.custom-image-swiper').size()){
		$.each($('.custom-image-swiper'),function(i,item){//&& $(item).data('max-width')>$('.content').width()
			if($(item).data('max-height') && $(item).data('max-width') ){
				var img_height = $(item).data('max-height') * $('.content').width() / $(item).data('max-width');
				$(item).find('.swiper-container').height(img_height);
				$(item).find('.swiper-slide').height(img_height);
				$(item).find('.swiper-slide a').height(img_height);
			}

			if ($(item).find(".swiper-slide").size() == 1) {
				return;
			}
			try {
				$(item).find('.swiper-container').swiper({
					pagination:'.swiper-pagination',
					loop:true,
					grabCursor: true,
					paginationClickable: true,
					autoplay:3000,
					autoplayDisableOnInteraction:false
				});
			} catch (e) {

			}
		});
	}
	//检测图片轮播图
	if($('.js-goods-list.waterfall').size() > 0){
		if($('.content').width() >= 540){
			var li_width = ($('.content').width()-10)/3;
		}else{
			var li_width = ($('.content').width()-10)/2;
		}
		$('.js-goods-list.waterfall').each(function(i) {
			$(this).children('.goods-card').width(li_width);
			$(this).waterfall({
				column_index:i,
				column_className:'waterfall_column-' + i,
				column_width:li_width,
				column_space:0,
				cell_selector:'.goods-card',
			});
		})

		/*$('.js-goods-list.waterfall').eq(0).waterfall({
			column_index:0,
			column_className:'waterfall_column-0',
			column_width:li_width,
			column_space:0,
			cell_selector:'.goods-card',
		});
		$('.js-goods-list.waterfall:eq(1) .goods-card').width(li_width);
		$('.js-goods-list.waterfall').eq(1).waterfall({
			column_index:1,
			column_className:'waterfall_column-1',
			column_width:li_width,
			column_space:0,
			cell_selector:'.goods-card'
		});*/
	}

	$('#pay').click(function() {
		console.log(23);
	},'json');
	$('#quckArea #quckIco2').click(function(){
		if($('#quckArea').hasClass('more_active')){
			$('#quckArea').removeClass('more_active');
		}else{
			$('#quckArea').addClass('more_active');
		}
	});
	$('#quckArea #quckMenu a').click(function(){
		$('#quckArea').removeClass('more_active');
	});

	$('.search-input').focus(function(){
		$('#J_PopSearch').show();
		$('#ks-component').show();
	});

	$('.j_CloseSearchBox').click(function(){
		$('#J_PopSearch').hide();
		$('#ks-component').hide();
	});


	$('.s-combobox-input').keyup(function(e){
		var val = $.trim($(this).val());
		if(e.keyCode == 13){
			if(val.length > 0){
				window.location.href = './category.php?keyword='+encodeURIComponent(val);
			}else{
				motify.log('请输入搜索关键词');
			}
		}
		$('.j_PopSearchClear').show();
	});

	$('.j_PopSearchClear').click(function(){
		$('.s-combobox-input').val('');
	});


/*
	if((getOs() == 'MSIE' && ieVersion() < 9) || $('.storeContact').attr('open-url') == ''){  //联系卖家
		var tel = $('.storeContact').attr('data-tel');
		$('.storeContact').html('<a href="tel:' + tel + '">2324' + tel + '</a>');
		//$('.storeContact').html('<a href="tel:' + tel + '">' + tel + '</a><a class="item-first-shop-wx chat openWindow">1联系卖家</a>');
	}else{
		var tel = $('.storeContact').attr('data-tel');
		$('.storeContact').html('<a href="tel:' + tel + '">' + tel + '</a><a class="item-first-shop-wx chat openWindow">2联系卖家</a>');
	}

    $('.openWindow').on('click',function(){
    	var is_login 	= $('.storeContact').attr('login-status');
		if(is_login==0){
			window.location.href = '/wap/login.php';
		}else {
			var url 	= $('.openWindow').parent('.storeContact').attr('open-url');
			window.location.href = url;
		}
    });
	*/
//////////////////////
	if((getOs() == 'MSIE' && ieVersion() < 9) || $('.storeContact').attr('open-url') == ''){  //联系卖家
		var tel = $('.storeContact').attr('data-tel');
		$('.storeContact').html('<a href="tel:' + tel + '">' + tel + '</a>');
	}else{
		var tel = $('.storeContact').attr('data-tel');
		var opencontact = '<div id="enter_im_div" style="-webkit-transition:opacity 200ms ease;transition:opacity 200ms ease;opacity:1;display:block;cursor:move;z-index:10000"><a id="enter_im" href="javascript:void(0)"><div id="to_user_list"><div id="to_user_list_icon_div" class="rel left"><em class="to_user_list_icon_em_a abs">&nbsp;</em> <em class="to_user_list_icon_em_b abs">&nbsp;</em> <em class="to_user_list_icon_em_c abs">&nbsp;</em> <em class="to_user_list_icon_em_d abs">&nbsp;</em> <em id="to_user_list_icon_em_num" class="hide abs">0</em></div><p id="to_user_list_txt" class="left openWindow" style="font-size:12px">联系客服</p></div></a></div>';
		$('.storeContact').html('<a href="tel:' + tel + '">' + tel + '</a>'+opencontact);
		$("#enter_im_div").show();
	}

    $('.openWindow').on('click',function(){
    	var is_login 	= $('.storeContact').attr('login-status');
		if(is_login==0){
			window.location.href = '/wap/login.php';
		}else {
			var url 	= $('.openWindow').closest('.storeContact').attr('open-url');
			window.location.href = url;
		}
    });

//////////////////////
});

function getOs()
{
    var OsObject = "";
   if(navigator.userAgent.indexOf("MSIE")>0) {
        return "MSIE";
   }
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
        return "Firefox";
   }
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) {
        return "Safari";
   }
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){
        return "Camino";
   }
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){
        return "Gecko";
   }

}


function ieVersion(){
    if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/6./i)=="6."){
        return  6;
    }
    else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/7./i)=="7."){
        return  7;
    }
    else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/8./i)=="8."){
        return  8;
    }
    else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/9./i)=="9."){
        return 9;
    }
}

/***以字符串行书输出一个OBJ**便于查看对象的值*****/
var obj2String = function(_obj) {
    var t = typeof(_obj);
    if (t != 'object' || _obj === null) {
        // simple data type
        if (t == 'string') {
            _obj = '"' + _obj + '"';
        }
        return String(_obj);
    } else {
        if (_obj instanceof Date) {
            return _obj.toLocaleString();
        }
        // recurse array or object
        var n, v, json = [],
        arr = (_obj && _obj.constructor == Array);
        for (n in _obj) {
            v = _obj[n];
            t = typeof(v);
            if (t == 'string') {
                v = '"' + v + '"';
            } else if (t == "object" && v !== null) {
                v = this.obj2String(v);
            }
            json.push((arr ? '': '"' + n + '":') + String(v));
        }
        return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
    }
};
