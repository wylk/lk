<?php
require_once dirname(__FILE__).'/global.php';


// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$userId = $wap_user['userid'];
$cardId = isset($_GET['cardId']) ? trim($_GET['cardId']) : "";

if(isset($_POST['type']) && $_POST['type'] == "transaction"){
	$data['cardId'] = $cardId = trim($_POST['cardId']);
	$data['num'] = trim($_POST['num']);
	$data['price'] = trim($_POST['price']);
	$data['limit'] = trim($_POST['limit']);
	$data['status'] = '0';
	$data['uid'] = $userId;

	$cardBagInfo = D("Card_package")->where(['uid'=>$userId,'card_id'=>$cardId])->find();
	if(!$cardBagInfo ){
		dexit(["res"=>1,'msg'=>"该卡券失效","other"=>$cardBagInfo]);
	}
	$cardBagInfo['is_publisher'] == 1 ? true : dexit(["res"=>1,'msg'=>"不是本人发布");
	$cardBagInfo['is_publisher'] == 1 ? true : dexit(["res"=>1,'msg'=>"不是本人发布");
	$data['address'] = $cardBagInfo['address'];
	if(D("Card_transaction")->data($data)->add()){
		dexit(['res'=>0,"msg"=>"卡券发布成功"]);
	}
	dexit(['res'=>1,"msg"=>"卡券发布失败"]);
}

// var_dump($userId);
include display("transaction");
