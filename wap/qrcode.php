<?php
require_once dirname(__FILE__).'/global.php';
require_once('../wap/phpqrcode.php');//redirect($_G['config']['site_url'] . '/static/images/no_qrcode.png')))
$type = (isset($_GET['type']))?$_GET['type']:'pay';
switch ($type) {
	case 'pay':
		$cardId = (isset($_GET['cardId']))?$_GET['cardId']:'';
		$address = (isset($_GET['address']))?$_GET['address']:'';
		$name = (isset($_GET['name']))?$_GET['name']:'';
		$url = $_G['config']['wap_site_url'].'/transferBill.php?cardId='.$cardId.'&address='.$address.'&name='.$name;
		break;
	
	default:
		# code...
		break;
}
QRcode::png($url,false,2,6,2);