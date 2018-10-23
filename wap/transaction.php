<?php
require_once dirname(__FILE__).'/global.php';


// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 判断用户是否认证
$userJudge = D("User_audit")->where(['uid'=>$userId,"status"=>1])->find();
$userJudge ? true : redirect("./postcard.php");


$cardId = isset($_GET['cardId']) ? trim($_GET['cardId']) : "";
// 添加交易单请求处理
if(isset($_POST['type']) && $_POST['type'] == "transaction"){
	$data['cardId'] = trim($_POST['cardId']);
	$data['num'] = trim($_POST['num']);
	$data['price'] = trim($_POST['price']);
	$data['limit'] = trim($_POST['limit']);

	import("CardAction");
	$card = new CardAction(['userid'=>$userId]);
	$sellRes = $card->sellCard($data);
	dexit($sellRes);
}
// 交易单撤销请求
if(isset($_POST['type']) && $_POST['type'] == "revoke"){
	$revokeId = trim($_POST['id']);
	$revokeCardId = trim($_POST['cardId']);
	// 判断是否有订单未处理
	$checkRes = D("Orders")->where("(tran_id = ".$revokeId." or tran_other = ".$revokeId.") and status = 0")->sum("number");
	if($checkRes) dexit(['res'=>1,"msg"=>"还有".$checkRes."订单未处理"]);
	$revokeInfo = D("Card_transaction")->where(['id'=>$revokeId])->find();
	$res = D("Card_transaction")->data(['status'=>2,"updatetime"=>time()])->where(['id'=>$revokeId])->save();

	if(!$res) {
		dexit(['res'=>1,"msg"=>"订单撤销失败",'other'=>$res]);
	}
	$revokeNum = $revokeInfo['num'] - $revokeInfo['frozen'];
	$res = D("Card_package")->where(['uid'=>$userId,"card_id"=>$revokeCardId])->setDec("frozen",$revokeNum);
	D("Card_package")->where(['uid'=>$userId,"card_id"=>$revokeCardId])->setInc("num",$revokeNum);
	dexit(['res'=>0,"msg"=>"订单撤销成功"]);
}

$tranWhere['uid'] = $userId;
$tranWhere['status'] = 0;
$tranWhere['card_id'] = $cardId;
$tranList = D("Card_transaction")->where($tranWhere)->order("createtime desc")->select();
$numInfo = D("Card_package")->field("num,frozen")->where(['uid'=>$userId,'card_id'=>$cardId])->find();

include display("sell");
