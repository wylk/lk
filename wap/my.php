<?php
require_once dirname(__FILE__).'/global.php';
require_once dirname(__FILE__).'/func.php';
$verifyLen = "6";  //验证码长度
// $userId = 11;


// 判断是否登录状态中
<<<<<<< HEAD
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['logintime']<3600){
	// var_dump(time()-$_SESSION['loginsign']['lasttime']);
=======
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['lasttime']<3600*60){
	var_dump(time()-$_SESSION['loginsign']['lasttime']);
>>>>>>> b241a5d90bfacebcbbd571fcdce6b513f619d0e2
	$_SESSION['loginsign']['lasttime'] = time();
	$phone = isset($_SESSION['loginsign']['phone']) ? $_SESSION['loginsign']['phone'] : "";
	$userId = isset($_SESSION['loginsign']['userid']) ? $_SESSION['loginsign']['userid'] : "";
	if(empty($phone) || empty($userId)){
		header("location:login.php");
	}
}else{
	header("location:login.php");
	exit();
}

// 钱包
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "purse"){
	$userInfo = M("lk_user")->findField("point_balance,phone,id,upwd","phone=".$phone);
	$userRes = transformArray($userInfo);
	$pointBalance = $userRes['point_balance'];

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
// 用户认证
if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'postcard'){
	// if()
	include display("postcard");
	exit();
}
// 用户认证信息修改
if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'postcardEdit'){
	// 获取用户信息
	$uid = isset($_SESSION['loginsign']['uid']) ? $_SESSION['loginsign']['uid'] : "";
	if(empty($uid)){
		$userInfo = M('lk_user')->findField("id,phone","phone=".$phone);
		$uid = transformArray($userInfo,"id");
	}
	$where['uid'] = $uid;
	$postcardInfo = M("lk_user_audit")->select($where);
	$postcardInfo = transformArray($postcardInfo);
	
	include display("postcard");
	exit();
}
//身份证认证信息处理
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "postcardBackstage"){
	$judgeInfo = D("User_audit")->field("uid,type")->where(['uid'=>$userId])->select();
	dexit(['res'=>1,"msg"=>"信息检验","other"=>$judgeInfo]);
	$type = isset($_POST['type']) ? $_POST['type'] : "";
	$data['type'] = $type;
	$data['name'] = isset($_POST['name']) ? $_POST['name'] : "";
	// 个人认证
	if($type == 0){
		$data['postcards'] = isset($_POST['postcard']) ? $_POST['postcard'] : "";
		$data['img_just'] = isset($_POST['uploadImg_1']) ? $_POST['uploadImg_1'] : "";
		$data['img_back'] = isset($_POST['uploadImg_2']) ? $_POST['uploadImg_2'] : "";
		$data['img_oneself'] = isset($_POST['uploadImg_3']) ? $_POST['uploadImg_3'] : "";
	}
	// 店铺认证
	if($type == 1){
		$data['enterprise'] = isset($_POST['enterprise']) ? $_POST['enterprise'] : "";
		$data['business_license'] = isset($_POST['businessLicense']) ? $_POST['businessLicense'] : "";
		$data['business_img'] = isset($_POST['uploadBusiness']) ? $_POST['uploadBusiness'] : "";
	}
	if(!empty($data)){
		$data['uid'] = $userId;
		$data['create_time'] = time();
		$data['update_time'] = time();
		$res = D("User_audit")->data($data)->add();
		if(!$res){
			dexit(['res'=>1,"msg"=>"信息错误，请您重新填写","other"=>$data]);
		}		
		dexit(['res'=>0,"msg"=>"提交成功，请您耐心等待审核"]);
	}
	dexit(['res'=>1,"msg"=>"请您填写完信息后再提交"]);
}
// 发卡
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "cardType"){
	// $uid = 914;
	// $getAuth = authentication($uid);
	// var_dump($getAuth);
	$cardRes = M("Contract")->find();
	$res = D("Card_package")->where(['uid'=>"1530523825"])->select();
	$cardtype = array_column($res, "type");
	$cardtype = array_map(function($value,$key){return $value.="Card";}, $cardtype);
	include display("cardType");
	exit();
}
// 展示卡列表
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "cardList"){
	$where['uid'] = $userId;
	// 获取店铺发卡的类型
	$cardPageList = D("Card_package")->where($where)->select();
	$cardPageList = array_column($cardPageList,null,"card_id");

	// 获取card的属性
	$cardIds = array_keys($cardPageList);
	$cardIdstr = implode($cardIds, "','");
	$where = "card_id in('".$cardIdstr."')";
	// $cardWhere['card_id'] = count($cardIds)>1 ? ['in',$cardIds] : $cardIds[0];
	// 获取卡片的信息
	$cards = D("Card")->where($where)->select();

	// $cids = array_column($cards,"c_id");
	// 获取所有属性列表
	$cidField = D("Contract_field")->where()->select();
	$cidField = array_column($cidField,null,"id");

	// 整理卡的信息
	foreach($cards as $key => $value ){
		$list[$value['card_id']]['uid'] = $value['uid'];
		$list[$value['card_id']]['card_id'] = $value['card_id'];
		$list[$value['card_id']]['type'] = $cardPageList[$value['card_id']]["type"];
		$list[$value['card_id']]['num'] = $cardPageList[$value['card_id']]["num"];
		$list[$value['card_id']]['address'] = $cardPageList[$value['card_id']]["address"];
		$list[$value['card_id']]['is_publisher'] = $cardPageList[$value['card_id']]["is_publisher"];
		// 不同卡不同的属性
		$list[$value['card_id']]['field'][$cidField[$value['c_id']]["val"]]['val'] = $value['val'];
		$list[$value['card_id']]['field'][$cidField[$value['c_id']]["val"]]['describe'] = $cidField[$value['c_id']]["describe"];
	}

	include display("cardList");
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
		$p = '15703216915';
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
			$subPwd = md5($subPwd);
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

function authentication($uid){
	return D("User_audit")->where(['uid'=>$uid])->find();
}

