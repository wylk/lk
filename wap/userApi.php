<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$userInfo = D("User_audit")->where(['uid'=>$userId])->find();
if(empty($userInfo['mid'])){
	$user = D("User")->where(['id'=>$userId])->find();

	$str1 = strrev(substr($user['phone'],0,3));
	$str2 = strrev(substr($user['phone'],3,4));
	$str3 = strrev(substr($user['phone'],7));
	$mid = $str1.$str2.$str3;

	$key = md5($user['phone']."-".$userInfo['id']);

	$res = D("User_audit")->data(['mid'=>$mid,"key"=>$key])->where(['id'=>$userInfo['id']])->save();
}
include display("userApi");