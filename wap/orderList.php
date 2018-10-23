<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 全部订单
$where = " and out_trade_no != ''";
$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->select();
foreach ($orderList as $key => $value) {
	if($value['status'] == '1'){
		$paidOrderList[] = $value;  // 付款订单
	}elseif($value['status'] == '0'){
		$unpaidOrderList[] = $value;  // 未付账订单
	}
}
include display("orderList");