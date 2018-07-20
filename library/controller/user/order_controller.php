<?php
//用户
class order_controller extends base_controller
{
    public function index(){
        import('user_page');

        $orders = D('Orders')->select();
        $page = new Page(count($orders),2);
        $order = D('Orders')->order('`id` DESC')->limit($page->firstRow, $page->listRows)->select();
        $this->assign('page', $page->show());
        $this->assign('order',$order);
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

