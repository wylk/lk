<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$user = D('User')->where(['id'=>$wap_user['userid']])->find();
$verifyLen = "6";  //验证码长度
$tex=$_GET['type'];

// //验证码
//   if(isset($_POST['type']) && $_POST['type'] == "code"){
//             import("transfer");
//             $a = new Transfer();
//             $getPhone = $_POST['phone'];
//             $code = rangdNumber($verifyLen);
//             $result = $a->message($getPhone,array("code"=>$code));
//             $_SESSION['code'] = $code;
//             dexit(['result'=>$result,'code'=>$code]);
//         }
// 文件上传
if(isset($_GET['type']) && $_GET['type'] == "uploadFile"){
    if(!empty($_FILES) && $_FILES['file']['error'] == 0){
        $rand_num = 'images/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
        $upload_dir = $_SERVER['DOCUMENT_ROOT']."/upload/" . $rand_num;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        import("UploadFile");
        $upload = new UploadFile();
        $upload->maxSize = 1024*1024*1024;
        $upload->allowExts = ['png','jpeg','jpg','gif'];
        $upload->allowTypes = ['image/png',"image/jpg","image/gif",'image/jpeg'];
        $upload->savePath = $upload_dir;
        $upload->saveRule = 'uniqid';
        $res = $upload->uploadOne($_FILES['file']);
        // $file = $file['name'];
        if(!$res){
            $error = $upload->getErrorMsg();
            dexit(['res'=>1,"msg"=>$error]);
        }
        // $uploadList = $upload->getUploadFileInfo();
        $path = getAttachmentUrl($rand_num.$res[0]['savename']);
        $_SESSION['path'] = $path;
        dexit(['res'=>0,"msg"=>$path]);
    }
    dexit(['res'=>1,"msg"=>"传送失败"]);
}

if(IS_POST){
   $res=$_POST;
   $pwd=md5($res['password']);
   file_put_contents("./111", $user['pay_password']."---".$wap_user['userid']);
   if($pwd != $user['pay_password']){
        dexit(["res"=>2,'msg'=>"支付密码输入错误"]);
    }
    if($res['pwd'] == $_SESSION['code'] && $pwd == $user['pay_password']){
        $uid=D('Pay')->where(array('uid'=>$user['id']))->find();
        $data['pay_num']=$res['pay_num'];
        $data['uid']=$user['id'];
        $data['pay_img'] = $_SESSION['path'];
        if(empty($uid)){
            $rag=D('Pay')->data($data)->add();
             if($rag){
                 dexit(["res"=>0,'msg'=>"支付宝设置完成"]);
             }else{
                 dexit(["res"=>3,'msg'=>"支付宝设置失败"]);
             }
         }else{
            $rag=D('Pay')->data($data)->where(array('uid'=>$uid['uid']))->save();
             if($rag){
                 dexit(["res"=>0,'msg'=>"支付宝设置完成"]);
             }else{
                 dexit(["res"=>3,'msg'=>"支付宝设置失败"]);
             }
         }
    }


}

include display('pay_qx');




