<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';
// $file = LEKA_PATH.'/upload/log/order.txt';
// $data['out_trade_no'] = "20181024144134619461";
// $payType = "platform";
// $userId = 9;
$payType = isset($_REQUEST['payType']) ? $_REQUEST['payType'] : 'weixin';

// 支付方式判断
$xml = file_get_contents('php://input');
if(!empty($xml)){
	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	$payType = "weixin";
	$data['out_trade_no'] = $array_data['out_trade_no'];
}else if($payType == 'platform'){
	$userId = $_REQUEST['userid'];
	$data['out_trade_no'] = $_REQUEST['out_trade_no'];
	
}else{
	// dexit(['errcode'=>2,'msg'=>"当前不支持".$payType."支付方式",'data'=>$payType]);
	pay_return(['res'=>"FAIL","msg"=>"当前不支持".$payType."支付方式","type"=>$payType]);

}

// $file = LEKA_PATH.'/upload/log/xml';
// file_put_contents($file,$xml);



$payData = $order  = D('Orders')->where(['out_trade_no'=>$data['out_trade_no']])->find();
if($order['status']){
	// dexit(['errcode'=>1,'msg'=>"订单已经支付"]);
	pay_return(['res'=>"FAIL","msg"=>"订单已经支付","type"=>$payType]);
}
// 转账处理
switch ($payType) {
	case 'platform':
		import("PlatformCurrency");
	    $platformObj = new PlatformCurrency(['userid'=>$userId]);
		$payRes = $platformObj->payTran($order['sell_id'],$order['buy_id'],$order['number']*$order['price'],$order['price']);
		if($payRes['res'])
			pay_return(['res'=>"FAIL","msg"=>"平台币转账失败","type"=>$payType]);
		break;
	case 'weixin':
		if($array_data['appid'] == option('config.platform_weixin_appid')){
			$pay_method['pay_weixin_appid'] = option('config.platform_weixin_appid');
			$pay_method['pay_weixin_mchid'] = option('config.platform_weixin_mchid');
			$pay_method['pay_weixin_key'] = option('config.platform_weixin_key');
		}
		$sign = $array_data['sign'];
		unset($array_data['sign']);
		$check = new weixin_pay($pay_method['pay_weixin_appid'],$pay_method['pay_weixin_mchid'],$pay_method['pay_weixin_key']);
		$checkSign = $check->getSign($array_data);
		if($checkSign != $sign){
			// dexit(['return_code'=>"FAIL","return_msg"=>"验签失败"]);
			pay_return(['res'=>"FAIL","msg"=>"验签失败","type"=>$payType]);
		}
		break;
	default:
		# code...
		break;
}

// if($payType == 'platform'){
// 	// 平台币转账
// 	import("PlatformCurrency");
//     $platformObj = new PlatformCurrency(['userid'=>$userId]);
// 	$payRes = $platformObj->payTran($order['sell_id'],$order['buy_id'],$order['number']*$order['price'],$order['price']);
// 	if($payRes['res']) dexit(['res'=>1,"msg"=>"平台币转账"]);
// }elseif ($array_data['trade_type'] == "JSAPI") {
// 	// 微信支付
// 	if($arraay_data['appid'] == option('config.platform_weixin_appid')){
// 		$pay_method['pay_weixin_appid'] = option('config.platform_weixin_appid');
// 		$pay_method['pay_weixin_mchid'] = option('config.platform_weixin_mchid');
// 		$pay_method['pay_weixin_key'] = option('config.platform_weixin_key');
// 	}
// 	// $this->getSign($data);
// }

$packageList = D("Card_package")->where(['uid'=>['in',[$order['sell_id'],$order['buy_id']]],"card_id"=>$order['card_id']])->select();
foreach ($packageList as $key => $value) {
	if($value['uid']==$order['sell_id']) $sendAddress = $value;
	if($value['uid']==$order['buy_id']) $getAddress = $value;
}


// 记录账单信息
import("AccountBook");
$Account_book = new AccountBook();
$bookJson = json_encode(['uid'=>$order['sell_id'],"contract_id"=>$order['card_id'],'sendAddress'=>$sendAddress['address'],"num"=>$order['number'],"getAddress"=>$getAddress['address']]);
$bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));
if(!$bookRes){
	// dexit(['errcode'=>1,'msg'=>"添加账本错误",'data'=>$bookRes]);
	pay_return(['res'=>"FAIL","msg"=>"添加账本错误","type"=>$payType]);
}

$payData['sendAddress'] = $sendAddress['address'];
$payData['getAddress'] = $getAddress['address'];
$payData['type'] = $sendAddress['type'];
import("CardAction");
$card = new CardAction(['userid'=>$userId]);
$payTranRes = $card->payTran($payData);
if($payTranRes['res']) pay_return(['res'=>"FAIL","msg"=>$payTranRes['msg'],"type"=>$payType]);

// //1减去交易单
// // D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('frozen',$order['number']);
// // D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('num',$order['number']);
// $data[] = ['id'=>$order['tran_id'],'field'=>'num','operator'=>'-','step'=>$order['number']];
// $data[] = ['id'=>$order['tran_id'],'field'=>'frozen','operator'=>'-','step'=>$order['number']];
// M('Card_transaction')->frozen($data);


// //2添加买家卡包金额/减卖家卡包金额
// D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setDec('frozen',$order['number']);
// D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setInc('sell_count',$order['number']);
// D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('num',$order['number']);
// D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('recovery_count',$order['number']);

// D('Orders')->data(['status'=>1])->where(array('out_trade_no' =>$data['out_trade_no']))->save();
// // 添加交易记录
// D("Record_books")->data(['card_id'=>$order['card_id'],"send_address"=>$sendAddress['address'],'get_address'=>$getAddress['address'],'num'=>$order['number'],"price"=>$order['price'],"type"=>$sendAddress['type'],'createtime'=>time()])->add();


// 判断商家交易单是否销售完
$judgeOver = D("Card_transaction")->where(['id'=>$order['tran_id']])->find();
if($judgeOver['num'] == '0'){
	D("Card_transaction")->where(['id'=>$order['tran_id']])->setField("status","1");
}
pay_return(['res'=>"SUCCESS","msg"=>"支付成功","type"=>$payType]);

function pay_return($data){
	file_put_contents(LEKA_PATH.'/upload/log/notice.txt', $data);
	if($data['type'] == 'weixin'){
		dexit(['return_code'=>$data['res'],"msg"=>$data['msg']]);
	}else{
		if($data['res'] == "SUCCESS"){
			dexit(['errcode'=>0,"msg"=>$data['msg']]);
		}else{
			dexit(['errcode'=>1,"msg"=>$data['msg']]);
		}
	}
}
