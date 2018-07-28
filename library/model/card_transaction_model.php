<?php
class card_transaction_model extends base_model
{
	public function saveAll($tranList,$frozenList)
	{
		$where = "update lk_card_transaction set frozen = case id ";
		foreach($tranList as $key=>$value){
			$frozenList[$value['id']] = $value['frozen']-$frozenList[$value['id']];
			$where .= " when ".$value['id']." then ".$frozenList[$value['id']];
			$ids[] = $value['id'];
		}
		$ids = "(".implode(",", $ids).")";
		$where .= " end where id in ". $ids;
		return $this->db->query($where);
	}

	public function setData($data){
		$sql = "update lk_card_transaction set frozen = case id ";
		foreach($data as $key=>$value){
			$value['frozen'] = $value['frozen'].$value['operator'].$value['step'];
			$sql .= " when ".$value['id']." then ".$value['frozen'];
			$ids[] = $value['id'];
		}
		$ids = "(".implode(",", $ids).")";
		$sql .= ' end where id in '.$ids;
		// return $sql;
		return $this->db->query($sql);
	}

}