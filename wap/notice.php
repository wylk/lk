<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';
$data['order_id'] = $_REQUEST['order_id'];
// $data = json_decode(json_encode(simplexml_load_string(file_get_contents('php://input'), 'SimpleXMLElement', LIBXML_NOCDATA)), true);

$file = LEKA_PATH.'/upload/log/order.txt';
file_put_contents($file,$data['order_id']);

$order  = D('Orders')->where(['id'=>$data['order_id']])->find();
// dexit(['errcode'=>3,'msg'=>$data]);
$sendAddress = D('Card_package')->field('address')->where(['uid'=>$order['sell_id'],'card_id'=>$order['card_id']])->find();
$getAddress = D('Card_package')->field('address')->where(['uid'=>$order['buy_id'],'card_id'=>$order['card_id']])->find();
// 记录账单信息
import("AccountBook");
$Account_book = new AccountBook();
$bookJson = json_encode(['uid'=>$order['sell_id'],"contract_id"=>$order['card_id'],'sendAddress'=>$sendAddress['address'],"num"=>$order['number'],"getAddress"=>$getAddress['address']]);

$bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));

if(!$bookRes){
	// $payInfo['err_code'] = 1;
	dexit(['errcode'=>2,'msg'=>"添加账本错误",'data'=>$bookRes]);
}

//1减去交易单
D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('frozen',$order['number']);
D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('num',$order['number']);
//2添加买家卡包金额/减卖家卡包金额
D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setDec('frozen',$order['number']);
D('Card_package')->where(array('uid'=>$order['sell_id'],'card_id'=>$order['card_id']))->setInc('sell_count',$order['number']);
D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('num',$order['number']);
D('Orders')->data(['status'=>1])->where(array('id' =>$data['order_id']))->save();
// 添加交易记录
D("Record_books")->data(['card_id'=>$order['card_id'],"send_address"=>$sendAddress['address'],'get_address'=>$getAddress['address'],'num'=>$order['number'],'createtime'=>time()])->add();
// 判断商家交易单是否销售完
$judgeOver = D("Card_transaction")->where(['id'=>$order['tran_id']])->find();
if($judgeOver['num'] == '0'){
	D("Card_transaction")->where(['id'=>$order['tran_id']])->setField("status","1");
}
dexit(['res'=>0,"msg"=>"ok"]);


