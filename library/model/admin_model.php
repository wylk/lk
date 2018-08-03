<?php
/*
	管理员
 */
class admin_model extends base_model
{
	public function findAll($where = '')
	{
		return $this->db->table("Admin as a")
						->join('Roleadmin as b ON a.id=b.admin_id','LEFT')
						->join('Role as c ON b.role_id=c.id','LEFT')
						->where($where)
						->field("a.*,c.role_name")
						->order('`a`.`id` ASC')
						->select();
	}
}