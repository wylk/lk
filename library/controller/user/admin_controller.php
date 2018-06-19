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
		$pids = D('Auth')->field('id,name')->where(['pid'=>0,'status'=>1])->select();

		$this->assign('pids',$pids);
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

    public function delAuth()
    {
    	$id = $this->clear_html($_GET['id']);
    	$count = D('Auth')->where(['pid'=>$id])->count('id');
    	if($count){
    		$this->dexit(['error'=>1,'msg'=>'该项还有子类不能删除']);
    	}
    	if(D('Auth')->where(['id'=>$id])->delete()){
    		$this->dexit(['error'=>0,'msg'=>'删除成功']);
    	}else{
    		$this->dexit(['error'=>1,'msg'=>'删除失败']);
    	}
    }

    public function authEdit()
    {
    	$pids = D('Auth')->field('id,name')->where(['pid'=>0,'status'=>1])->select();
		$auth = D('Auth')->where(['id'=>$_GET['id']])->find();
		$this->assign('auth',$auth);
		$this->assign('pids',$pids);
        if(IS_POST){
            $id = $_POST['id'];
            unset($_POST['id']);
            if(D('Auth')->data($_POST)->where(array('id' =>$id))->save()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            } else {
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }

    	$this->display();
    }

    //管理员列表
    public function index()
    {
        $admin = (D('Admin')->select());
        $this->assign('admin',$admin);

        // $name = [];
        // foreach($admin as $k=>$v){
        //     $id = $v['id'];
        //     $name[] = D('Admin')->table(array('RoleAdmin'=>'p','Role'=>'t'))->field('t.role_name')->where("`p`.`admin_id`='$id' AND `p`.`role_id`=`t`.`id`")->select();
        // }
        // dump($name);

        $RoleName = array_unique($RoleName);
        // dump($RoleName);
        $this->display();
    }

    //启用 禁用
    public function change()
    {
        $data = $this->clear_html($_GET);
        $data['status'] = $data['status'] ? 0 : 1;
        if(D('Admin')->data(['status'=>$data['status']])->where(array('id' =>$data['id']))->save()){
            $arr=['status'=>0,'msg'=>'修改成功'];
        }else{
            $arr=['status'=>1,'msg'=>'修改失败'];
        }
        $this->dexit($arr);
    }

    //后台用户修改
    public function edit()
    {
        if(IS_POST){
            $data = $this->clear_html($_POST);
            $id = $data['id'];
            $roleName = $data['role_name'];
            unset($data['id']);
            unset($data['role_name']);
            $admins = D('Admin')->data($data)->where(array('id' =>$id))->save();
            $roleAdmin = D('RoleAdmin')->data(['role_id'=>$roleName])->where(array('admin_id' =>$id))->save();
            if($admins && $roleAdmin){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                D('RoleAdmin')->data(['role_id'=>$roleName,'admin_id' =>$id])->add();
                $this->dexit(['error'=>1,'msg'=>'添加权限成功']);
            }
        }
        $res = D('Role')->select();
        $this->assign('res',$res);

        $roleId = D('RoleAdmin')->where(['admin_id'=>$_GET['id']])->find();
        $rid = $roleId['role_id'];
        $this->assign('rid',$rid);

        $admin = D('Admin')->where(['id'=>$_GET['id']])->find();
        $this->assign('admin',$admin);
        $this->display();
    }

    //后台用户删除
    public function delete()
    {
        $data = $this->clear_html($_POST);
        if(D('Admin')->where(array('id' =>$data['id']))->delete()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        } else {
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //角色管理
    public function role()
    {
        $role = D('Role')->select();
        $this->assign('role',$role);
        $this->display();
    }

    //删除角色
    public function delall()
    {
        $data = $this->clear_html($_POST);
        if(D('Role')->where(array('id'=>$data['id']))->delete()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //角色的启用 禁用
    public function startover()
    {
        $data = $this->clear_html($_GET);
        $data['status'] = $data['status'] ? 0 : 1;
        if(D('Role')->data(['status'=>$data['status']])->where(array('id' =>$data['id']))->save()){
            $arr=['status'=>0,'msg'=>'修改成功'];
        }else{
            $arr=['status'=>1,'msg'=>'修改失败'];
        }
        $this->dexit($arr);
    }

    //添加角色权限
    public function roleAdd()
    {
        if(IS_POST){
            $res = $this->clear_html($_POST);
            $auth_ids = empty($res['role_id']) ? [] : $res['role_id'];
            unset($res['role_id']);
            $res['created_at'] = time();
            $role = D('Role')->data($res)->add();
            $roleName = D('Role')->where(array('role_name' => $res['role_name']))->find();

            $auth_ids = substr($auth_ids, 0, -1);
            $auth_ids = explode(",", $auth_ids);

            $insertDatas = '';
            foreach($auth_ids as $v){
                $insertDatas = D('Access')->data(['role_id'=>$roleName['id'],'auth_id'=>$v])->add();
            }

            if($role && $insertDatas){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
            die;
        }
        $lk_auth = D('lk_auth')->select();
        $this->assign('lk_auth',$lk_auth);
        $this->display();
    }

    //修改角色权限
    public function roleEdit()
    {
        $data = $this->clear_html($_GET);
        $role = D('Role')->where(array('id' =>$data['id']))->find();
        $this->assign('role',$role);

        if(IS_POST){
            $res = $this->clear_html($_POST);
            $auth_ids = empty($res['role_id']) ? [] : $res['role_id'];

            $auth_ids = substr($auth_ids, 0, -1);
            $auth_ids = explode(",", $auth_ids);
            $role_ids = reset($auth_ids);
            $delect = (D('Access')->where(array('role_id' =>$role_ids))->delete());
            array_shift($auth_ids);
            $insertDatas = '';
            foreach($auth_ids as $v){
                $insertDatas = D('Access')->data(['role_id'=>$role_ids,'auth_id'=>$v])->add();
            }
            if($delect && $insertDatas){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
            die;
        }

        $lk_auth = D('lk_auth')->select();
        $this->assign('lk_auth',$lk_auth);

        $res = $this->clear_html($_POST);

        $roleId = $res['role_id'];
        $this->display();
    }
}
