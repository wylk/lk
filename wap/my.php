<?php
require_once dirname(__FILE__).'/global.php';
//require_once dirname(__FILE__).'/func.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$verifyLen = "6";  //验证码长度
// $userId = 11;
$phone = isset($wap_user['phone']) ? $wap_user['phone'] : "";
$userId = isset($wap_user['userid']) ? $wap_user['userid'] : 1;

// 清除超时订单
$where = ['create_time'=>["<=",time()-60*30],"status"=>"0"];
$orderlist = D("Orders")->where($where)->select();
if($orderlist){
	foreach ($orderlist as $key => $value) {
		$tranIds[] = $value['tran_id'];
		$frozenList[$value['tran_id']] += $value['number'];
	}

	if(is_array($tranIds) && count($tranIds)>1) $tranWhere['id'] = ['in',$tranIds];
	else $tranWhere['id'] = $tranIds[0];
	$tranList = D("Card_transaction")->where($tranWhere)->select();
	M("Card_transaction")->saveAll($tranList,$frozenList);
	D("Orders")->where(['create_time'=>["<=",time()-60*30],"status"=>"0"])->setField("status",2);
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
// 判断是否认证
$ruleJudge = D("User_audit")->field("type,status,uid")->where(['uid'=>$userId])->select();
foreach($ruleJudge as $key=>$val){
	$type = $val['type'];
	$status = $val['status'];
}
if($type == 2 && $status == 1 ){
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'身份认证'],
            ['icon'=>'&#xe758;','url'=>'./cardType.php','title'=>'发卡'],
            ['icon'=>'&#xe6f5;','url'=>'./cardList.php','title'=>'卡/券/库'],
            ['icon'=>'&#xe803;','url'=>'','title'=>'API接口'],
            ['icon'=>'&#xe83a;','url'=>'','title'=>'店员管理'],
            ['icon'=>'&#xe6ae;','url'=>'./setup.php','title'=>'设置'],
        ];
}else{
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'身份认证'],
            ['icon'=>'&#xe6ae;','url'=>'./setup.php','title'=>'设置'],
        ];
}

 

// var_dump(isset($_SESSION));exit();

include display('my');
echo ob_get_clean();
exit();
