<?php
/*
	系统配置设置
 */
class auth_model extends base_model
{
	public function findAll($where = '')
	{
		return $this->db->where($where)->select();

	}
}