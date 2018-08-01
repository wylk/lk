<?php
class card_package_model extends base_model
{
	public function saveAll($data)
	{
		$where = "update lk_card_package set num = case id ";
		foreach($data as $key=>$value){
			$where .= " when ".$value['id']." then ".$value['num'];
			$ids[] = $value['id'];
		}
		$ids = "(".implode(",", $ids).")";
		$where .= " end where id in ". $ids;
		return $this->db->query($where);
	}
	public function setData($data,$where){
		$sql = "update lk_card_package set";
		foreach($data as $key=>$value){
			$sql .= "`".$value['field']."` = `".$value['field']."`".$value['operator'].$value['step'].",";
		}
		$sql = substr($sql, 0,-1);
		$sql .= " where ".$where[0]."=".$where[1];
		return $this->db->query($sql);
	}
	public function frozen($frozenList){
		foreach ($frozenList as $key => $value) {
			$case[$value['field']] .= " when ".$value['id']." then `".$value['field']."` ".$value['operator'].$value['step'];
			$ids[] = $value['id'];
		}
		foreach($case as $key=>$value){
			$where .= " `".$key."` = (case id ".$value." end),";
		}
		$ids = implode($ids,",");
		$where = substr($where, 0,-1);
		$sql = "update lk_card_package set ".$where." where id in (".$ids.")";
		return $this->db->query($sql);
	}

}