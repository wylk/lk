<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];


import("PlatformCurrency");
// 挂单

if(IS_POST && $_POST['type'] == "register"){
	$data['price'] = clear_html($_POST['buyPrice']);
	$data['tranNum'] = clear_html($_POST['buyNum']);
	$data['limitNum'] = clear_html($_POST['limitNum']);
	$data['packageId'] = clear_html($_POST['id']);
	$data['type'] = 1;
	$data['userid'] = $userId;
	
	$platformObj = new PlatformCurrency($data);
	$res = $platformObj->addEntrust();
	dexit($res);
}
// 进行交易
if(IS_POST && $_POST['type'] == "transaction"){
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);
	$orderData['userId'] = $userId;
	$orderData['num'] = clear_html($_POST['num']);

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
	$platformObj = new PlatformCurrency();
	$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>option("hairpan_set.platform_type_name")])->find();
	$sellList = $platformObj->selectTradeList(['userId'=>$userId,'type'=>'2','cardId'=>$platformInfo['card_id'],"status"=>'0','limit'=>$limit,"start_limit"=>$start_limit]);
	foreach ($sellList as $key => $value) {
		if(!in_array($value['uid'], $ids))  $ids[] = $value['uid'];
	}
	$userRes = D("User")->where("id in (".implode($ids, ",").")")->select();
	foreach($userRes as $key=>$value){
		$userInfo[$value['id']]['avatar'] = $value['avatar'];
		$userInfo[$value['id']]['name'] = $value['name'];
	}
	dexit(['res'=>0,"data"=>['sellList'=>$sellList,"userInfo"=>$userInfo]]);
}
// 查找当前用户卡包信息
$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>option("hairpan_set.platform_type_name")])->find();

// 获取卖方委托单
$platformObj = new PlatformCurrency();
$register = $platformObj->selectPersonRegister(['card_id'=>$platformInfo['card_id'],"userId"=>$userId,'type'=>'1']);
// dump($sellList);
// die();
include display('card_buy');
echo ob_get_clean();
