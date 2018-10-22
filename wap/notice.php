<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';
// $file = LEKA_PATH.'/upload/log/order.txt';
$payType = isset($_REQUEST['payType']) ? $_REQUEST['payType'] : 'weixin';

// 支付方式判断
$xml = file_get_contents('php://input');
if(!empty($xml)){
	$data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}else if($payType == 'platform'){
	$userId = $_REQUEST['userid'];
	$data['out_trade_no'] = $_REQUEST['out_trade_no'];
	
}else{
	dexit(['errcode'=>2,'msg'=>"当前不支持".$payType."支付方式",'data'=>$payType]);

}

$file = LEKA_PATH.'/upload/log/xml';
file_put_contents($file,$xml);



$order  = D('Orders')->where(['out_trade_no'=>$data['out_trade_no']])->find();

if($order['status']){
	dexit(['errcode'=>1,'msg'=>"订单已经支付"]);
}
// 转账处理

if($payType == 'platform'){
	// 平台币转账
	import("PlatformCurrency");
    $platformObj = new PlatformCurrency(['userid'=>$userId]);
	$payRes = $platformObj->payTran($order['sell_id'],$order['buy_id'],$order['number']*$order['price'],$order['price']);
	if($payRes['res']) dexit(['res'=>1,"msg"=>"平台币转账"]);
}

// dexit(['errcode'=>3,'msg'=>$data]);
$sendAddress = D('Card_package')->field('address')->where(['uid'=>$order['sell_id'],'card_id'=>$order['card_id']])->find();
$getAddress = D('Card_package')->field('address,is_publisher,bail')->where(['uid'=>$order['buy_id'],'card_id'=>$order['card_id']])->find();
// 记录账单信息
import("AccountBook");
$Account_book = new AccountBook();
$bookJson = json_encode(['uid'=>$order['sell_id'],"contract_id"=>$order['card_id'],'sendAddress'=>$sendAddress['address'],"num"=>$order['number'],"getAddress"=>$getAddress['address']]);
$bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));
if(!$bookRes){
	// $payInfo['err_code'] = 1;
	dexit(['errcode'=>1,'msg'=>"添加账本错误",'data'=>$bookRes]);
}

//1减去交易单
// D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('frozen',$order['number']);
// D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('num',$order['number']);
$data[] = ['id'=>$order['tran_id'],'field'=>'num','operator'=>'-','step'=>$order['number']];
$data[] = ['id'=>$order['tran_id'],'field'=>'frozen','operator'=>'-','step'=>$order['number']];
M('Card_transaction')->frozen($data);

//2添加买家卡包金额/减卖家卡包金额
D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setDec('frozen',$order['number']);
D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setInc('sell_count',$order['number']);
D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('num',$order['number']);
D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('recovery_count',$order['number']);

D('Orders')->data(['status'=>1])->where(array('out_trade_no' =>$data['out_trade_no']))->save();
// 添加交易记录
D("Record_books")->data(['card_id'=>$order['card_id'],"send_address"=>$sendAddress['address'],'get_address'=>$getAddress['address'],'num'=>$order['number'],"price"=>$order['price'],"type"=>$sendAddress['type'],'createtime'=>time()])->add();
// 判断商家交易单是否销售完
$judgeOver = D("Card_transaction")->where(['id'=>$order['tran_id']])->find();
if($judgeOver['num'] == '0'){
	D("Card_transaction")->where(['id'=>$order['tran_id']])->setField("status","1");
}
dexit(['res'=>0,"msg"=>"ok"]);


