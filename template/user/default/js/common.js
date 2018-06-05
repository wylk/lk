
$(function(){
	if($('#myform').length>0){
		if(document.getElementById('choose_map')){
			$('#choose_map').html('<input type="text" class="input fl" name="long_lat" id="long_lat" size="20" placeholder="经度,纬度" value="'+(typeof($('#choose_map').attr('default_long_lat'))!='undefined' ? $('#choose_map').attr('default_long_lat') : '')+'" validate="required:true" readonly="readonly"/><a href="javascript:void(0);" style="margin-left:10px;" id="show_map_frame">点击选取经纬度</a>');
			$('#show_map_frame').click(function(){
				window.top.change_frame_position_left('store_add');
				window.top.artiframe(choose_map+'&long_lat='+$('#long_lat').val(),"地图选点",655,520,true,false,false,false,"choose_map",true,function(){window.top.art.dialog.list["store_add"].position("50%","38.2%");},window.top.get_frame_position_left("store_add",655));
			});
		}
		
		//检测是否需要显示城市
		if(document.getElementById('choose_cityarea')){
			show_province();
		}
		/* 检测密码强度 */
		var check_pwd = $('#myform #check_pwd');
		if(typeof(check_pwd.val()) != 'undefined'){
			var check_width = check_pwd.attr('check_width');
			if(!check_width) check_width=200;
			if(!check_pwd.attr('no_check_tips')){
				var no_check_tips = true;
			}else{
				var no_check_tips = false;
			}
			var check_tr = '<tr id="check_tr"><th>密码强度</th><td><table width="'+check_width+'" border="0" cellspacing="0" cellpadding="1" style="display:inline-block;_display:inline;"><tbody><tr class="noboder" align="center" style="background:none; border:none;"><td width="33%" id="pwd_lower" style="border-bottom:2px solid #DADADA">弱</td><td width="33%" id="pwd_middle" style="border-bottom:2px solid #DADADA">一般</td><td width="33%" id="pwd_high" style="border-bottom:2px solid #DADADA">强</td></tr></tbody></table>'+( no_check_tips ? '<img src="'+static_path+'images/help.gif" class="tips_img" title="密码强度建议至少为一般！（字母*2）（数字*2）（特殊字符*2），满足任意两项为一般，满足三项为强"/>' : '')+'</td></tr>';
			var check_event = check_pwd.attr('check_event');
			if(!check_event){
				check_pwd.closest('tr').after(check_tr);
			}else{
				check_pwd.bind(check_event,function(){
					if(!document.getElementById('check_tr')){
						check_pwd.closest('tr').after(check_tr);
					}
					if(check_event == 'keyup'){
						if(check_pwd.val().length == 0){
							$('#check_tr').remove();
						}
					}
				});
			}
			check_pwd.keyup(function(){
				var pwd = $(this).val();
				var Mcolor = "#FFF",Lcolor = "#FFF",Hcolor = "#FFF";
				var m=0;
				if(pwd.length >= 6){
					if(/[a-zA-Z]+/.test(pwd) && /[0-9]+/.test(pwd) && /\W+\D+/.test(pwd)) {
						m = 3;
					}else if(/[a-zA-Z]+/.test(pwd) || /[0-9]+/.test(pwd) || /\W+\D+/.test(pwd)) {
						if(/[a-zA-Z]+/.test(pwd) && /[0-9]+/.test(pwd)) {
							m = 2;
						}else if(/[a-zA-Z]+/.test(pwd) && /\W+\D+/.test(pwd)){
							m = 2;
						}else if(/[0-9]+/.test(pwd) && /\W+\D+/.test(pwd)) {
							m = 2;
						}else{
							m = 1;
						}
					}
				}else if(pwd.length == 0){
					m = 0;
				}else{
					m = 1;
				}
				switch(m){
					case 1 :
						Lcolor = "2px solid red";
						Mcolor = Hcolor = "2px solid #DADADA";
						break;
					case 2 :
						Mcolor = "2px solid #f90";
						Lcolor = Hcolor = "2px solid #DADADA";
						break;
					case 3 :
						Hcolor = "2px solid #3c0";
						Lcolor = Mcolor = "2px solid #DADADA";
						break;
					case 4 :
						Hcolor = "2px solid #3c0";
						Lcolor = Mcolor = "2px solid #DADADA";
						break;
					default :
						Hcolor = Mcolor = Lcolor = "";
						break;
				}
				if (document.getElementById("pwd_lower")){
					document.getElementById("pwd_lower").style.borderBottom  = Lcolor;
					document.getElementById("pwd_middle").style.borderBottom = Mcolor;
					document.getElementById("pwd_high").style.borderBottom   = Hcolor;
				}
			});
		}
		if(frame_show){
			$.each($('#myform td'),function(i,item){
				$(item).find("input[type='file']").closest('tr').remove();
				if(typeof($(item).find("input[type='text']").val()) != 'undefined'){
					if($(item).find("input[type='text']").val().length == 0){
						$(item).html('<div class="show">空</div>');
					}else{
						$(item).html('<div class="show">'+$(item).find("input[type='text']").val()+'</div>');
					}
				}else if(typeof($(item).find("input[type='password']").val()) != 'undefined'){
					$(item).html('<div class="show">密码项不能查看</div>');
				}else if(typeof($(item).find("input[type='radio']:checked").val()) != 'undefined'){
					$(item).html('<div class="show">'+$(item).find("input[type='radio']:checked").parent().text()+'</div>');
				}else if(typeof($(item).find("select").val()) != 'undefined'){
					$(item).html('<div class="show">'+$(item).find("select option:selected").text()+'</div>');
				}
			});
		}else{
			$.each($('#myform').find("input,select,textarea").not(":submit,:reset,:image,[disabled]"),function(i,item){
				if($(item).attr('tips')){
					$(item).after('<img src="https://mall.epaikj.com//source/tp/Project/tpl/Static/images/help.gif" class="tips_img" title="'+$(item).attr('tips')+'"/>');
				}
				var validate = $(item).attr('validate');
				if(validate){
					varlidate_arr = validate.split(',');
					for(var i in varlidate_arr){
						if(varlidate_arr[i] == 'required:true'){
							if($(item).attr('id')){
								var em_for = $(item).attr('id');
							}else{
								var em_for = $(item).attr('name');
							}
							if($(item).val() == ''){
								$(item).parent().append('<em for="'+em_for+'" generated="true" class="error tips">必填项</em>');
							}else{
								$(item).parent().append('<em for="'+em_for+'" generated="true" class="error success"></em>');
							}
							break;
						}
					}
				}
			});
			$.each($('#myform .notice_tips'),function(i,item){
				$(this).replaceWith('<img src="https://mall.epaikj.com//source/tp/Project/tpl/Static/images/help.gif" class="tips_img" title="'+$(this).attr('tips')+'" style="margin-top:1px;"/>');
			});

			$("#myform").validate({
				event:"blur",
				errorElement: "em",
				errorPlacement: function(error,element){
					error.appendTo(element.parent("td"));
				},
				success: function(label){
					label.addClass("success");
				},
				submitHandler:function(form){
					if($('.ke-container').size() > 0){
						kind_editor.sync();
					}
					if($(form).attr('frame') == 'true' || $(form).attr('refresh') == 'true'){
						$.post($(form).attr('action'),$(form).serialize(),function(result){
							if(result.status == 1){
								window.top.msg(1,result.info,true);
								if($(form).attr('refresh') == 'true'){
									window.top.main_refresh();
								}
								window.top.closeiframe();
							}else{
								window.top.msg(0,result.info,true);
							}
						});
						return false;
					}else{
						window.top.msg(2,'表单提交中，请稍等...',true,360);
						form.submit();
					}
				} 
			});
		}
	}
	$('td .tips_img').mouseover(function(e){
		var now    = $(this);
		var offset = $(this).offset();
		var parent = $(this).closest('td');

		var height = parent.height()/2-8;

		now.data('tips',now.attr('title')).attr('title','');
		parent.append('<div class="tooltipdi" style="position:absolute;left:'+(offset.left-217)+'px;top:'+ height +'px"><span><b></b><em></em>'+now.data('tips')+'</span></div>');
		var tips_div = parent.find('.tooltipdi');
		parent.one('mouseout',function(){
					now.attr('title',now.data('tips'));
					tips_div.remove();
			
		});
	});
	//开关
	$('.cb-enable').click(function(){
		$(this).find('label').addClass('selected');
		$(this).find('label').find('input').prop('checked',true);
		$(this).next('.cb-disable').find('label').find('input').prop('checked',false);
		$(this).next('.cb-disable').find('label').removeClass('selected');	
	});
	$('.cb-disable').click(function(){	
		$(this).find('label').addClass('selected');
		$(this).find('label').find('input').prop('checked',true);
		$(this).prev('.cb-enable').find('label').find('input').prop('checked',false);
		$(this).prev('.cb-enable').find('label').removeClass('selected');
	});
	//预览大图
	$('.view_msg').click(function(){
		window.top.art.dialog({
			padding: 0,
			title: '大图',
			content: '<img src="'+$(this).attr('src')+'"/>',
			lock: true
		});
	});
	
	$('#choose_color_box').click(function(){
		window.top.showTopColorPanel('Openadd',$(this).offset().top,$(this).height(),$(this).offset().left,'choose_color')
	});

});