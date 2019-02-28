<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

if(isset($_POST['type']) && $_POST['type'] == "page"){
	$page = isset($_POST['page']) ? $_POST['page'] : 1;
	$limit = 10;
	$offset = ($page-1)*$limit;
	$limitStr = $offset.",".$limit;
	import("PlatformCurrency");
	$platformObj = new PlatformCurrency();
	$orderList = $platformObj->selectOrderList(['userId'=>$userId,'status'=>"in (0,3)","limit"=>$limitStr]);
	if($orderList)
		dexit(['error'=>0,"msg"=>"获取订单成功","data"=>$orderList]);
	else
		dexit(['error'=>1,"msg"=>"获取订单失败","data"=>$orderList]);
}

import("PlatformCurrency");
$platformObj = new PlatformCurrency();
$orderList = $platformObj->selectOrderList(['userId'=>$userId,'status'=>"in (0,3)"]);

include display('card_order');
echo ob_get_clean();
