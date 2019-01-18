<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
$phone = $wap_user['phone'];

if($_POST['type'] == 'verify'){
	$code = rangdNumber($verifyLen);
	$obj = new Transfer();
	$messageRes = $obj->message($phone,["code"=>$code]);
	if($messageRes['result']['success']){
		$_SESSION['verify'][$phone] = $code;
		echo json_encode(['messageRes'=>$messageRes['result']['success'],"code"=>$code]);
	}else{
		echo json_encode(['messageRes'=>false]);
	}
	exit();
}
if($_POST['type'] == "apply"){
	$pwd = $_POST['pwd'];
	// if($pwd != $_SESSION['verify'][$phone])
	// 	dexit(['res'=>1,"msg"=>"验证码错误！"]);

	$str1 = strrev(substr($phone,0,3));
	$str2 = strrev(substr($phone,3,4));
	$str3 = strrev(substr($phone,7));
	$mid = $str1.$str2.$str3;

	$key = md5($phone."-".$userId);

	$res = D("User_audit")->data(['mid'=>$mid,"mid_key"=>$key])->where(['uid'=>$userId])->save();
	if($res) dexit(['res'=>0,"msg"=>"您的审核已提交成功"]);
	else dexit(['res'=>1,"msg"=>"您的审核提交失败，请您重新提交"]);
}

$userInfo = D("User_audit")->where(['uid'=>$userId])->find();

$phoneShow = substr($phone,0,3)."****".substr($phone,7);

$arr = ['15703216869','17319438382'];
if(in_array($wap_user['phone'], $arr)){
	include display("userApi1");
	die();
}
include display("userApi");