<?php
/*
  管理员管理
 */
class admin_controller extends base_controller
{
	public function __construct()
	{

	}
	//添加权限菜单
	public function auth()
	{
		if(IS_POST){
			$data = $this->clear_html($_POST);
			if(D('Auth')->data($data)->add()){
				$this->dexit(['error'=>0,'msg'=>'添加成功']);
			}else{
				$this->dexit(['error'=>1,'msg'=>'添加失败']);
			}
		}
		$auth = M('Auth')->findAll();
		$this->assign('auth',$auth);
		$this->display();
	}

}