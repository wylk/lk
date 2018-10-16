<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
 

// 判断地址是否存在
if(IS_POST && $_POST['type'] == "transferBill"){
	$post = clear_html($_POST);
	$sendAddress = $post['sendAddress'];
	$getAddress = $post['getAddress'];
	$cardId = $post['cardId'];
	$num = $post['num'];
	$addressName = $post['addressName'];
	// 转账信息判断
	$getAddressInfo = D("Card_package")->where(['address'=>$getAddress])->find();
	$cardType = $getAddressInfo['type'];
	$getAddressInfo['uid'] != $userId ? true : dexit(['res'=>1,"msg"=>"转账账户不能为本人账户"]);
	$getAddressInfo['card_id'] == $cardId ? true : dexit(['res'=>1,"msg"=>"不同种类型卡券不可转账"]);
	$isPublisher = $getAddressInfo['is_publisher'] == 1 ? true : false;
	$getAddressInfo ? true : dexit(['res'=>1,"msg"=>"您输入的地址不正确"]);
	$sendAdressInfo = D("Card_package")->where(['uid'=>$userId,'address'=>$sendAddress])->find();
	$num > 0 ? true : dexit(['res'=>1,"msg"=>"您转账的数目不能低于0"]);
	$sendAdressInfo['num'] >= $num ? true : dexit(['res'=>1,"msg"=>"您转账的数目已超支"]);
	// 判断地址是否保存过
	$remarkCheckRes = D("User_address")->where(['uid'=>$userId,"address"=>$getAddress])->find();
	if(!$remarkCheckRes){
		$res = D("User_address")->data(['uid'=>$userId,"address"=>$getAddress,"card_id"=>$cardId,"name"=>$addressName,'createtime'=>time()])->add();
	}elseif($remarkCheckRes['name'] != $addressName){
		$res = D("User_address")->data(['name'=>$addressName])->where(['uid'=>$userId,"address"=>$getAddress])->save();
	}
	
	// 添加账本信息
	// 判断转账卡券类型
	$platformType = option("hairpan_set.platform_type_name");
	switch ($cardType) {
		case $platformType:
			import("PlatformCurrency");
            $platformObj = new PlatformCurrency(['userid'=>$userId]);
            $res = $platformObj->tranEachOther($sendAddress,$getAddress,$num);
            if($res['res']) dexit($res);
			break;
		default:
			import("AccountBook");
			$Account_book = new AccountBook();
			$bookJson = json_encode(['uid'=>$userId,"contract_id"=>$cardId,'sendAddress'=>$sendAddress,"num"=>$num,"getAddress"=>$getAddress]);
			$bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));
			if(!$bookRes){
				dexit(['res'=>1,"msg"=>"添加账本错误"]);
			}
			// 添加交易记录
			$recodRes = D("Record_books")->data(['card_id'=>$cardId,'send_address'=>$sendAddress,'get_address'=>$getAddress,'num'=>$num,"type"=>$sendAdressInfo['type'],"createtime"=>time()])->add();
			if(!$recodRes){
				dexit(['res'=>1,"msg"=>"记录添加失败","other"=>$recodRes]);
			}
			// 卡包数据处理
			$sendRes = D("Card_package")->where(['uid'=>$userId,'address'=>$sendAddress])->setDec("num",$num);
			$getRes = D("Card_package")->where(['address'=>$getAddress])->setInc("num",$num);
			
			D("Card_package")->where(['address'=>$getAddress])->setInc("recovery_count",$num);
			if(!($getRes || $sendRes)) dexit(['res'=>1,"msg"=>"转账失败！"]);
			break;
	}

	dexit(['res'=>0,"msg"=>"转账成功！","isPublisher"=>$isPublisher]);
}
// 获取保存的地址
if(IS_POST && $_POST['type'] == "getRemark"){
	$cardId = $_POST['cardId'];
	$addresList = D("User_address")->where(['uid'=>$userId,"card_id"=>$cardId])->select();
	if($addresList){
		dexit(['res'=>0,"msg"=>"请选择转账地址","list"=>$addresList]);
	}
	dexit(['res'=>1,"msg"=>"还未保存转账地址"]);
}
//添加评价
if(IS_POST && $_POST['type'] == "addEval"){
	$cardId = clear_html($_POST['cardId']);
	$content = clear_html($_POST['content']);
	$addEvalRes = D("Evaluate")->data(['uid'=>$userId,"content"=>$content,"card_id"=>$cardId,"createtime"=>time()])->add();
	if($addEvalRes){
		dexit(['res'=>0,"msg"=>"评价成功"]);
	}
	dexit(['res'=>1,"msg"=>"评价失败",'other'=>$addEvalRes]);
}

// 转账是否需要身份认证 true:需要身份认证 false:不需要身份认证
if(option("hairpan_set.identity_judge")){
	$identityJudgeRes = D("User_audit")->where(['uid'=>$userId])->find();
	if(!$identityJudgeRes){
		header("location:postcard.php");
	}
}
// $cardInfo = D("Card_package")->where(['uid'=>$userId,'type'=>option("hairpan_set.platform_type_name")])->find();
$cardInfo = D("Card_package")->where(['uid'=>$userId,'card_id'=>$_GET['cardId']])->find();
include display("transferBill");
