<?php
/*
	
 */

class lk_card_package_model extends base_model
{
	public function save($data,$where){
		if(empty($where)){
			return $this->db->data($data)->add();
		}else{
			return $this->db->data($data)->where($where)->save();
		}
	}
	public function select($where=''){
		return $this->db->where($where)->select();
	}
}