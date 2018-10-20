<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
import("PlatformCurrency");

// 卖单挂单处理

if(IS_POST && $_POST['type'] == "register"){
    check($userId);
	$data['price'] = clear_html($_POST['price']);
	$data['tranNum'] = clear_html($_POST['num']);
	$data['limitNum'] = clear_html($_POST['limitNum']);
	$data['packageId'] = clear_html($_POST['id']);
	$data['type'] = 2;
	$data['userid'] = $userId;
	$platformObj = new PlatformCurrency($data);
	$res = $platformObj->addEntrust();
	dexit($res);
}
if(IS_POST && $_POST['type'] == "transaction"){
    check($userId);
	$orderData['userId'] = $userId;
	$orderData['tranId'] = clear_html($_POST['tranId']);
	$orderData['packageId'] = clear_html($_POST['packageId']);
	$orderData['num'] = clear_html($_POST['num']);

	$platformObj = new PlatformCurrency();
	$orderRes = $platformObj->marksetTrade($orderData);
	dexit($orderRes);
}
if(IS_POST && $_POST['type'] == "revoke"){
	$revoke['tranId'] = $_POST['tranId'];
	$revoke['packageId'] = $_POST['packageId'];
	$platformObj = new PlatformCurrency();
	$revoke = $platformObj->revokeRegister($revoke);
	dexit($revoke);
}


$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>option("hairpan_set.platform_type_name")])->find();
// 卖单交易单
// $buyList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>1])->select();

$platformObj = new PlatformCurrency();
$buyList = $platformObj->selectTradeList(['userId'=>$userId,'type'=>'1','cardId'=>$platformInfo['card_id'],"status"=>0]);
// dump($buyList);
foreach ($buyList as $key => $value) {
	if(!in_array($value['uid'], $ids))  $ids[] = $value['uid'];
}
// dump($ids);
$userRes = D("User")->where("id in (".implode($ids, ",").")")->select();

foreach($userRes as $key=>$value){
	$userInfo[$value['id']]['avatar'] = $value['avatar'];
	$userInfo[$value['id']]['name'] = $value['name'];
}

$register = $platformObj->selectPersonRegister(['card_id'=>$platformInfo['card_id'],"userId"=>$userId,'type'=>'2']);
//dump($register);die();
include display('card_sell');
echo ob_get_clean();
function check($userId){
	// 判断用户是否认证
	$userJudge = D("User_audit")->where(['uid'=>$userId,"status"=>1])->find();
	if($userJudge==null){
     dexit(['res'=>1,"msg"=>"请先认证","url"=>"./postcard.php"]);
	}
	$map=D("Map")->where(array('uid'=>$userId))->find();
	if($map==null){
		 dexit(['res'=>2,"msg"=>"请先输入地理位置","url"=>"./setup.php"]);
	}
	$pay_img=D("Pay")->where(array('uid'=>$userId))->find();
	if($pay_img==null){
		 dexit(['res'=>3,"msg"=>"请设置支付管理","url"=>"pay_zf.php"]);
	}
	 // dexit(['res'=>0,"msg"=>"成功"]);
}
