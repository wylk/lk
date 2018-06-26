<?php
//用户
class order_controller extends base_controller
{
    public function index(){
        // $user = D('User')->select();
        // $this->assign('user',$user);
        $this->display();
    }

    //添加页面
    public function add()
    {
        $this->display();
    }

    //显示页面
    public function edit()
    {
        $this->display();
    }

    //启用 禁用
    public function change()
    {
    }

    //删除
    public function delete()
    {
    }
}

