<?php
/*
import('HtmlForm');
$html = new HtmlForm(url('user:config:test',[],1));
$radio = [['val'=>1,'title'=>'男','checked'=>'checked'],['val'=>2,'title'=>'女','checked'=>'']];
$option = [['val'=>1,'name'=>'北京'],['val'=>2,'name'=>'上海']];
$checkbox = [['val'=>1,'title'=>'北京','checked'=>'checked'],['val'=>2,'title'=>'天津','checked'=>'']];
return $html->input(['name','卡名'],['name',['reg','pass']])
			->select(['city','城市'],$option)
			->checkbox(['clas','考点'],$checkbox)
			->textarea(['describe','商品描述'])
			->radio(['sex','性别'],$radio)
			->upload('log图片','img_id','img_name')
			->resSuccess('http://lk.com/wap/index.php?card=offset')
			->addFrom();
*/
class HtmlForm
{
    public $htmlall = '';
    public $checkbox = array();
    public $path = array();
    public $required = array();
    public $resSucce = '';
    public $btnId = '';
    public $radio = '';

    public function __construct($btnId = '',$path = false)
    {
        $this->path = $path;
        $this->btnId = $btnId;

    }

    /*
    *input输入框
    *$data [1,2,3,] 1:标签,2:name 值，3:type 值, 4 value值
    *$required[1,2] 1:验证标签, 2[1,2]:1:(reg=>正则,max=>大于,'min'=>'小于') 2:(验证方式如手号码验证 phone)
    */
    public function input($data, $required = false)
    {
        if($required[0] != 'required'){
            $this->required[$required[0]] = $required[1];
            $this->required[$required[0]]['is_reg'] = 1;
        }
        $type = isset($data[2])?$data[2]:'text';
        $str = '<div class="layui-form-item '.$data[0].'radio"><label class="layui-form-label" id="label-form">'.$data[1].'</label><div class="layui-input-block" id="input-bloc"><input type="'.$type.'" name="'.$data[0].'" value="'.$data[3].'"  lay-verify="'.$required[0].'" placeholder="请输入'.$data[1].'" autocomplete="off" class="layui-input" id="laui-input"></div></div>';
        $this->htmlall.=$str;
        return $this;
    }
    //文件上传
    public function upload($title,$id,$name)
    {
        $str = <<<EOM
        <div class="layui-form-item">
            <label class="layui-form-label" id="label-form">{$title}</label>
            <div class="layui-input-block" id="input-bloc" style="height:80px;display:flex;justify-content:space-between">
              <div>
                <a herf="javascript:;" class="layui-btn" id="{$id}" style="height:80px;line-height:80px;width:80px;">
                <i class="layui-icon" style="font-size:30px;">&#xe681;</i> </a>
              </div>
              <input type="hidden" name="{$name}" class="{$id}hid">
              <div style="width:50%;"><img src="http://lk.com/upload/images/000/000/001/201806/5b2c98275e959.jpg" style="width:80px;height:80px;" class="{$id}img"></div>
           
            </div>
        </div>
        <script>
        layui.use('upload', function(){
          var upload = layui.upload;
           
          //执行实例
          var uploadInst = upload.render({
            elem: '#{$id}',
            url: '../user.php?c=config&a=uploadFile',
            done: function(res){
                if(res.error == 0){
                    var url = $('.{$id}hid').val();
                    console.log(url);
                    url && $.post('../user.php?c=config&a=delFile', {url: url},function(){});
                    $('.{$id}hid').val(res.msg);
                    $(".{$id}img").attr('src',res.msg); 
                    layer.closeAll('loading');
                }
              console.log(res.msg);
            },
            error: function(){
              //请求异常回调
            }
          });
        });
        </script>
EOM;
$this->htmlall.=$str;
        return $this;

    }
    /*
	    $data [1,2] 1:标签，2:name值
	    $option[[1,2][]] 1:value值 2:text标
    */
    public function select($data,$option)
    {
        $op = '';
        foreach ($option as $k => $v) {
           $op .= '<option value="'.$v['val'].'">'.$v['name'].'</option>';
        }
        $str = <<<EOM
        <div class="layui-form-item">
            <label class="layui-form-label" id="label-form">{$data[1]}</label>
            <div class="layui-input-block" id="input-bloc">
            <select name="{$data[0]}" lay-verify="required" >
                {$op}
            </select>
            </div>
        </div>
EOM;
$this->htmlall.=$str;
        return $this;

    }
    //复选框
    public function checkbox($data,$checkbox)
    {
        $cx = '';
        foreach ($checkbox as $k => $v) {
           $cx .= '<input type="checkbox" value="'.$v['val'].'" name="'.$data[0].'" title="'.$v['title'].'" '.$v['checked'].'>';
        }
        $this->checkbox[] = $data[0];
        $str = <<<EOM
        <div class="layui-form-item">
            <label class="layui-form-label" id="label-form">{$data[1]}</label>
            <div class="layui-input-block" id="input-bloc">
              {$cx}
            </div>
        </div>
EOM;
$this->htmlall.=$str;
        return $this;    
    }

