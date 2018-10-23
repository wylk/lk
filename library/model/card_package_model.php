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
			$case[$value['field']] .= " when ".$value['id']." then ";
			if($value['operator'] == '=')
				$case[$value['field']] .= $value['step'];
			else
				$case[$value['field']] .= "`".$value['field']."` ".$value['operator'].$value['step'];
			$ids[] = $value['id'];
		}
		foreach($case as $key=>$value){
			$where .= " `".$key."` = (case id ".$value." end),";
		}
		$ids = implode($ids,",");
		$where = substr($where, 0,-1);
		$sql = "update lk_card_package set ".$where." where id in (".$ids.")";
		// dump($sql);
		return $this->db->query($sql);
		// $a = $this->db->query($sql);
		// return [$a,$sql];
	}
	// $data[] = ['id'=>161,"operator"=>'+',"field"=>'frozen',"step"=>2];
	// $data[] = ['id'=>['field'=>'uid','val'=>'6'],'operator'=>'-',"field"=>'num',"step"=>2.0202];
	// $data[] = ['id'=>['field'=>'uid','val'=>'7'],"operator"=>'-',"field"=>'num',"step"=>2.0202];
	// $data[] = ['id'=>163,"operator"=>'+',"field"=>'frozen',"step"=>2];
	// $additional[] = ["field"=>'type',"operator"=>'=',"val"=>'leka'];
	public function dataModification($data,$additional=null){
		foreach ($data as $key => $value) {
			if(is_array($value['id'])){
				$case[$value['field']] .= " when ".$value['id']['val']." then ";
				$field[$value['field']] = $value['id']['field'];
				$fieldIds[$value['id']['field']][] = $value['id']['val'];
			}else{
				$case[$value['field']] .= " when ".$value['id']." then ";
				// $ids[] = $value['id'];
				$field[$value['field']] = 'id';
				$fieldIds['id'][] = $value['id'];
			}
			if($value['operator'] == '=')
				$case[$value['field']] .= $value['step'];
			else
				$case[$value['field']] .= "`".$value['field']."` ".$value['operator'].$value['step'];
		}
		foreach($case as $key=>$value){
				$update .= " `".$key."` = (case ".$field[$key].$value." end),";
		}
		$update = substr($update, 0,-1);
		$sql = "update lk_card_package set ".$update." where ";
		foreach ($fieldIds as $key => $value) {
			$where .= $key." in (".implode($value, ',').") or ";
		}
		$sql .= substr($where, 0,-3);
		if(!empty($additional)){
			foreach ($additional as $key => $value) {
				$sql .= " and ".$value['field'].$value['operator']." '".$value['val']."'";
			}
		}
		return $this->db->execute($sql);
			// return [$a,$sql];
		// return $sql;
	}

}