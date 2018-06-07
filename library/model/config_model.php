<?php
/*
	系统配置设置
 */
class config_model extends base_model
{
	public function getConfig($where)
	{
		$data = $this ->db->where($where)->order('`id` asc')->select();
		foreach($data as $key=>$value){
			$config_list[$value['tab_id']]['name'] = $value['tab_name'];
			$config_list[$value['tab_id']]['list'][] = $value;
		}
		return $this->buildHtml($config_list);
	}

	public function buildHtml($config_list)
	{
		if(is_array($config_list)){

			$config_html = '';
			foreach($config_list as $pigcms_key=>$pigcms_value){
				foreach($pigcms_value['list'] as $key=>$value){
					$tmp_type_arr = explode('&',$value['type']);
					$type_arr = array();
					foreach($tmp_type_arr as $k=>$v){
						$tmp_value = explode('=',$v);
						$type_arr[$tmp_value[0]] = $tmp_value[1];
					}

					$config_html .= '<tr>';
					$config_html .= '<th style="width: 20%;text-align: center;">'.$value['info'].'：</th>';
					$config_html .= '<td>';
					if(in_array($type_arr['type'],array('text','otext'))) {	
						$size = !empty($type_arr['size']) ? $type_arr['size'] : '60';
						if($type_arr['type'] == 'otext') {
							$config_html .= '<input type="text" class="input-text" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="'.$size.'" validate="'.$type_arr['validate'].'" />';
							$config_html .= "&nbsp;".$value['desc'];
						}else{
							$config_html .= '<input type="text" class="input-text" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="'.$size.'" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'"/>';	
						}
					}else if($type_arr['type'] == 'textarea'){
						$rows = !empty($type_arr['rows']) ? $type_arr['rows'] : '4';
						$cols = !empty($type_arr['cols']) ? $type_arr['cols'] : '80';
						$config_html .= '<textarea rows="'.$rows.'" cols="'.$cols.'" name="'.$value['name'].'" id="config_'.$value['name'].'" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'">'.$value['value'].'</textarea>';
					}else if($type_arr['type'] == 'radio'){
						$radio_option = explode('|',$type_arr['value']);
						foreach($radio_option as $radio_k=>$radio_v){
							$radio_one = explode(':',$radio_v);
							if($radio_k == 0){
								$config_html .= '<span class="cb-enable"><label class="cb-enable '.($value['value']==$radio_one[0] ? 'selected' : '').'"><span>'.$radio_one[1].'</span><input type="radio" name="'.$value['name'].'" value="'.$radio_one[0].'" '.($value['value']==$radio_one[0] ? 'checked="checked"' : '').'/></label></span>';
							}else if($radio_k == 1){
								$config_html .= '<span class="cb-disable"><label class="cb-disable '.($value['value']==$radio_one[0] ? 'selected' : '').'"><span>'.$radio_one[1].'</span><input type="radio" name="'.$value['name'].'" value="'.$radio_one[0].'" '.($value['value']==$radio_one[0] ? 'checked="checked"' : '').'/></label></span>';
							}
						}
						if($value['desc']){
							$config_html .= '<em tips="'.$value['desc'].'" class="notice_tips"></em>';
						}
					}else if($type_arr['type'] == 'image'){
						$config_html .= '<span class="config_upload_image_btn"><a href="javascript:;" value="" class="button"  style="margin-left:0px;margin-right:10px;" data-id="'.$value['name'].'">上传图片</a></span><input type="text" class="input-text input-image" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="48" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'"/> ';
					}else if($type_arr['type'] == 'file'){
						$config_html .= '<span class="config_upload_file_btn" file_validate="'.$type_arr['file'].'"><input type="button" value="上传文件" class="button" style="margin-left:0px;margin-right:10px;"/></span><input type="text" class="input-text input-file" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="48" readonly="readonly" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'"/> ';
					}else if($type_arr['type'] == 'select'){
						$radio_option = explode('|',$type_arr['value']);
						$config_html .= '<select name="'.$value['name'].'" style="width:60%;height:25px">';
						foreach($radio_option as $radio_k=>$radio_v){
							$radio_one = explode(':',$radio_v);
							$config_html .= '<option value="'.$radio_one[0].'" '.($value['value']==$radio_one[0] ? 'selected="selected"' : '').'>'.$radio_one[1].'</option>';
						}
						$config_html .= '</select>';
						if($value['desc']){
							$config_html .= '<em tips="'.$value['desc'].'" class="notice_tips"></em>';
						}
					}else if($type_arr['type'] == 'page'){
						$config_html .= '<span class="config_select_page_btn"><input type="button" value="选择微杂志" class="button" style="margin-left:0px;margin-right:10px;"/></span><input type="text" class="input-text input-widget-page" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="10" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'"/> ';
						$has_page_btn = true;
					} else if ($type_arr['type'] == 'salt') {
                        $config_html .= '<span class="config_generate_salt_btn"><input type="button" value="生成KEY" class="button generate-salt" style="margin-left:0px;margin-right:10px;"/></span><input type="text" class="input-text input-image" name="'.$value['name'].'" id="config_'.$value['name'].'" value="'.$value['value'].'" size="48" validate="'.$type_arr['validate'].'" tips="'.$value['desc'].'"/> ';
                        $has_salt_btn = true;
                    }else if($type_arr['type'] == 'button'){
                    	$config_html .= '<input type="button" onclick="window.location.href=\'/admin.php?c=User&a=ImportUser_to_ucenter\'" value="将用户导入到Ucenter" class="button" style="margin-left:0px;margin-right:10px;"/>';
                    }
					$config_html .= '</td>';
					$config_html .= '</tr>';
				}
			}
			
			return $config_html;
		}
	}
	
}