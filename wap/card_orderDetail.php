<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

if(IS_POST && $_POST['type'] == "confirmTran" ){
	$orderId = $_POST['orderId'];
	import("PlatformCurrency");
	$platformObj = new PlatformCurrency();
	$orderRes = $platformObj->transferCurrency($orderId);
	dexit($orderRes);
}


$orderId = $_GET['id'];
$orderInfo = D("Orders")->where(['id'=>$orderId])->find();

include display("card_orderDetail");