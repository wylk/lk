<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = $_GET['cardId'];
$limitNum = 9;
if(IS_POST){
	$page = $_POST['page'];
	if(empty($page)) $page = 1;
	if($page == 1) $limit = $limitNum;
	else $limit = $limitNum*($page-1).",".$limitNum;
	$userInfo = D("Card_package")->where(['uid'=>$userId,'card_id'=>$cardId])->find();
	$address = $userInfo['address'];

	$where = "`card_id` ='".$cardId."' and ( `get_address`='".$address."' or `send_address`='".$address."' )";
	$recordList = D("Record_books")->where($where)->order("createtime desc")->limit($limit)->select();
	if(!$recordList)
		dexit(['error'=>1,"msg"=>"数据错误","data"=>["data"=>$recordList,"limit"=>$limitNum,"page"=>$page+1]]);
	dexit(['error'=>0,"msg"=>"账单数据","data"=>["data"=>$recordList,"limit"=>$limitNum,"page"=>$page+1]]);
}





$userInfo = D("Card_package")->where(['uid'=>$userId,'card_id'=>$cardId])->find();
$address = $userInfo['address'];

include display("recordBooks");