    //单选
    public function radio($data,$radio,$display = false)
    {
        $str = '<div class="layui-form-item"><label class="layui-form-label" style="width:40px" id="label-form">'.$data[1].'</label><div class="layui-input-block" id="input-bloc">';
        foreach ($radio as $k => $v) {
            $str .= '<input type="radio" lay-filter="'.$data[0].'" name="'.$data[0].'" value="'.$v['val'].'" title="'.$v['title'].'" '.$v['checked'].'>';
        }
        $str.='</div></div>';
        if($display){
            $this->radio =<<<EOS
            form.on('radio({$data[0]})', function (data) {
                if(data.value == '1'){
                    $('.{$display}radio').hide();
                    //$("input[name='{$display}']").attr("disabled",true);
                }else{
                    $('.{$display}radio').show();
                    //$("input[name='{$display}']").attr("disabled",false);
                }
                console.log(data);
            });
EOS;
        $this->required[$data[0]]['is_reg']  = 0;
             
        }
        $this->htmlall.=$str;
        return $this;
    }

    //文本域
    public function textarea($name)
    {
        $str = <<<EOM
        <div class="layui-form-item layui-form-text">
        <label class="layui-form-label" id="label-form">{$name[1]}</label>
        <div class="layui-input-block" id="input-bloc">
          <textarea name="{$name[0]}" placeholder="请输入{$name[1]}" class="layui-textarea"></textarea>
        </div>
      </div>
EOM;
$this->htmlall.=$str;
        return $this;
    }


	public function reg($key)
	{
		$reg = array(
            "passRegex"=>['/(.+){6,12}$/','密码必须6到12位'],                                                                                     //密码必须6到12位
            "floaRegex"=>['/(^[1-9]\d*(\.\d{1,2})?$)|(^0(\.\d{1,2})?$)/','请输入两位小数的数'],                                                                                       //密码必须6到12位
			"intRegex"=>['/^[0-9]*[1-9][0-9]*$/','请输入正整数的数'],																						//密码必须6到12位
			"phoneRegex"=>['^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0-9])|(17([3|5]|[6-8])))\\d{8}$','手机格式不对'],						//手机验证正则
			"emailRegex"=>['^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$','邮箱格式不对'],								//邮箱验证
			"idcardRegex"=>['/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/','身份证号格式不对'],//身份证验证
			"urlRegex"=>['/^((https?|ftp|file):\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/','URL身份证号格式不对'],						//URL验证
			"qqRegex"=>['/^[1-9][0-9]{4,10}$/','QQ号格式不对'],																				//QQ验证，最多11位
			"cnRegex"=>['/[\u4E00-\u9FA5]/','必须包含中文'],																					//包含中文验证
			"userRegex"=>['/^[a-zA-Z0-9_-]{4,16}$/','必须是字母，数字，下划线，减号'],																//用户名验证，4到16位（字母，数字，下划线，减号）
			"passwordRegex"=>['/^.*(?=.{6,})(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*? ]).*$/','密码强度不够'],					//密码强度验证
		);
		$regex = '';
		foreach ($reg as $k => $v) {
			if($k == ($key.'Regex')){
				$regex =  $v;
			}
		}
		return $regex;
	}

	public function resSuccess($res)
	{
		$this->resSucce = "window.location.href='{$res}';";
		return $this;
	}

/*nikename: function(value){ if(value.length < 5){ }}  
*/
    public function addFrom()
    {
        $checkbox = '';
        if($this->checkbox){
            foreach ($this->checkbox as $k => $v) {
               $checkbox .= 'data.field.'.$v.'= checkbox_val("'.$v.'");';
            }
        }
        $required = '';
        if($this->required){
            foreach ($this->required as $kk => $vv) {
            	switch ($vv[0]) {
            		case 'reg':
            			$a = $this->reg($vv[1]);
						$required .= $kk.": [{$a[0]}, '{$a[1]}'],";
            			break;
            		case 'max':
            			 $required .= $kk.": function(value){if(value.length > ".$vv[1]."){layer.msg('".$vv[2]."', {icon: 5,time:2000}) ; }},";
            			break;
            		case 'min':
            			 $required .= $kk.": function(value){if(value.length < ".$vv[1]."){layer.msg('".$vv[2]."', {icon: 5,time:2000}) ; }},";
            			break;
            		default:
            			# code...
            			break;
            	}        
            }
        }

         $str = <<<EOM
			    <script type="text/javascript">
			        layui.use(['form', 'layer'],function() {
			            $ = layui.jquery;
			            var form = layui.form,
			            layer = layui.layer;
			            form.verify({
			                {$required}
			            });

			            form.on('submit({$this->btnId})',function(data) {
			                //layer.msg(JSON.stringify(data.field.checkbox));
			                {$checkbox}
			                data.field.file == '' && delete data.field.file;
			                // console.log(data.field['file']);
			                console.log(data.field);
			                $.post('{$this->path}',data.field,function(re){
			                    if(re.error == 0){
			                        layer.msg(re.msg, {icon: 6,time:2000},function () {
			                        	{$this->resSucce}
			                        });
			                    }else{
			                        layer.msg('ok', {icon: 6,time:2000});
			                    }

			                },'json');
			                return false;
			            });
                        $this->radio
                         /*form.on('radio(is_free)', function (data) {
                             console.log(data);
                        });*/
			        });
			        function checkbox_val(name){
			            var standards = "";
			            $("input:checkbox[name="+name+"]:checked").each(function() {
			                     standards += "," + $(this).val();
			            });
			            return standards; 
			        }
			    </script>
EOM;
return $this->htmlall .=$str;
    }
}

