<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

if(IS_POST && $_POST['type'] == "register"){
	$data['price'] = clear_html($_POST['buyPrice']);
	$data['tranNum'] = clear_html($_POST['buyNum']);
	$data['limitNum'] = clear_html($_POST['limitNum']);
	$data['packageId'] = clear_html($_POST['id']);
	$data['type'] = 1;
	$data['userid'] = $userId;
	import("PlatformCurrency");
	$platformObj = new PlatformCurrency($data);
	$res = $platformObj->currency();
	dexit($res);
}
if(IS_POST && $_POST['type'] == "transaction"){
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);
	$orderData['userId'] = $userId;
	import("PlatformCurrency");
	$platformObj = new PlatformCurrency();
	$orderRes = $platformObj->createOrder($orderData,"1");
	dexit($orderRes);
}
// 查找当前用户卡包信息
$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
// 查询当前卖单信息
$sellList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>"2","status"=>'0'])->select();
// dump($sellList);die();
include display('card_buy');
echo ob_get_clean();
