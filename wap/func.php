<?php
// 用户端一些函数

require_once LEKA_PATH.'source/init.php';



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

