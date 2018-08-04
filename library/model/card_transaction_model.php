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
		return $this->db->query($sql);
	}

	public function frozen($frozenList){
		$where = "";
		foreach($frozenList as $key=>$value){
			$case[$value['field']] .= " when ".$value['id']." then `".$value['field']."` ".$value['operator'].$value['step'];
            $ids[] = $value['id'];
        }
        foreach($case as $key=>$value){
        	$where .= " `".$key."` = (case id ".$value." end ),";
        }
        $ids = "(".implode(",", $ids).")";
        $where = substr($where,0,-1);
        $sql = "update lk_card_transaction set ".$where." where id in ".$ids;
        // return $sql;
        return $this->db->query($sql);
        // return mysql_affected_rows($this->conn);
	}

}