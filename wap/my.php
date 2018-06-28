<?php
require_once dirname(__FILE__).'/global.php';
require_once dirname(__FILE__).'/func.php';
$verifyLen = "6";  //验证码长度



// 判断是否登录状态中
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['lasttime']<3600*60){
	$_SESSION['loginsign']['lasttime'] = time();
	$phone = $_SESSION['loginsign']['phone'];
	$phone = isset($_SESSION['loginsign']['phone']) ? $_SESSION['loginsign']['phone'] : "";
	
}else{
	header("location:login.php");
	exit();
}

// 钱包
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "purse"){
	$userInfo = M("lk_user")->findField("point_balance,phone,id,upwd","phone=".$phone);
	$userRes = transformArray($userInfo);
	$pointBalance = $userRes['point_balance'];

	// // 插入一些账单信息
	// $data = ['user_id'=>"3","card_id"=>"1","type"=>"3","money"=>"100","time"=>time()];
	// $billRes = M("lk_bill")->insert($data);
	// var_dump($billRes);

// 获取用户提现/充值的账单
	$where = ["user_id"=>$userRes['id'],"type"=>['or',['1','2']]];
	$billRes = M("lk_bill")->findField("id,type,money,time",$where);
	$deposit = takeKeyArray($billRes,"type","1");
	$recharge = takeKeyArray($billRes,"type","2");
	// var_dump($deposit);

	include display("purse");
	exit();
}
// 账单
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "bill"){
	include display("bill");
	exit();
}
// 用户认证
if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'postcard'){
	import('HtmlForm');
	$html = new HtmlForm('add','http://lk.com/wap/my.php');
	$radio = [['val'=>1,'title'=>'男','checked'=>'checked'],['val'=>2,'title'=>'女','checked'=>'']];
	$option = [['val'=>1,'name'=>'北京'],['val'=>2,'name'=>'上海']];
	$nowcheckbox = [['val'=>0,'title'=>'未认证','checked'=>'checked']];
	$checkbox = [['val'=>1,'title'=>'个人','checked'=>'checked'],['val'=>2,'title'=>'企业','checked'=>'']];
	$htmlRes = $html->checkbox(['clas','认证类型'],$nowcheckbox)
				->checkbox(['clas','认证类型'],$checkbox)
				->input(['name','真实姓名'],['name',['reg','pass']])
				->upload('身份证正面','img_id','img_name')
				//->resSuccess('http://lk.com/wap/my.php')
				->addFrom();
	include display("postcard");
	exit();
}

// 设置
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "setup"){
	$userInfo = M("lk_user")->findField("id,name,phone,wx_openId,ali_userid,upwd,pay_password","phone=".$phone);
	$userInfo = transformArray($userInfo);
	// var_dump($userInfo);
	include display("setup");
	exit();
}
// ajax请求
// if(isset($_POST['phone']) && $_POST['phone'] == $phone && isset($_POST['type'])){
if(isset($_POST['phone']) && isset($_POST['type'])){
	// 修改密码、支付密码 获取验证码
	if($_POST['type'] == 'verify'){
		$code = rangdNumber($verifyLen);
		require_once dirname(__FILE__).'/class/Transfer.class.php';
		$a = new Transfer();
		$p = '15703216916';
		$messageRes = $a->message($p,["code"=>$code]);
		// echo json_encode(array($messageRes,$messageRes['result']['success']));
		if($messageRes['result']['success']){
			$_SESSION['verify'][$phone] = $code;
			echo json_encode(['messageRes'=>$messageRes['result']['success'],"code"=>$code]);
		}else{
			echo json_encode(['messageRes'=>false]);
		}
		exit();
	}
	// 修改密码 密码验证 修改
	if($_POST['type'] == "checkPwd"){
		$subCode = trim($_POST['code']);
		$subPwd = trim($_POST['pwd']);
		$code = $_SESSION['verify'][$phone];
		if($code == $subCode){
			$changeRes = M("lk_user")->update("upwd",$subPwd,"phone=".$phone);
			if($changeRes) session_destroy();
		}
		echo json_encode($changeRes);
		exit();
	}
	// 支付密码修改 验证修改
	if($_POST['type'] == "checkPayPwd"){
		$subCode = trim($_POST['code']);
		$subPayPwd = trim($_POST['pwd']);
		$code = $_SESSION['verify'][$phone];
		if($code == $subCode){
			$changeRes = M("lk_user")->update("pay_password",$subPayPwd,"phone=".$phone);
		}
		echo json_encode($changeRes);
		exit();
	}
}


// var_dump(isset($_SESSION));exit();

include display('my');
echo ob_get_clean();
exit();