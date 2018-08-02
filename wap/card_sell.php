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
	$platformObj = new PlatformCurrency($data);
	$res = $platformObj->addEntrust();
	dexit($res);
}
if(IS_POST && $_POST['type'] == "transaction"){
	$orderData['userId'] = $userId;
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);
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


$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
// 卖单交易单
// $buyList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>1])->select();

$platformObj = new PlatformCurrency();
$buyList = $platformObj->selectTradeList(['userId'=>$userId,'type'=>'1','cardId'=>$platformInfo['card_id'],"status"=>0]);

$register = $platformObj->selectPersonRegister(['card_id'=>$platformInfo['card_id'],"userId"=>$userId,'type'=>'2']);
// dump($register);die();
include display('card_sell');
echo ob_get_clean();
