<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// 转账是否需要身份认证 true:需要身份认证 false:不需要身份认证
$identityJudge = false;

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
	$getAddressInfo ? true : dexit(['res'=>1,"msg"=>"您输入的地址不正确"]);
	$sendAdressInfo = D("Card_package")->where(['uid'=>$userId,'address'=>$sendAddress])->find();
	$sendAdressInfo['num'] >= $num ? true : dexit(['res'=>1,"msg"=>"您转账的数目已超支"]);
	// 判断地址是否保存过
	$remarkCheckRes = D("User_address")->where(['uid'=>$userId,"address"=>$getAddress])->find();
	if(!$remarkCheckRes){
		$res = D("User_address")->data(['uid'=>$userId,"address"=>$getAddress,"name"=>$addressName,'createtime'=>time()])->add();
	}elseif($remarkCheckRes['name'] != $addressName){
		$res = D("User_address")->data(['name'=>$addressName])->where(['uid'=>$userId,"address"=>$getAddress])->save();
	}
	
	// 添加账本信息
	import("AccountBook");
	$Account_book = new AccountBook();
	$bookJson = json_encode(['uid'=>$userId,"contract_id"=>$cardId,'sendAddress'=>$sendAddress,"num"=>$num,"getAddress"=>$getAddress]);
	$bookRes = $Account_book->transferAccounts(encrypt($bookJson));
	// dexit(['res'=>1,"msg"=>"添加账本错误","other"=>$bookRes]);
	if(!$bookRes){
		dexit(['res'=>1,"msg"=>"添加账本错误","other"=>$bookRes]);
	}
	// 卡包数据处理
	$sendRes = D("Card_package")->where(['uid'=>$userId,'address'=>$sendAddress])->setDec("num",$num);
	$getRes = D("Card_package")->where(['address'=>$getAddress])->setInc("num",$num);
	if(!($getRes || $sendRes)){
		dexit(['res'=>1,"msg"=>"转账失败！"]);
	}

	dexit(['res'=>0,"msg"=>"转账成功！"]);
}
if(IS_POST && $_POST['type'] == "getRemark"){
	$addresList = D("User_address")->where(['uid'=>$userId])->select();
	if($addresList){
		dexit(['res'=>1,"msg"=>"请选择转账地址","list"=>$addresList]);
	}
	dexit(['res'=>0,"msg"=>"还未保存转账地址"]);
}

if($identityJudge){
	$identityJudgeRes = D("User_audit")->where(['uid'=>$userId])->find();
	if(!$identityJudgeRes){
		header("location:postcard.php");
	}
}
$id = clear_html($_GET['id']);
$cardInfo = D("Card_package")->where(['id'=>$id])->find();
// dump($cardInfo);
include display("transferBill");

function encrypt($data)
{
	$key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqWgSnGR1Q2zsICgq0hmqh22BvTGqyPelEv3mXzuQ9CNq6xmxYHPzcGqabjP0r/2tJE465AfD2Gf6EGT6LU2h6qxx0Jw3firixZmwyWJ6M5lqWJA0p2bjdUCqK2H7/+s6J3uTXJvLNggoaI2SXaJOoACq5uk4Rm6g7CN9TJNdxTlga6fOSUjzI6N3ba27Jmp4laWHFhHl93rKPSx/mv08p7P5sj9GMJMAHwFvjq+/xiUlX2kzW0qqQT3eXv7I8J6Qu6J8vb3K8UqUGd2DOoC9iVOiqtcp2u5uMSk+pgQqMK6UvnTQ838WxbEy9tnAB5MWzEmZETvC+5OHGTdEBqnCUQIDAQAB
-----END PUBLIC KEY-----';
    $encryptedList = array();
    $step          = 11700;
    $encryptedData = '';
    $len = strlen($data);
    for ($i = 0; $i < $len; $i += $step) {
       $tmpData   = substr($data, $i, $step);
       $encrypted = '';
        openssl_public_encrypt($tmpData, $encrypted, $key,OPENSSL_PKCS1_PADDING);
       $encryptedList[] = ($encrypted);
    }
     $encryptedData = base64_encode(join('', $encryptedList));
    return $encryptedData;
}