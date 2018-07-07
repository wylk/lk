<?php
require_once dirname(__FILE__).'/global.php';


// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = isset($_GET['cardId']) ? trim($_GET['cardId']) : "";

if(isset($_POST['type']) && $_POST['type'] == "transaction"){
	$data['card_id'] = $cardId = trim($_POST['cardId']);
	$data['num'] = $num = trim($_POST['num']);
	$data['price'] = trim($_POST['price']);
	$data['limit'] = trim($_POST['limit']);
	$data['status'] = '0';
	$data['uid'] = $userId;

	$cardBagInfo = D("Card_package")->field("num,address,is_publisher,frozen")->where(['uid'=>$userId,'card_id'=>$cardId])->find();
	$cardBagInfo ? true : dexit(["res"=>1,'msg'=>"该卡券失效"]);
	$cardBagInfo['is_publisher'] == 1 ? true : dexit(["res"=>1,'msg'=>"不是本人发布"]);
	$numSum = array_sum([$cardBagInfo['frozen'],$num]);
	// 判断发布的数值超出
	$cardBagInfo['num'] >= $numSum ? true : dexit(["res"=>1,'msg'=>"发布额度超出现有额度"]);
	$data['address'] = $cardBagInfo['address'];
	// 判断是否添加交易成功
	if(D("Card_transaction")->data($data)->add()){
		$frozenData['frozen'] = $numSum;
		$a = [$frozenData['frozen'],$cardBagInfo['frozen'],$num];
		$res = D("Card_package")->data($frozenData)->where(['uid'=>$userId,'card_id'=>$cardId])->save();
		$res ? true : dexit(['res'=>1,"msg"=>"冻结修改失败","data"=>$a,"other"=>$res]);
		dexit(['res'=>0,"msg"=>"卡券发布成功","data"=>$a,"other"=>$res]);
	}
	dexit(['res'=>1,"msg"=>"卡券发布失败"]);
}

// var_dump($userId);
include display("sell");
