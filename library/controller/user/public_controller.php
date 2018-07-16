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

    //ajax图片上传
    public function uploadFile()
    {
        if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
            $img_id = sprintf("%09d",1);
            $rand_num = 'images/'.substr($img_id,0,3).'/'.substr($img_id,3,3).'/'.substr($img_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
            $upload_dir = './upload/' . $rand_num;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            import('UploadFile');
            $upload = new UploadFile();
            $upload->maxSize = 1*1024*1024;
            $upload->allowExts = array('jpg','jpeg','png','gif');
            $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
            $upload->savePath = $upload_dir;
            $upload->saveRule = 'uniqid';
            if($upload->upload()){
                $uploadList = $upload->getUploadFileInfo();
                $this->dexit(['error'=>0,'msg'=>getAttachmentUrl($rand_num.$uploadList[0]['savename'])]);
            }else{
                $this->dexit(['error'=>1,'msg'=>$upload->getErrorMsg()]);
            }
        }
    }

    //
    public function delFile()
    {
        if(isset($_POST['url'])){
            $_POST['url'] = '.'.substr($_POST['url'],strrpos($_POST['url'],'/upload'));
            if(isset($_POST['url'])){
                if(file_exists($_POST['url'])){
                    unlink($_POST['url']);
                }
            }
        }

    }
}

