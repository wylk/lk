<?php
require_once dirname(__FILE__).'/global.php';
require_once dirname(__FILE__).'/func.php';
$verifyLen = "6";  //验证码长度

// 判断是否是微信、支付宝、手机号登录
// 1、微信号
// 2、支付宝
// 3、手机号登录

var_dump($_SESSION);
// 手机号注册 aja请求处理
if(isset($_POST['phone'])){
	// ajax判断该用户账号是否存在
	if(isset($_POST['type']) && $_POST['type'] == "check"){
		$phone = $_POST['phone'];
		$res = M("lk_user")->findField("id,phone","phone=".$phone);
		if($res) $res = array("res"=>false);
		else $res = array("res"=>true);
		echo json_encode($res);
		exit();
		// if()
	}
	// 验证码获取
	if(isset($_POST['type']) && $_POST['type'] == "code"){
		require_once dirname(__FILE__).'/class/Transfer.class.php';
		$a = new Transfer();
		$getPhone = $_POST['phone'];
		$code = rangdNumber($verifyLen);
		$result = $a->message($getPhone,array("code"=>$code));
		$_SESSION['verify'][$getPhone] = $code;
		$data = array($getPhone,$code,$result,$_SESSION['verify'][$getPhone]);
		echo json_encode($data);
		exit();
	}
	// 退出登录
	if(isset($_POST['type']) && $_POST['type'] == "signOut"){
		session_destroy();
		if(isset($_SESSION)) echo false;
		else echo true;
		exit();
	}
}

//手机号注册 短信验证
$loginType = isset($_GET['logintype']) ? $_GET['logintype'] : false;
if($loginType == "register"){
	$subPhone = $_GET['phone'];
	$subPhone = checkTelephone($subPhone) ? $subPhone : "";
	$subCode = $_GET['code'];
	$code = $_SESSION['verify'][$subPhone];
	if($subCode == $code){
		// 将用户添加到数据库中
		$data = ['phone'=>$subPhone,"upwd"=>"123123"];
		$insertRes = M("lk_user")->insert($data);
		if($insertRes) {
			$_SESSION['loginsign']['phone'] = $subPhone;
			$_SESSION['loginsign']['lasttime'] = time();
			header("location:my.php");
			exit();
		}
	}
	header("location:login.php?pagetype=register");
	exit();
}


// 手机号登录检验
if($loginType == "login"){
	$loginPhone = trim($_GET['phone']);
	$loginPwd = trim($_GET['password']);
	$loginWhere = ['phone'=>$loginPhone,"upwd"=>$loginPwd];
	$checkRes = M("lk_user")->findField("id,phone,upwd",$loginWhere);
	if($checkRes){
		$_SESSION['loginsign']['phone'] = $loginPhone;
		$_SESSION['loginsign']['lasttime'] = time();
		header("location:./my.php");
		exit();
	}
	header("location:./login.php");
    exit();
}


// 浏览页面判断
$pageArr = ['login',"register"];
$pageType  = isset($_GET['pagetype']) ? $_GET['pagetype'] : '';
if($pageType && in_array($pageType, $pageArr)){
	include display($pageType);
}else{
	include display("login");
	exit();
}
