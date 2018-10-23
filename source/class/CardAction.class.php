<?php
class CardAction{
	public $userId;
	public $cardData;
	public function __construct($data){
		$this->userId = $data['userid'];
	}
	public function tran(){}
	// 卡券出售挂单   测试完成
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
	public function buyCard(){}
	// 挂单撤销
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
}