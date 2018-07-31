<?php
require_once dirname(__FILE__).'/global.php';

/*import('Hook');
$a = $_GET['card'];
$hook = new Hook($a);
$hook->add($a);
$html = $hook->exec('add_tpl');*/
// 认证店铺
// $storeInfo = D("User_audit")->where(['status'=>1,"type"=>2])->select();
// $storeUids = array_column($storeInfo,"uid");
$type = $_GET['type']?$_GET['type']:"offset";
$storeInfo = D("Card_package")->where(['type'=>$type,'is_publisher'=>1])->select();

// // // 获取卡券的id
// $cardPackage = D("Card_package")->where(['type'=>"offset",'is_publisher'=>1])->select();
// $cardIds = array_column($cardPackage,'card_id');

// $where = "card_id in ( '".implode(' \',\' ', $cardIds)."')";
// $cardInfo = D("Card")->where($where)->select();
// dump($cardInfo);

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
