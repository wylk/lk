<?php

//登录

class public_controller extends controller
{
    public function login()
    {
        if(IS_POST){
            $postData = $this->clear_html($_POST);
            if (md5($postData['code'])!=($_SESSION ['verify'])) {
                $this->dexit(['status'=>1,'msg'=>'验证码错误']);
            }
            //判断账号和密码
            $user = D('Admin')->where(array('name' =>$postData['name']))->find();
            if(!$user){
                $this->dexit(['status'=>1,'msg'=>'用户名不存在']);
            }
            if(md5($postData['upwd']) != $user['upwd']){
                $this->dexit(['status'=>1,'msg'=>'密码错误']);
            }
            if($user['status']==1){
                $this->dexit(['status'=>1,'msg'=>'该用户为禁用状态']);
            }else{
                $_SESSION['admin'] = $user;
                $this->dexit(['status'=>0,'msg'=>'登录成功']);
            }
        }
        $this->display();
    }

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

