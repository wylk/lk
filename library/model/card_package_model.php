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

}