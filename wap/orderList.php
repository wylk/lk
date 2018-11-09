<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$limit = 2;
$where = " and out_trade_no != ''";
$page = 1;
if(IS_POST){
	$type = $_GET['type'];
	// switch ($type) {
	// 	case 'all':
	// 		$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->limit($limit)->select();
	// 		break;
	// 	case 'paid':
	// 		$orderList = D("Orders")->where("buy_id = ".$userId."and status = 1 ".$where)->order("create_time desc")->limit(5)->select();
	// 		break;
	// 	case 'unpaid':
	// 		$orderList = D("Orders")->where("buy_id = ".$userId."and status = 3 ".$where)->order("create_time desc")->limit(5)->select();
	// 		break;
	// 	default:
	// 		# code...
	// 		break;
	// }
$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->limit($limit)->select();
	if($orderList)
		dexit(['error'=>0,"msg"=>"数据","data"=>["data"=>$orderList,"limit"=>$limit,"page"=>$page]]);
	dexit(['error'=>1,"msg"=>"数据","data"=>["data"=>$orderList,"limit"=>$limit,"page"=>$page]]);
}



// 全部订单
$where = " and out_trade_no != ''";
$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->limit(5)->select();
$paidOrderList = D("Orders")->where("buy_id = ".$userId."and status = 1 ".$where)->order("create_time desc")->limit(5)->select();
$unpaidOrderList = D("Orders")->where("buy_id = ".$userId."and status = 3 ".$where)->order("create_time desc")->limit(5)->select();
// dump($orderList);
include display("orderList");