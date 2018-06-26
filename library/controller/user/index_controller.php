<?php
class index_controller extends base_controller{

	public function index()
	{
		if(empty($_SESSION["admin"]))
		{
			header("location:?c=public&a=login");//空的话就返回登录页面
		exit;
		}

		$id = $_SESSION["admin"]["id"];

		$auth = D('')->table(array('RoleAdmin'=>'p','Access'=>'t','Auth'=>'y'))->field('y.id,y.name,y.pid,y.auth_c,y.auth_a,y.icon,y.is_show')->where("`p`.`admin_id`='$id' AND `p`.`role_id`=`t`.`role_id` AND `t`.`auth_id`=`y`.`id`")->order('`y`.`id` ASC')->select();

		$this->assign('auth',$auth);
		$this->display();
	}

	public function welcome()
	{
		$this->display();
	}

	public function orderList()
	{
		$this->display();
	}

	//退出登录
	public function logout()
	{
		unset($_SESSION["admin"]);
		header('refresh:1;url=user.php?c=public&a=login');
		die('正在退出....');
	}
}
