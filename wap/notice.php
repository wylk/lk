<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';
$data = json_decode(json_encode(simplexml_load_string(file_get_contents('php://input'), 'SimpleXMLElement', LIBXML_NOCDATA)), true);
 $file = LEKA_PATH.'/upload/log/order.txt';
file_put_contents($file,$data['order_id']);
$order  = D('Orders')->where(['id'=>$data['order_id']])->find();

//1减去交易单
D('Card_transaction')->where(array('id'=>$order['tran_id']))->setDec('frozen',$order['number']);
//2添加买家卡包金额/减卖家卡包金额
D('Card_package')->where(array('uid'=>$order['sole_id'],'card_id'=>$order['card_id']))->setDec('frozen',$order['number']);
D('Card_package')->where(array('uid'=>$order['buy_id'],'card_id'=>$order['card_id']))->setInc('num',$order['number']);
D('Orders')->data(['status'=>1])->where(array('id' =>$data['order_id']))->save();
//账本转账
// dump($order);
