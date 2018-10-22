<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardWhere['is_publisher'] = 0;
$cardWhere['uid'] = $userId;
$cardList = D("Card_package")->where($cardWhere)->select();
$cardIdArr = array_column($cardList, 'card_id');
$cardRes = D("Card")->where("card_id in ('".implode($cardIdArr, "','")."')")->select();

// 获取卡券的属性
$nameArr = D('Contract_field')->select();
$nameArr = array_column($nameArr, 'val','id');

// 获取卡券属性值
$cardUid = [];
foreach ($cardRes as $key => $value) {
	$cardAttrArr[$value['card_id']][$nameArr[$value['c_id']]] = $value['val'];
	if(!in_array($value['uid'],$cardUid)){
		$cardUid[] = $value['uid'];
		$cardAttrArr[$value['card_id']]['uid'] = $value['uid'];
	}
}
// dump($cardAttrArr);

// 获取店铺名称
$cardType = D("User_audit")->field('enterprise,uid')->where("uid in ('".implode($cardUid, "','")."')")->select();
$cardType = array_column($cardType, 'enterprise','uid');
// dump($cardType);

include display('card_package');
echo ob_get_clean();
