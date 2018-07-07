<?php
require_once dirname(__FILE__).'/global.php';
$verifyLen = "6";  //验证码长度

// 判断是否是微信、支付宝、手机号登录
// 1、微信号
// 2、支付宝
// 3、手机号登录

//dump($config['reg_readme_content']);
// 手机号注册 aja请求处理
if(isset($_POST['phone'])){
	// ajax判断该用户账号是否存在
	if(isset($_POST['type']) && $_POST['type'] == "check"){
		$res = M("lk_user")->findField("id,phone","phone=".$phone);
		if($res) $res1 = ["res"=>false,'msg'=>"该手机号已经被注册"];
		else $res1 = ["res"=>true,"msg"=>"该手机号可以注册"];
		echo dexit($res1);
		exit();
	}
	// 验证码获取
	if(isset($_POST['type']) && $_POST['type'] == "code"){
		import("transfer");
		$a = new Transfer();
		$getPhone = $_POST['phone'];
		$code = rangdNumber($verifyLen);
		$result = $a->message($getPhone,array("code"=>$code));
		$_SESSION['verify'][$getPhone] = $code;
		dexit(['result'=>$result,'code'=>$code]);
	}
	// 退出登录
	if(isset($_POST['type']) && $_POST['type'] == "signOut"){
		session_destroy();
		if(isset($_SESSION)) echo false;
		else echo true;
		exit();
	}
	// 验证码登录
	if(isset($_POST['logintype']) && $_POST['logintype'] == "checkAccount"){
		$phone = trim($_POST['phone']);
		$code = trim($_POST['password']);
		// if($code != $_SESSION['verify'][$phone]){
		// 	dexit(["res"=>1,'msg'=>"验证码错误"]);
		// }
		$phoneRes = D("User")->field("id")->where(['phone'=>$phone])->select();
		if(!$phoneRes){
			$addAccountRes = D("User")->data(['phone'=>$phone])->add();
			if(!$addAccountRes){
				dexit(["res"=>1,'msg'=>"注册失败"]);
			}
			$userid = $addAccountRes;
		}else{
			$userid = $phoneRes[0]['id'];
		}
		$_SESSION['wap_user']["phone"] = $phone;
		$_SESSION['wap_user']['userid'] = $userid;
		$_SESSION['wap_user']['logintime'] = time();
		dexit(["res"=>0,'msg'=>"登录成功"]);
	}
}

include display("login");


