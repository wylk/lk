<?php
//用户
class hairpin_controller extends base_controller
{
    //发卡页面
    public function index()
    {
        // // 文件上传
        // if(isset($_GET['type']) && $_GET['type'] == "uploadFile"){
        //     if(!empty($_FILES) && $_FILES['file']['error'] == 0){
        //         $rand_num = 'images/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
        //         $upload_dir = $_SERVER['DOCUMENT_ROOT']."/upload/" . $rand_num;
        //         if (!file_exists($upload_dir)) {
        //             mkdir($upload_dir, 0777, true);
        //         }
        //         import("UploadFile");
        //         $upload = new UploadFile();
        //         $upload->maxSize = 1*1024*1024;
        //         $upload->allowExts = ['png','jpeg','jpg','gif'];
        //         $upload->allowTypes = ['image/png',"image/jpg","image/gif",'image/jpeg'];
        //         $upload->savePath = $upload_dir;
        //         $upload->saveRule = 'uniqid';
        //         $res = $upload->uploadOne($_FILES['file']);
        //         // $file = $file['name'];
        //         if(!$res){
        //             $error = $upload->getErrorMsg();
        //             dexit(['res'=>1,"msg"=>$error]);
        //         }
        //         // $uploadList = $upload->getUploadFileInfo();
        //         $path = getAttachmentUrl($rand_num.$res[0]['savename']);
        //         dexit(['res'=>0,"msg"=>$path]);
        //     }
        //     dexit(['res'=>1,"msg"=>"传送失败"]);
        // }
        dump($_POST);
        $this->display();
    }

    public function finance()
    {
        $this->display();
    }
}

