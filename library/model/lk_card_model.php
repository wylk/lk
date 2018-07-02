<?php
/*
	
 */

class lk_card_model extends base_model
{
	public function save($data,$where){
		// var_dump($where);
		if(empty($where)){
			return $this->db->data($data)->add();
		}else{
			return $this->db->data($data)->where($where)->save();
		}
	}
	public function cardInfobyCardId($cardId){
		if(is_array($cardId)){
			if(count($cardId) != 1) $where['card_id'] = ['in',$cardId];
			else $where['card_id'] = $cardId[0];
		}else{
			$where['card_id'] = $cardId;
		}
		$cardList = $this->db->where($where)->select();
		foreach($cardList as $key=>$value){
			$cardListRes[$value['card_id']][$value['c_id']] = $value;
			$cIds[] = $value['c_id'];
		}
		// // 获取卡的合约信息 并整合到一个数组中
		$cIdInfo = $this->db->table("Contract_field")->where(["id"=>['in',$cIds]])->select();
		// foreach($cardIds as $key=>$value){
		// 	$cardListRes[$value][$value['id']]['field'] = $value['val'];
		// 	$cardListRes[$value['id']]['describe'] = $value['describe'];
		// }
		// var_dump($cardListRes);
		// var_dump($cIdInfo);exit();
		return Array($cardListRes,$cIdInfo);
	}
}