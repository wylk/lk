<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardWhere['is_publisher'] = 0;
$cardWhere['uid'] = $userId;
$cardList = D("Card_package")->where($cardWhere)->select();
$cardIdArr = array_column($cardList, 'card_id');
foreach($cardList as $key=>$value){
	$cardUid[] = $value['uid'];
}

$nameArr = D('Contract_field')->select();
$nameArr = array_column($nameArr, 'val','id');

$attrList = "card_id in ('".implode($cardIdArr, "','")."')";
$cardRes = D("Card")->where($attrList)->select();

foreach ($cardRes as $key => $value) {
	$cardAttrArr[$value['card_id']][$nameArr[$value['c_id']]] = $value['val'];
}
// var_dump($cardAttrArr);
$cardType = D("User_audit")->field('name,uid')->where("uid in ('".implode($cardUid, ",")."')")->select();
$cardType = array_column($cardType, 'name','uid');
// dump($cardType);

include display('card_package');
echo ob_get_clean();
