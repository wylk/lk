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
	$res = $platformObj->currency();
	dexit($res);
}
if(IS_POST && $_POST['type'] == "transaction"){
	$orderData['userId'] = $userId;
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);

	$platformObj = new PlatformCurrency();
	$orderRes = $platformObj->createOrder($orderData,'2');
	dexit($orderRes);
}


$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
// 卖单交易单
// $buyList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>1])->select();

$platformObj = new PlatformCurrency();
$buyList = $platformObj->selectRegister(['userId'=>$userId,'type'=>'1','cardId'=>$platformInfo['card_id']]);
include display('card_sell');
echo ob_get_clean();
