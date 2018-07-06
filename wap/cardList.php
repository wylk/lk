<?php
require_once dirname(__FILE__).'/global.php';



	$where['uid'] = 12;
	// 获取店铺发卡的类型
	$cardBagList = D("Card_package")->where($where)->select();
	// $cardIds = array_column($cardPageList, 'card_id')
	// $accountBook = D("User_account_book")->where(['card_id'=>$])->select();

	// // 获取card的属性
	// $cardIds = array_keys($cardPageList);
	// $cardIdstr = implode($cardIds, "','");
	// $where = "card_id in('".$cardIdstr."')";
	// // $cardWhere['card_id'] = count($cardIds)>1 ? ['in',$cardIds] : $cardIds[0];
	// // 获取卡片的信息
	// $cards = D("Card")->where($where)->select();

	// // $cids = array_column($cards,"c_id");
	// // 获取所有属性列表
	// $cidField = D("Contract_field")->where()->select();
	// $cidField = array_column($cidField,null,"id");

	// // 整理卡的信息
	// foreach($cards as $key => $value ){
	// 	$list[$value['card_id']]['uid'] = $value['uid'];
	// 	$list[$value['card_id']]['card_id'] = $value['card_id'];
	// 	$list[$value['card_id']]['type'] = $cardPageList[$value['card_id']]["type"];
	// 	$list[$value['card_id']]['num'] = $cardPageList[$value['card_id']]["num"];
	// 	$list[$value['card_id']]['address'] = $cardPageList[$value['card_id']]["address"];
	// 	$list[$value['card_id']]['is_publisher'] = $cardPageList[$value['card_id']]["is_publisher"];
	// 	// 不同卡不同的属性
	// 	$list[$value['card_id']]['field'][$cidField[$value['c_id']]["val"]]['val'] = $value['val'];
	// 	$list[$value['card_id']]['field'][$cidField[$value['c_id']]["val"]]['describe'] = $cidField[$value['c_id']]["describe"];
	// }




include display("cardList");