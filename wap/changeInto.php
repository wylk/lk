<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// 转账是否需要身份认证 true:需要身份认证 false:不需要身份认证
$identityJudge = false;
if($identityJudge){
	$identityJudgeRes = D("User_audit")->where(['uid'=>$userId])->find();
	if(!$identityJudgeRes){
		header("location:postcard.php");
	}
}
$id = $_GET['id'];
$card_package = D("Card_package")->where(['id'=>$id])->find();
$user = D('User')->where(['id'=>$userId])->find();
include display("changeInto");

