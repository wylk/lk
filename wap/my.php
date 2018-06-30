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
	$pagetype = "postcardBackstage";
	import('HtmlForm');
	$html = new HtmlForm('add','http://lk.com/wap/my.php');
	$radio = [['val'=>1,'title'=>'个人','checked'=>'checked'],['val'=>2,'title'=>'企业','checked'=>'']];
	$nowcheckbox = [['val'=>0,'title'=>'未认证','checked'=>'checked']];
	$htmlRes = $html->checkbox(['clas','认证状态'],$nowcheckbox)
				->radio(['type','认证类型'],$radio)
				->input(['name','真实姓名'],['name',['reg','cnRegex']])
				->input(['postcard','身份证号'],['postcard',['reg','idcardRegex']])
				->upload('身份证正面','img_just','img_just')
				->upload('身份证反面','img_back','img_back')
				->upload('手持身份证','img_oneself','img_oneself')
				//->resSuccess('http://lk.com/wap/my.php')
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
	$html = new HtmlForm('add','http://lk.com/wap/my.php');
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
			header("location:/my.php?pagetype=postcard");
		}
		exit();
	}
	$url = $_SERVER["HTTP_REFERER"];
	header("location:".$url);
	exit();
}
// 发卡
if(isset($_GET['pagetype']) && $_GET['pagetype'] == "cardMaking"){
	$cardRes = M("Contract")->find();
	include display("cardMaking");
	exit();
}

if(isset($_GET['pagetype']) && $_GET['pagetype'] == "cardList"){
	$cardList = M("lk_card_package")->select();
	foreach($cardList as $key=>$value){
		$cardBag[$value['card_id']] = $value;
		$cardIds[] = $value['card_id'];
	}
	list($cardListRes,$cIdInfo) = M("lk_card")->cardInfobyCardId($cardIds);
	foreach($cardListRes as $key=>$value){
		foreach($cIdInfo as $k=> $v){
			$value[$v['id']]['field'] = $v['val'];
			$value[$v['id']]['describe'] = $v['describe'];
			$cardListRes[$key]['uid'] = $value[$v['id']]['uid'];
			$cardListRes[$key]['c_id'] = $value[$v['id']]['c_id'];
			$cardListRes[$key]['card_id'] = $value[$v['id']]['card_id'];
			// $cardListRes[$key]['val'] = $value[$v['id']]['val'];
			$cardListRes[$key][$v['val']] = $value[$v['id']]['val'];
			$cardListRes[$key][$v['val']."_describe"] = $v['describe'];

		}
	}
	// // 	var_dump($cIdInfo);
	// print_r($cardBag);
	// print_r($cardListRes);
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