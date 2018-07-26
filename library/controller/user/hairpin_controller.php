<?php
//用户
class hairpin_controller extends base_controller
{
    //平台币管理
    public function index()
    {
        $datas=[

        ];
        $this->assign('datas',$datas);
        $this->display();
    }

    public function deal()
    {
        $this->display();
    }

    //平台币交易
    public function orderList()
    {
        $this->display();
    }

    //平台币设置
    public function set()
    {
        echo 22;
    }
}

