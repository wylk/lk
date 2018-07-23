<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

if(IS_POST && $_POST['type'] == "confirmTran" ){
	$orderId = $_POST['orderId'];
	$orderInfo = D("Orders")->where(['id'=>$orderId])->find();
	$orderInfo['status'] == 0 ? true : dexit(['res'=>1,"msg"=>"订单失效"]);
	$sellInfo = D("Card_package")->where(['uid'=>$orderInfo['sell_id'],"card_id"=>$orderInfo['card_id']])->find();
	$buyInfo = D("Card_package")->where(['uid'=>$orderInfo['buy_id'],"card_id"=>$orderInfo['card_id']])->find();
	// 连接平台转账
	import('LkApi');
	$obj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
	$res = $obj->geth_api(['to'=>$buyInfo['user_address'],'from'=>'0xc889b85c44a3d97f4f67378d3ea720ee924f75b6','c'=>'Geth','a'=>'transaction']);
	$res['error'] == 0 ? true : dexit(['res'=>1,"msg"=>"平台连接错误"]);
	$tranRes = $obj->geth_api(['to'=>$buyInfo['user_address'],'from'=>$sellInfo['user_address'],'val'=>200,'c'=>'Contracts','a'=>'transfer_contract']);
	$tranRes['error'] == 0 ? true : dexit(['res'=>1,"msg"=>"转账错误"]);
	// 修改数据库平台币数值
	$sellRes = $obj->geth_api(['address'=>$sellInfo['user_address'],'c'=>'Contracts','a'=>'balance_contract']);
	$buyRes = $obj->geth_api(['address'=>$buyInfo['user_address'],'c'=>'Contracts','a'=>'balance_contract']);
	$data[] = ["id"=>$sellInfo['id'],"num"=>$sellRes['balance']];
	$data[] = ["id"=>$buyInfo['id'],"num"=>$buyRes['balance']];
	$balanceRes = M("Card_package")->saveAll($data);
	$statusRes = D("Orders")->data(['status'=>1])->where(['id'=>$orderId])->save();
	// dexit(['res'=>1,"msg"=>"测试","sell"=>$statusRes,"buy"=>$balanceRes]);
	if(!($balanceRes || $statusRes)){
		dexit(['res'=>1,"msg"=>"转账失败"]);
	}
	dexit(['res'=>0,"msg"=>"转账成功"]);
}


$orderId = $_GET['id'];
$orderInfo = D("Orders")->where(['id'=>$orderId])->find();

include display("card_orderDetail");