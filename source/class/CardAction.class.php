<?php
class CardAction{
	public $userId;
	public $cardData;
	public function __construct($data){
		$this->userId = $data['userid'];
	}
	public function tran(){}
	// 卡券出售挂单   测试完成
	// ['cardId'=>'',"num"=>'',"price"=>'',"limit"=>''];
	public function sellCard($data){
		$cardBagInfo = D("Card_package")->field("num,address,is_publisher,frozen")->where(['uid'=>$this->userId,'card_id'=>$data['cardId']])->find();
		if(!$cardBagInfo) return ['res'=>1,"msg"=>"该卡券失效"];
		// $cardBagInfo['is_publisher'] == 1 ? true : dexit(["res"=>1,'msg'=>"不是本人发布"]);
		if($cardBagInfo['num'] - $num < 0) return ['res'=>1,"发布额度超出现有额度"];

		// 判断发布的数值超出
		$tranData['card_id'] = $data['cardId'];
		$tranData['num'] = $data['num'];
		$tranData['price'] = $data['price'];
		$tranData['limit'] = $data['limit'];
		$tranData['address'] = $cardBagInfo['address'];
		$tranData['status'] = '0';
		$tranData['uid'] = $this->userId;
		$tranData['createtime'] = time();
		$tranData['updatetime'] = time();
		// 判断是否添加交易成功
		$tranId = D("Card_transaction")->data($tranData)->add();
		if($tranId){
			$editList[] = ['id'=>['field'=>"uid","val"=>$this->userId],"field"=>"frozen","operator"=>"+","step"=>$data['num']];
			$editList[] = ['id'=>['field'=>"uid","val"=>$this->userId],"field"=>"num","operator"=>"-","step"=>$data['num']];
			$addition[] = ['field'=>"card_id","val"=>$data['cardId'],"operator"=>'='];
			$res = M("Card_package")->dataModification($editList,$addition);
			if($res) return ['res'=>0,"msg"=>"卡券发布成功","data"=>['res'=>$res,"tranId"=>$tranId]];
			return ['res'=>1,"msg"=>"数据冻结失败",'data'=>['res'=>$res]];
		}
		return ['res'=>1,"msg"=>"卡券发布失败"];
	}
	public function buyCard(){

	}
	// 挂单撤销
	// ['revokeId','revokeCardId',,,,];
	public function revokeTran($data){
		// 判断是否有订单未处理
		$checkRes = D("Orders")->where("(tran_id = ".$data['revokeId']." or tran_other = ".$data['revokeId'].") and status = 0")->sum("number");
		if($checkRes) return ['res'=>1,"msg"=>"还有".$checkRes."订单未处理"];

		$revokeInfo = D("Card_transaction")->where(['id'=>$data['revokeId']])->find();
		if($revokeInfo['status']) return ['res'=>1,"msg"=>"此订单已失效"];

		$res = D("Card_transaction")->data(['status'=>2,"updatetime"=>time()])->where(['id'=>$data['revokeId']])->save();
		if(!$res) return ['res'=>1,"msg"=>"订单撤销失败"];

		$revokeNum = $revokeInfo['num'] - $revokeInfo['frozen'];
		$editList[] = ['id'=>['field'=>"uid","val"=>$this->userId],"field"=>"num","operator"=>"+","step"=>$revokeNum];
		$editList[] = ['id'=>['field'=>"uid","val"=>$this->userId],"field"=>"frozen","operator"=>"-","step"=>$revokeNum];
		$addition[] = ['field'=>"card_id","val"=>$data['revokeCardId'],"operator"=>"="];
		$editRes = M("Card_package")->dataModification($editList,$addition);

		if(!$editRes) return ['res'=>1,"msg"=>"数据解冻失败"];
		return ['res'=>0,"msg"=>"订单撤销成功"];
	}
	// 根据地址转账
	public function addressTran($data){
		$num = $data['num'];
		$type = $data['type'];
		$cardId = $data['cardId'];
		$sendAddress = $data['sendAddress'];
		$getAddress = $data['getAddress'];
		// 添加交易记录
		$recodRes = D("Record_books")->data(['card_id'=>$cardId,'send_address'=>$sendAddress,'get_address'=>$getAddress,'num'=>$num,"type"=>$type,"createtime"=>time()])->add();
		if(!$recodRes)
			return ['res'=>1,"msg"=>"记录添加失败","other"=>$recodRes];

		// 卡包数据处理
		$editList[] = ['id'=>['field'=>"address","val"=>$sendAddress],"operator"=>"-","field"=>"num","step"=>$num];
		$editList[] = ['id'=>['field'=>"address","val"=>$sendAddress],"operator"=>"+","field"=>"sell_count","step"=>$num];
		$editList[] = ['id'=>['field'=>"address","val"=>$getAddress],"operator"=>"+","field"=>"num","step"=>$num];
		$editList[] = ['id'=>['field'=>"address","val"=>$getAddress],"operator"=>"+","field"=>"recovery_count","step"=>$num];
		$editRes = M("Card_package")->dataModification($editList);
		if($editRes>0) return ['res'=>0,"msg"=>"转账成功"];
		return ['res'=>1,"msg"=>"转账失败！"];
	}
	// 根据付款转账
	public function payTran($data){
		//2添加买家卡包金额/减卖家卡包金额
		$addition[] = ['field'=>"card_id","operator"=>'=',"val"=>$data['card_id']];
		$sellList[] = ['id'=>['val'=>$data['sell_id'],"field"=>"uid"],"field"=>"frozen","operator"=>"-","step"=>$data['number']];
		$sellList[] = ['id'=>['val'=>$data['sell_id'],"field"=>"uid"],"field"=>"sell_count","operator"=>"+","step"=>$data['number']];
		$sellRes = M("Card_package")->dataModification($sellList,$addition);

		$buyList[] = ['id'=>['val'=>$data['buy_id'],"field"=>"uid"],"field"=>"num","operator"=>"+","step"=>$data['number']];
		$buyList[] = ['id'=>['val'=>$data['buy_id'],"field"=>"uid"],"field"=>"recovery_count","operator"=>"+","step"=>$data['number']];
		$buyRes = M("Card_package")->dataModification($buyList,$addition);
		if($sellRes <= 0 || $buyRes <= 0) return ['res'=>1,'msg'=>"转账数据修改错误"];

		$res = D('Orders')->data(['status'=>1,"pay_type"=>$data['pay_type']])->where(['out_trade_no' =>$data['out_trade_no']])->save();
		if(!$res) return ['res'=>1,"msg"=>"订单状态修改失败"];

		// 添加交易记录
		$recordRes = D("Record_books")->data(['card_id'=>$data['card_id'],"send_address"=>$data['sendAddress'],'get_address'=>$data['getAddress'],'num'=>$data['number'],"price"=>$data['price'],"type"=>$data['type'],'createtime'=>time()])->add();
		if(!$recordRes) return ['res'=>1,"msg"=>"添加交易记录失败"];

		return ['res'=>0,"msg"=>"转账成功"];
	}
}
