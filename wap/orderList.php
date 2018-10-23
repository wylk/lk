<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 未付账订单
$where = " and out_trade_no != ''";
$unpaidOrderList = D("Orders")->where("buy_id=".$userId." and status=0 ".$where)->order("create_time desc")->select();
// 付款订单
$paidOrderList = D("Orders")->where("buy_id = ".$userId." and status = 1".$where)->order("create_time desc")->select();
// 全部订单
$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->select();

include display("orderList");