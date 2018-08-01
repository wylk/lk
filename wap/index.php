<?php
require_once dirname(__FILE__).'/global.php';

/*import('Hook');
$a = $_GET['card'];
$hook = new Hook($a);
$hook->add($a);
$html = $hook->exec('add_tpl');*/
// 认证店铺
// $storeUids = array_column($storeInfo,"uid");

$type = "offset";
$store = D("Card_package")->where(['type'=>$type,'is_publisher'=>1])->select();
$storeUids = array_column($store, "uid");
$storeInfo = D("User_audit")->where(["uid"=>['in',$storeUids]])->select();

// $type = $_GET['type']?$_GET['type']:"offset";
// $storeInfo = D("Card_package")->where(['type'=>$type,'is_publisher'=>1])->select();


// 卡的一些属性
$cardInfos = D("Card")->where(['uid'=>['in',$storeUids]])->select();
$contract_field = D("Contract_field")->select();
$arr = array();
foreach ($contract_field as $key => $value) {
	$arr[$value['id']] = $value['val'];
}

$arrs = array();
foreach ($cardInfos as $k => $v) {
	$arrs[$v['uid']][$arr[$v['c_id']]] = $v['val'];
}


//$cardInfos = D("Card")->where(['uid'=>['in',$storeUids]])->group("card_id")->select();
// $cardInfos = D("Card")->where(['uid'=>['in',$storeUids]])->select();
// $contract_field = D("Contract_field")->select();
// $arr = array();
// foreach ($contract_field as $key => $value) {
// 	$arr[$value['id']] = $value['val'];
// }

// $arrs = array();
// foreach ($cardInfos as $k => $v) {
// 	$arrs[$v['card_id']][$arr[$v['c_id']]] = $v['val'];
// }
// dump($arrs);

// die;

include display('index');
echo ob_get_clean();
