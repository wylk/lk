<?php
// 用户订单类
class lk_bill_model extends base_model{
	public function insert($data){
		return $this->db->data($data)->add();
	}
	// public function select($field,$data=[]){
	// 	$this->db->where($data)->select();
	// }
	public function findField($field='',$where=''){
		return $this->db->field($field)->where($where)->select();
	}

}