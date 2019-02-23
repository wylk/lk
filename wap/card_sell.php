<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
import("PlatformCurrency");

// 卖单挂单处理

if(IS_POST && $_POST['type'] == "register"){
	$data['price'] = clear_html($_POST['price']);
	$data['tranNum'] = clear_html($_POST['num']);
	$data['limitNum'] = clear_html($_POST['limitNum']);
	$data['packageId'] = clear_html($_POST['id']);
	$data['type'] = 2;
	$data['userid'] = $userId;

	$checkRes = checkUserSet($userId);
	if($checkRes['res']) dexit($checkRes);
	
	$platformObj = new PlatformCurrency($data);
	$res = $platformObj->addEntrust();
	dexit($res);
}
if(IS_POST && $_POST['type'] == "transaction"){
	$orderData['userId'] = $userId;
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);
	$orderData['num'] = clear_html($_POST['num']);

	$checkRes = checkUserSet($userId);
	if($checkRes['res']) dexit($checkRes);

	$platformObj = new PlatformCurrency();
	$orderRes = $platformObj->marksetTrade($orderData);
	dexit($orderRes);
}
if(IS_POST && $_POST['type'] == "revoke"){
	$revoke['tranId'] = $_POST['tranId'];
	$revoke['packageId'] = $_POST['packageId'];
	$platformObj = new PlatformCurrency();
	$revoke = $platformObj->revokeRegister($revoke);
	dexit($revoke);
}
if(IS_POST && $_POST['type'] == 'page'){
	$page = $_POST['page'];
	$limit = 10;
	$start_limit = $page*$limit;
	$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>option("hairpan_set.platform_type_name")])->find();
	$platformObj = new PlatformCurrency();
	$buyList = $platformObj->selectTradeList(['userId'=>$userId,'type'=>'1','cardId'=>$platformInfo['card_id'],"status"=>0,'limit'=>$limit,"start_limit"=>$start_limit]);
	foreach ($buyList as $key => $value) {
		if(!in_array($value['uid'], $ids))  $ids[] = $value['uid'];
	}
	$userRes = D("User")->where("id in (".implode($ids, ",").")")->select();
	foreach($userRes as $key=>$value){
		$userInfo[$value['id']]['avatar'] = $value['avatar'];
		$userInfo[$value['id']]['name'] = $value['name'];
	}
	dexit(['res'=>0,"data"=>['buyList'=>$buyList,"userInfo"=>$userInfo]]);
}

$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>option("hairpan_set.platform_type_name")])->find();

$platformObj = new PlatformCurrency();
$register = $platformObj->selectPersonRegister(['card_id'=>$platformInfo['card_id'],"userId"=>$userId,'type'=>'2']);
//dump($register);die();
include display('card_sell');
echo ob_get_clean();
// 检测用户是否 认证，设置地理位置，支付密码
function checkUserSet($userId){
	// 判断用户是否认证
	$userJudge = D("Pay_img")->where(['uid'=>$userId])->select();
	if(empty($userJudge))
		 return ['res'=>1,"msg"=>"请设置支付管理".$userId,"url"=>"pay_zf.php"];
	return ['res'=>0,"msg"=>"检测通过"];
}
