<?php
// 用户端一些函数

require_once LEKA_PATH.'source/init.php';

//生成验证码随机数
function rangdNumber($len){
	if(!isset($len) || !is_numeric($len)) $len = 6;
	$chars = "0123456789";
	$chars = str_repeat($chars,$len);
	$chars = str_shuffle($chars);
	$char = substr($chars,0,$len);
	return $char;
}

// 验证手机号
function checkTelephone($phone){
	if(!$phone) exit("请您输入正确的手机号");
	$reg = "/^1([0-9]{10})$/";
	$result = preg_match($reg,$phone);
	if($result) return true;
	else return false;
}
// 判断用户是否登录
function login($phone){
	return $_SESSION['phone'];
}

// 二维转化为一维数组
function transformArray($array,$keyWord=null){
	if(!is_array($array) && empty($array)) return $array;
	$count = count($array);
	if($count == 1){
		foreach($array as $key=>$val){
			if(empty($keyWord)) $arr = $val;
			else $arr = $val[$keyWord]; 
		}
	}else{
		foreach($array as $key=>$val){
			if(empty($keyWord)){
				foreach ($val as $k => $v) {
					$arr[] = $v;
				}
			}else{
				$arr[] = $val[$keyWord];
			}
		}
	}
	return $arr;
}

// 根据条件关键字整理数组
function takeKeyArray($array,$keyWord,$wordValue){
	if(!is_array($array) || empty($keyWord)) return $array;
	$arr = [];
	if(!empty($wordValue)){
		foreach($array as $key => $value){
			if($value[$keyWord] == $wordValue){
				$arr[] = $value;
			}
		}
	}else{
		foreach ($array as $key => $value) {
		// var_dump($keyWord);
			$arr[$value[$keyWord]][] = $value;
		}
	}
	return $arr;
}
