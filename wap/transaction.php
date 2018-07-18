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
	$data['card_id'] = $cardId = trim($_POST['cardId']);
	$data['num'] = $num = trim($_POST['num']);
	$data['price'] = trim($_POST['price']);
	$data['limit'] = trim($_POST['limit']);
	$data['status'] = '0';
	$data['uid'] = $userId;
	$data['createtime'] = time();
	$data['updatetime'] = time();

	$cardBagInfo = D("Card_package")->field("num,address,is_publisher,frozen")->where(['uid'=>$userId,'card_id'=>$cardId])->find();
	$cardBagInfo ? true : dexit(["res"=>1,'msg'=>"该卡券失效"]);
	$cardBagInfo['is_publisher'] == 1 ? true : dexit(["res"=>1,'msg'=>"不是本人发布"]);
	
	$surplusNum = $cardBagInfo['num'] - $cardBagInfo['frozen'] - $num;
	// 判断发布的数值超出
	$surplusNum >= 0 ? true : dexit(["res"=>1,'msg'=>"发布额度超出现有额度"]);
	$data['address'] = $cardBagInfo['address'];
	// 判断是否添加交易成功
	$tranId = D("Card_transaction")->data($data)->add();
	if($tranId){
		$res = D("Card_package")->where(['uid'=>$userId,'card_id'=>$cardId])->setInc("frozen",$num);
		$res ? true : dexit(['res'=>1,"msg"=>"冻结修改失败","other"=>$tranInfo]);
		D("Card_package")->where(['uid'=>$userId,"card_id"=>$cardId])->setDec("num",$num);
		$tranInfo = D("Card_transaction")->where(['id'=>$tranId])->find();
		dexit(['res'=>0,"msg"=>"卡券发布成功","dataInfo"=>$tranInfo,"num"=>$surplusNum]);
	}
	dexit(['res'=>1,"msg"=>"卡券发布失败"]);
}
// 交易单撤销请求
if(isset($_POST['type']) && $_POST['type'] == "revoke"){
	$revokeId = trim($_POST['id']);
	// $revokeNum = trim($_POST['num']);
	$revokeCardId = trim($_POST['cardId']);
	$revokeInfo = D("Card_transaction")->where(['id'=>$revokeId])->find();
	$res = D("Card_transaction")->data(['status'=>2,"updatetime"=>time()])->where(['id'=>$revokeId])->save();

	if(!$res) {
		dexit(['res'=>1,"msg"=>"订单撤销失败",'other'=>$res]);
	}
	$res = D("Card_package")->where(['uid'=>$userId,"card_id"=>$revokeCardId])->setDec("frozen",$revokeInfo['num']);
	D("Card_package")->where(['uid'=>$userId,"card_id"=>$revokeCardId])->setInc("num",$revokeInfo['num']);
	dexit(['res'=>0,"msg"=>"订单撤销成功"]);
}

$tranWhere['uid'] = $userId;
$tranWhere['status'] = 0;
$tranWhere['card_id'] = $cardId;
$tranList = D("Card_transaction")->where($tranWhere)->order("createtime desc")->select();
$numInfo = D("Card_package")->field("num,frozen")->where(['uid'=>$userId,'card_id'=>$cardId])->find();

include display("sell");
