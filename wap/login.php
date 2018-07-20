<?php
require_once dirname(__FILE__).'/global.php';
$verifyLen = "6";  //验证码长度
$referer=clear_html($_GET['referer']);

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
		dexit(['error'=>0,'msg'=>'退出成功']);
		
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
			import('LkApi');
			// 以太网接口
			$obj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
			$addAccountInfo = $obj->geth_api(['phone'=>$phone,'c'=>'Geth','a'=>'add_account']);
			$addAccountRes = D("User")->data(['phone'=>$phone,"address"=>$addAccountInfo['address']])->add();
			$data['uid'] = $addAccountRes;
			$data['type'] = 'leka';
			$data['num'] = 0;
			$data['card_id'] = $addAccountInfo['addr'];
			$data['address'] = md5($addAccountInfo['card_id'].$addAccountRes);
			$data['user_address'] = $addAccountInfo['address'];
			D("Card_package")->data($data)->add();
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
		dexit(["res"=>0,'msg'=>"登录成功","referer"=>$referer]);
	}
}

include display("login");


