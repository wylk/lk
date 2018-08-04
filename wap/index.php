<?php
require_once dirname(__FILE__).'/global.php';

/*$type = "offset";
$store = D("Card_package")->where(['type'=>$type,'is_publisher'=>1])->select();
$storeUids = array_column($store, "uid");
$storeInfo = D("User_audit")->where(["uid"=>['in',$storeUids]])->select();


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
*/
include display('index');
echo ob_get_clean();
