<?php
/**
 * 基础类
 *
 */
class controller{
	public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	public function assign($field,$value=''){
		if(!empty($value)){
			$this->arrays[$field] = $value;
		}else if(is_array($field)){
			foreach($field as $key=>$value){
				$this->arrays[$key] = $value;
			}
		} else {
			$this->arrays[$field] = $value;
		}
	}
	public function display($tpl=''){
		foreach($this->arrays as $key=>$value){
			$$key = $value;
		}
		include display($tpl);
	}
	public function clear_html($array,$exception = ''){
		$exception = explode(',',$exception);
		foreach($array as $key=>$value){
			if(in_array($key,$exception)){
				$array[$key] = stripslashes($value);
			}else{
				$array[$key] = trim(htmlspecialchars($value));
			}
		}
		return $array;
	}

	public function dexit($data = '')
    {
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
        exit();
    }
}
?>
