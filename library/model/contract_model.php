<?php
class contract_model extends base_model
{
	public function add($data)
	{
		return $this->db->data($data)->add();
	}

	public function find($where = '' )
	{
		return $this->db->where($where)->order('`sort` asc')->select();
	}

}