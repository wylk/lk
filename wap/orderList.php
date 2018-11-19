<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$limitNum = 5;
$where = " and out_trade_no != ''";
if(IS_POST){
$page = $_POST['page'];
if(empty($page)) $page = 1;
if($page == 1) $limit = $limitNum;
else $limit = ($page-1)*$limitNum.",".$limitNum;
$action = $_GET['action'];
	switch ($action) {
		case 'all':
			$orderList = D("Orders")->where("buy_id = ".$userId." and status in (0,1,3) ".$where)->order("create_time desc")->limit($limit)->select();
			break;
		case 'paid':
			$orderList = D("Orders")->where("buy_id = ".$userId." and status = 1 ".$where)->order("create_time desc")->limit($limit)->select();
			break;
		case 'unpaid':
			$orderList = D("Orders")->where("buy_id = ".$userId." and status = 0 ".$where)->order("create_time desc")->limit($limit)->select();
			break;
		default:
			# code...
			break;
	}
	if($orderList)
		dexit(['error'=>0,"msg"=>"数据","data"=>["data"=>$orderList,"limit"=>$limitNum,"page"=>$page+1],'action'=>$action]);
	dexit(['error'=>1,"msg"=>"数据","data"=>["data"=>$orderList,"limit"=>$limitNum,"page"=>$page+1],"action"=>$action]);
}

include display("orderList");