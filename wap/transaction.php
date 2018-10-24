<?php
require_once dirname(__FILE__).'/global.php';


// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 检测是否认证
$checkRes = checkUserSet($userId);
if($checkRes['res']) header("location:".$checkRes['url']);


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
	$data['revokeId'] = trim($_POST['id']);
	$data['revokeCardId'] = trim($_POST['cardId']);

	import("CardAction");
	$card = new CardAction(['userid'=>$userId]);
	$revokeRes = $card->revokeTran($data);
	dexit($revokeRes);
}

$tranWhere['uid'] = $userId;
$tranWhere['status'] = 0;
$tranWhere['card_id'] = $cardId;
$tranList = D("Card_transaction")->where($tranWhere)->order("createtime desc")->select();
$numInfo = D("Card_package")->field("num,frozen")->where(['uid'=>$userId,'card_id'=>$cardId])->find();

include display("sell");
// 检测用户是否 认证，设置地理位置，支付密码
function checkUserSet($userId){
	// 判断用户是否认证
	$userJudge = D("User_audit")->where(['uid'=>$userId,"status"=>1])->find();
	if(!$userJudge) return ['res'=>1,"msg"=>"请先认证","url"=>"./postcard.php"];
	if(empty($userJudge['address']))
		 return ['res'=>1,"msg"=>"请先输入地理位置","url"=>"./map.php"];
	$userInfo = D("User")->where(['id'=>$userId])->find();
	if(empty($userInfo['pay_img']))
		 return ['res'=>1,"msg"=>"请设置支付管理","url"=>"pay_zf.php"];
	return ['res'=>0,"msg"=>"检测通过"];
}

