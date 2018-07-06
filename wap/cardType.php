<?php
require_once dirname(__FILE__).'/global.php';

// 判断是否登录状态中
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['logintime']<3600){
	// var_dump(time()-$_SESSION['loginsign']['lasttime']);
	$_SESSION['loginsign']['logintime'] = time();
	$phone = isset($_SESSION['loginsign']['phone']) ? $_SESSION['loginsign']['phone'] : "";
	$userId = isset($_SESSION['loginsign']['userid']) ? $_SESSION['loginsign']['userid'] : "";
	if(empty($phone) || empty($userId)){
		header("location:login.php");
	}
}else{
	header("location:login.php");
	exit();
}

$cardRes = M("Contract")->find();
$res = D("Card_package")->where(['uid'=>"1530523825"])->select();
$cardtype = array_column($res, "type");
$cardtype = array_map(function($value,$key){return $value.="Card";}, $cardtype);

include display('cardType');
echo ob_get_clean();
