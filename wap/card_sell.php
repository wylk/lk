<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 卖单挂单处理
if(IS_POST){
	$sellPrice = clear_html($_POST['price']);
	$frozen = $sellNum = clear_html($_POST['num']);
	$limitNum = clear_html($_POST['limitNum']);
	$id = clear_html($_POST['id']);
	// 判断售卖规则是否符合
	$platform = D("Card_package")->where(['id'=>$id])->find();
	$platform['num'] >= $sellNum ? true : dexit(['res'=>1,"msg"=>"售出数量不能超出现有数量"]);
	($sellPrice > 0 && $sellNum > 0 ) ? true : dexit(['res'=>1,"msg"=>"销售单价或者数量不能小于0"]);
	$sellNum >= $limitNum ? true : dexit(['res'=>1,"msg"=>"购买的限制最低数量不得大于购买量"]);

	// 自动匹配交易单并生成订单
	$matchingList = D("Card_transaction")->where(['uid'=>["not in",[$userId]],'price'=>$sellPrice,"limit"=>["<=",$sellNum],"type"=>1])->order("createtime asc")->select();
	if($matchingList){
		foreach ($matchingList as $key => $value) {
			$orderNum = 0;
			if($value['num'] >= $sellNum && $sellNum >= $value['limit']){
				$orderNum = $sellNum;
				$sellNum = 0;
			}
			if($value['num'] < $sellNum && $value['num'] >= $limitNum){
				$orderNum = $value['num'];
				$sellNum -= $value['num'];
			}
			if($orderNum == 0) continue;
			$matchOrderData[$key]['tran_id'] = $value['id'];
			$matchOrderData[$key]['card_id'] = $value['card_id'];
			$matchOrderData[$key]['sell_id'] = $userId;
			$matchOrderData[$key]['buy_id'] = $value['uid'];
			$matchOrderData[$key]['number'] = $orderNum;
			$matchOrderData[$key]['price'] = $sellPrice;
			$matchOrderData[$key]['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
			$matchOrderData[$key]["create_time"] = time();
			if($sellNum == 0) break;
		}
		$matchOrderNum = D("Orders")->data($matchOrderData)->addAll();
		if(!$matchOrderNum){
			dexit(['res'=>1,'msg'=>"自动匹配交易单出错"]);
		}
		if($sellNum == 0){
			dexit(['res'=>0,"msg"=>"已生成".$matchOrderNum."条订单，请查看"]);
		}
	}

	// 挂单添加到数据库
	
	$data['uid'] = $userId;
	$data['card_id'] = $platform['card_id'];
	$data['address'] = $platform['address'];
	$data['type'] = 2;
	$data['price'] = $sellPrice;
	$data['num'] = $sellNum;
	$data['limit'] = $limitNum;
	$data['createtime'] = time();
	$data['updatetime'] = time();
	$res = D("Card_transaction")->data($data)->add();
	$editData[] = ['field'=>'num',"step"=>$frozen,"operator"=>"-"];
	$editData[] = ['field'=>'frozen',"step"=>$frozen,"operator"=>"+"];
	$editRes = M("Card_package")->setData($editData,['id',$id]);
	if(!($res || $editRes)){
		dexit(['res'=>1,"msg"=>"挂单失败"]);
	}
	dexit(['res'=>0,"msg"=>"挂单成功"]);
}


$platformInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
// 卖单交易单
$buyList = D("Card_transaction")->where(['card_id'=>$platformInfo['card_id'],"type"=>1])->select();

include display('card_sell');
echo ob_get_clean();
