<?php
require_once dirname(__FILE__).'/global.php';

// $type = "offset";
// $store = D("Card_package")->where(['type'=>$type,'is_publisher'=>1])->select();
// $storeUids = array_column($store, "uid");
// $storeInfo = D("User_audit")->where(["uid"=>['in',$storeUids]])->select();


// // 卡的一些属性
// $cardInfos = D("Card")->where(['uid'=>['in',$storeUids]])->select();
// $contract_field = D("Contract_field")->select();
// $arr = array();
// foreach ($contract_field as $key => $value) {
// 	$arr[$value['id']] = $value['val'];
// }

// $arrs = array();
// foreach ($cardInfos as $k => $v) {
// 	$arrs[$v['uid']][$arr[$v['c_id']]] = $v['val'];
// }
$res=D('Shopclass')->select();
$num=count($res);
$arr=array_slice($res,0,3);
$a=array_column($arr,name,id);

$count=$num-3;
$aa=array_slice($res,$count,$num);
$ar=array_column($aa,name,id);

include display('index');
echo ob_get_clean();
