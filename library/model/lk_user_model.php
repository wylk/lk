<?php
/*
	用户表查询
 */

class lk_user_model extends base_model
{
	public function findField($field="",$where = '')
	{ 
		$findRes = $this->db->field($field)->where($where)->select();
		// $res = $this->db->fetch_array($findRes);
		// return array_values($findRes);
		return $findRes;
	}
	public function update($field,$value,$where){
		return $this->db->where($where)->setField($field,$value);
	}
	public function insert($data){
		return $this->db->data($data)->add();
	}
	public function insert1($data){
		// $sql = "insert into lk_user (ph/ne,upwd)"
		return $this->db->query($sql);
	}
}