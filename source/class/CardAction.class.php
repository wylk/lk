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
	public function revokeTran(){}
}