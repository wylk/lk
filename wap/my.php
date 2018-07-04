<?php
require_once dirname(__FILE__).'/global.php';
require_once dirname(__FILE__).'/func.php';
$verifyLen = "6";  //验证码长度
$userId = 11;


// 判断是否登录状态中
if(isset($_SESSION['loginsign']) && time()-$_SESSION['loginsign']['logintime']<3600*60){
	// var_dump(time()-$_SESSION['loginsign']['lasttime']);
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
	$pagetype = "postcardBackstage";
	import('HtmlForm');
	$html = new HtmlForm('add','http://lk.com/wap/my.php?pagetype=postcardBackstage');
	$radio = [['val'=>1,'title'=>'个人','checked'=>'checked'],['val'=>2,'title'=>'企业','checked'=>'']];
	$nowcheckbox = [['val'=>0,'title'=>'未认证','checked'=>'checked']];
	$htmlRes = $html->checkbox(['clas','认证状态'],$nowcheckbox)
				->radio(['type','认证类型'],$radio)
				->input(['name','真实姓名'],['name',['reg','cnRegex']])
				->input(['postcard','身份证号'],['postcard',['reg','idcardRegex']])
				->upload('身份证正面','img_just','img_just')
				->upload('身份证反面','img_back','img_back')
				->upload('手持身份证','img_oneself','img_oneself')
				// ->resSuccess('http://lk.com/wap/my.php?pagetype=postcardBackstage')
				->addFrom();
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
	$pagetype = "postcardBackstage";
	import('HtmlForm');
	$html = new HtmlForm('add','http://lk.com/wap/my.php?pagetype=postcardBackstage');
	$radio = [['val'=>1,'title'=>'个人','checked'=>'checked'],['val'=>2,'title'=>'企业','checked'=>'']];
	$nowcheckbox = [['val'=>0,'title'=>'未认证','checked'=>'checked']];
	$htmlRes = $html->checkbox(['clas','认证状态'],$nowcheckbox)
				->radio(['type','认证类型'],$radio)
				->input(['name','真实姓名',"text",$postcardInfo['name']],['name',['reg','cnRegex']])
				->input(['userid','userid',"hidden",$postcardInfo['uid']],['userid',['reg','cnRegex']])
				->input(['postcard','身份证号',"text",$postcardInfo['postcards']],['postcard',['reg','idcardRegex']])
				->upload('身份证正面','img_just','img_just')
				->upload('身份证反面','img_back','img_back')
				->upload('手持身份证','img_oneself','img_oneself');
				if($postcardInfo['remarks']){
					$htmlRes->textarea([$postcardInfo['remarks'],"审核结果"]);
				}
				//->resSuccess('http://lk.com/wap/my.php')
				$htmlRes = $htmlRes->addFrom();
	include display("postcard");
	exit();
}
//身份证认证信息处理
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "postcardBackstage"){
	$name = isset($_GET['name']) ? $_GET['name'] : "";
	$postcard = isset($_GET['postcard']) ? $_GET['postcard'] : "";
	$type = isset($_GET['type']) ? $_GET['type'] : "";
	$img_just = isset($_GET['img_just']) ? $_GET['img_just'] : "";
	$img_back = isset($_GET['img_back']) ? $_GET['img_back'] : "";
	$img_oneself = isset($_GET['img_oneself']) ? $_GET['img_oneself'] : "";
	if($name && $postcard && $img_oneself){
		$data = ['name'=>$name,"postcards"=>$postcard,"type"=>$type,"img_just"=>$img_just,"img_back"=>$img_back,"img_oneself"=>$img_oneself,"uid"=>'914',"create_time"=>time(),"update_time"=>time()];
		$where['uid'] = isset($_GET['userid']) ? $_GET['userid'] : "";
		$postcardRes = M("lk_user_audit")->save($data,$where);
		if($postcardRes){
			header("location:./my.php?pagetype=postcardEdit");
		}else{
			header("location:./my.php?pagetype=postcard");
		}
		exit();
	}
	$url = $_SERVER["HTTP_REFERER"];
	header("location:".$url);
	exit();
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

