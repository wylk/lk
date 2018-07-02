<?php
/*
	用户身份信息
 */

class lk_user_audit_model extends base_model
{
	public function save($data,$where){
		if(empty($where['uid'])){
			return $this->db->data($data)->add();
		}else{
			return $this->db->data($data)->where($where)->save();
		}
	}
	public function select($where){
		return $this->db->where($where)->select();
	}
}