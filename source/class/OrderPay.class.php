<?php
class OrderPay{
	public $userId;
	public function pay(){

	}
	// 平台币付钱
	public function platform($order){
		import("PlatformCurrency");
	    $platformObj = new PlatformCurrency(['userid'=>$this->userId]);
		$payRes = $platformObj->payTran($order['sell_id'],$order['buy_id'],$order['number']*$order['price'],$order['price']);
		if($payRes['res'])
			pay_return(['res'=>"FAIL","msg"=>"平台币转账失败","type"=>$payType]);
	}
	// 微信或平台币付钱之后，卡券订单处理
	public function payTran($order){
		$payData = $order;

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
		if(!$bookRes)
			$this->pay_return(['res'=>"FAIL","msg"=>"添加账本错误","type"=>$payType]);

		$payData['sendAddress'] = $sendAddress['address'];
		$payData['getAddress'] = $getAddress['address'];
		$payData['type'] = $sendAddress['type'];
		import("CardAction");
		$card = new CardAction();
		$payTranRes = $card->payTran($payData);
		if($payTranRes['res']) $this->pay_return(['res'=>"FAIL","msg"=>$payTranRes['msg'],"type"=>$payType]);


		// 判断商家交易单是否销售完
		$judgeOver = D("Card_transaction")->where(['id'=>$order['tran_id']])->find();
		if($judgeOver['num'] == '0'){
			D("Card_transaction")->where(['id'=>$order['tran_id']])->setField("status","1");
		}
		$this->pay_return(['res'=>"SUCCESS","msg"=>"支付成功","type"=>$payType]);

	}
	public function pay_return($data){
		if($data['type'] == 'weixin'){
			return ['return_code'=>$data['res'],"msg"=>$data['msg']];
		}else{
			if($data['res'] == "SUCCESS"){
				return ['errcode'=>0,"msg"=>$data['msg']];
			}else{
				return ['errcode'=>1,"msg"=>$data['msg']];
			}
		}
	}
}