<?php
/*
  管理员管理
 */
class admin_controller extends base_controller
{
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
    //删除菜单
    public function delAuth()
    {
    	$id = $this->clear_html($_GET['id']);
        dump($id);
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

    //修改菜单
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
        
        $role = M('Admin')->findAll();
        $this->assign('role',$role);
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
            $roleId = $data['role_name'];
            unset($data['id']);
            unset($data['role_name']);
            $admins = D('Admin')->data($data)->where(array('id' =>$id))->save();
            $roleAdmin = D('RoleAdmin')->data(['role_id'=>$roleId])->where(array('admin_id' =>$id))->save();
            if($roleAdmin){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                D('RoleAdmin')->data(['role_id'=>$roleId,'admin_id' =>$id])->add();
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
        $RoleAdmin = D('RoleAdmin')->where(array('admin_id' =>$data['id']))->delete();
        $Admin = D('Admin')->where(array('id' =>$data['id']))->delete();
        if($RoleAdmin && $Admin){
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
        $access = D('Access')->where(array('role_id'=>$data['id']))->delete();
        $role = D('Role')->where(array('id'=>$data['id']))->delete();
        if($access && $role){
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
            $posts = $this->clear_html($_POST);
            $arr = $posts['auth_id'];
            unset($posts['auth_id']);
            $arr = explode(',',$arr);
            array_shift($arr);
            $posts['created_at'] = time();
            $role = D('Role')->data($posts)->add();
            $roleName = D('Role')->where(array('role_name' => $posts['role_name']))->find();

            $insertDatas = '';
            foreach($arr as $v){
                $insertDatas = D('Access')->data(['role_id'=>$roleName['id'],'auth_id'=>$v])->add();
            }

            if($role && $insertDatas){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }

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
        $roleId = $role['id'];
        $this->assign('role',$role);
        // D('Role')->data(['role_name'=>])->where(array('id' =>$data['id']))->save();
        $arr = D('')->table(array('Access'=>'p','Auth'=>'op'))->field('op.name')->where("`p`.`role_id`='$roleId' AND `p`.`auth_id`=`op`.`id`")->order('`op`.`id` ASC')->select();
        $this->assign('arr',$arr);
        if(IS_POST){
            $res = $this->clear_html($_POST);
            $arr = $res['auth_id'];
            unset($res['auth_id']);
            $arr = explode(',',$arr);
            array_shift($arr);
            D('Role')->data(['role_name'=>$res['role_name']])->where(array('id' =>$res['ids']))->save();

            $delect = (D('Access')->where(array('role_id' =>$res['ids']))->delete());
            array_shift($auth_ids);
            $insertDatas = '';
            foreach($arr as $v){
                $insertDatas = D('Access')->data(['role_id'=>$res['ids'],'auth_id'=>$v])->add();
            }
            if($insertDatas){
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
