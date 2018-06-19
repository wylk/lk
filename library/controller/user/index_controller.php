<?php
class index_controller extends base_controller{

	public function index()
	{
		$auth = (D('Auth')->select());
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
}
