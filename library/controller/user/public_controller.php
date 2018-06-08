<?php

//登录

class public_controller extends controller
{
    public function login()
    {
        if(IS_POST){
            $uname = $_POST['name'];
            $upwd = md5($_POST['upwd']);

            if (md5($_POST['code'])!=($_SESSION ['verify'])) {

            }
            //判断账号和密码
            $user = D('Admin')->where(array('name' =>$name))->where(array('upwd' =>$upwd))->find();
            if($user){
                $arr=['status'=>0,'msg'=>'登录成功'];
            }else{
                $arr=['msg'=>'登录失败'];
            }
            $this->dexit($arr);
        }
        $this->display();
    }

    // public function verifyName()
    // {
    //     $name = $this->clear_html($_GET['name']);
    //     $admin = D('Admin')->where(['name' =>$name])->find();
    //     if($admin){
    //         $this->dexit(['error'=>0,'msg'=>'用户存在']);
    //     }else{
    //         $this->dexit(['error'=>1,'msg'=>'用户不存在']);
    //     }
    // }


    //生成验证码
    public function code()
    {
        import ( 'source.class.Image' );
        Image::buildImageVerify();
    }

    //登录处理
    public function doLogin()
    {

    }
}

