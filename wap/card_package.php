<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
if(isset($_POST['type']) && $_POST['type'] == 'page'){
	$page = isset($_POST['page']) ? $_POST['page'] : 1;
	$limit = 5;
	$offset = ($page-1)*$limit;
	if(empty($_POST['search'])){
		$cardWhere['is_publisher'] = 0;
		$cardWhere['uid'] = $userId;
		$cardList = D("Card_package")->where($cardWhere)->limit($offset.",".$limit)->select();
	}else{
		$search = $_POST['search'];
		$cardList = D()->table(['Card_package'=>"c_p","Card"=>"c"])->field("c_p.id,c_p.type,c_p.num,c_p.card_id,c_p.frozen,c_p.bail,c.val")->where("c_p.card_id=c.card_id and c.val like '%".$search."%' and c_p.is_publisher=0 and c_p.uid = ".$userId)->limit($offset.",".$limit)->select();
	}
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

	// 获取店铺名称
	$cardType = D("User_audit")->field('enterprise,uid,id')->where("uid in ('".implode($cardUid, "','")."')")->select();
	$cardType = array_column($cardType, 'enterprise','uid');
	dexit(['error'=>0,"msg"=>"获取数据成功","data"=>['cardlist'=>$cardList,"cardAttrArr"=>$cardAttrArr,"cardType"=>$cardType,"page"=>$page]]);
}



include display('card_package');
echo ob_get_clean();
