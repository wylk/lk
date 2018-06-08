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
		$pid = D('Auth')->field('id,name')->where(['pid'=>0,'status'=>1])->select();
		dump($pid);
		$this->assign('auth',$this->getTree($auth,0,0));
		$this->display();
	}

	public function getTree($arr,$pid,$step)
	{
        global $tree;
        foreach($arr as $key=>$val) {
            if($val['pid'] == $pid) {
                $flg = str_repeat('└―',$step);
                $val['name'] = $flg.$val['name'];
                $tree[] = $val;
                $this->getTree($arr , $val['id'] ,$step+1);
            }
        }
        return $tree;
    }

}