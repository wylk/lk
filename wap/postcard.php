<?php
require_once dirname(__FILE__).'/global.php';
// require_once dirname(__FILE__).'/func.php';
$verifyLen = "6";  //验证码长度
// $userId = 11;

// 判断是否登录状态中
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['logintime']<3600){
	// var_dump(time()-$_SESSION['loginsign']['lasttime']);
	$_SESSION['loginsign']['logintime'] = time();
	$phone = isset($_SESSION['loginsign']['phone']) ? $_SESSION['loginsign']['phone'] : "";
	$userId = isset($_SESSION['loginsign']['userid']) ? $_SESSION['loginsign']['userid'] : "";
	if(empty($phone) || empty($userId)){
		header("location:login.php");
	}
}else{
	header("location:login.php");
	exit();
}

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
		$upload->maxSize = 1*1024*1024;
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
		dexit(['res'=>0,"msg"=>$path]);
	}
	dexit(['res'=>1,"msg"=>"传送失败"]);
}
// exit();

// // 用户认证信息修改
// if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'postcardEdit'){
// 	// 获取用户信息
// 	$uid = isset($_SESSION['loginsign']['uid']) ? $_SESSION['loginsign']['uid'] : "";
// 	if(empty($uid)){
// 		$userInfo = M('lk_user')->findField("id,phone","phone=".$phone);
// 		$uid = transformArray($userInfo,"id");
// 	}
// 	$where['uid'] = $uid;
// 	$postcardInfo = M("lk_user_audit")->select($where);
// 	$postcardInfo = transformArray($postcardInfo);
	
// 	include display("postcard");
// 	exit();
// }
//身份证认证信息处理
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "postcardBackstage"){
	$type = isset($_POST['type']) ? $_POST['type'] : "";
	$status = isset($_POST['status']) ? $_POST['status'] : "";
	// $data['type'] = $type;
	$data['name'] = isset($_POST['name']) ? $_POST['name'] : "";
	// 个人认证
	if($type == '1'){
		$data['postcards'] = isset($_POST['postcard']) ? $_POST['postcard'] : "";
		$data['img_just'] = isset($_POST['uploadImg_1']) ? $_POST['uploadImg_1'] : "";
		$data['img_back'] = isset($_POST['uploadImg_2']) ? $_POST['uploadImg_2'] : "";
		$data['img_oneself'] = isset($_POST['uploadImg_3']) ? $_POST['uploadImg_3'] : "";
		$data['type'] = 1;
		$data['status'] = 0;
		if(empty($data['postcards']) || empty($data['img_just']) || empty($data['img_back']) || empty($data['img_oneself'])){
			dexit(['res'=>1,"msg"=>"请您填写完信息后再提交"]);
		}
	}
	// 店铺认证
	if($type == 2){
		$data['enterprise'] = isset($_POST['enterprise']) ? $_POST['enterprise'] : "";
		$data['business_license'] = isset($_POST['businessLicense']) ? $_POST['businessLicense'] : "";
		$data['business_img'] = isset($_POST['uploadBusiness']) ? $_POST['uploadBusiness'] : "";
		$data['img_oneself'] = isset($_POST['uploadImg_3']) ? $_POST['uploadImg_3'] : "";
		$data['type'] = 2;
		$data['status'] = 0;
		if(empty($data['enterprise']) || empty($data['business_license']) || empty($data['business_img']) || empty($data['img_oneself'])){
			dexit(['res'=>1,"msg"=>"请您填写完信息后再提交","other"=>$data]);
		}
	}
	if(!empty($data)){
		if($status == 2){
			$data['update_time'] = time();
			$res = D("User_audit")->data($data)->where(['uid'=>$userId])->save();
		}else{
			$data['uid'] = $userId;	
			$data['create_time'] = time();
			$data['update_time'] = time();
			$res = D("User_audit")->data($data)->add();
		}
		if(!$res){
			dexit(['res'=>1,"msg"=>"信息错误，请您重新填写","other"=>$res]);
		}		
		dexit(['res'=>0,"msg"=>"提交成功，请您耐心等待审核","other"=>$res]);
	}
	dexit(['res'=>1,"msg"=>"请您填写完信息后再提交",'other'=>$data]);
}

// 用户认证
// if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'postcard'){
	// $userId = 918;
	$where = ['uid'=>$userId];
	$audit = D("User_audit")->where($where)->select();
	$audit = $audit[0];
	$type = $audit['type'];
	// include display("postcard");
	// exit();
// }

include display("postcard");