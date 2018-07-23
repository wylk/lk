<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
if(IS_POST){
	$buyPrice = clear_html($_POST['buyPrice']);
	$buyNum = clear_html($_POST['buyNum']);
	$limitNum = clear_html($_POST['limitNum']);
	$id = clear_html($_POST['id']);
	// 判断购买规则是否符合
	($buyNum > 0 && $buyPrice > 0) ? true : dexit(['res'=>1,"msg"=>"购买价格或者数量不能为0"]);
	$buyNum >= $limitNum ? true : dexit(['res'=>1,"msg"=>"购买的限制最低数量不得大于购买量"]);

	// 自动检测交易单生成订单
	$matchingList = D("Card_transaction")->where(['uid'=>["not in",[$userId]],'price'=>$buyPrice,"limit"=>["<=",$buyNum],"type"=>2])->order("createtime asc")->select();
	if($matchingList){
		foreach($matchingList as $key=>$value){
			$orderNum = 0;
			if($value['num'] >= $buyNum && $buyNum >= $value['limit']){
				$orderNum = $buyNum;
				$buyNum = 0;
			}
			if($value['num'] < $buyNum && $value['num'] >= $limitNum){
				$orderNum = $value['num'];
				$buyNum -= $value['num'];
			}
			if($orderNum == 0) continue;
			$matchOrderData[$key]['tran_id'] = $value['id'];
			$matchOrderData[$key]['card_id'] = $value['card_id'];
			$matchOrderData[$key]['sell_id'] = $value['uid'];
			$matchOrderData[$key]['buy_id'] = $userId;
			$matchOrderData[$key]['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
			$matchOrderData[$key]['number'] = $orderNum;
			$matchOrderData[$key]['price'] = $buyPrice;
			$matchOrderData[$key]['create_time'] = time();
			if($buyNum == 0) break;
		}
		$matchOrderNum = D('Orders')->data($matchOrderData)->addAll();
		if(!$matchOrderNum){
			dexit(['res'=>1,"msg"=>"自动生成订单出错"]);
		}
		if($buyNum == 0){
			dexit(['res'=>0,"msg"=>"已生成".$matchOrderNum."条订单，请查看"]);
		}
	}

	// 挂单到数据库
	$platform = D("Card_package")->where(['id'=>$id])->find();
	$tranData['uid'] = $userId;
	$tranData['card_id'] = $platform['card_id'] ;
	$tranData['address'] = $platform['address'] ;
	$tranData['type'] = 1;
	$tranData['num'] = $buyNum;
	$tranData['limit'] = $limitNum;
	$tranData['price'] = $buyPrice;
	$tranData['createtime'] = time();
	$tranData['updatetime'] = time();
	$res = D("Card_transaction")->data($tranData)->add();
	if(!$res){
		dexit(['res'=>1,"msg"=>"挂单失败"]);
	}
	dexit(['res'=>0,"msg"=>"挂单成功"]);
}
// 查找当前用户卡包信息
$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
// 查询当前卖单信息
$sellList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>"2"])->select();

include display('card_buy');
echo ob_get_clean();
