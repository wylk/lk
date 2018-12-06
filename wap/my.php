
<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$verifyLen = "6";  //验证码长度

// dump($wap_user);
$phone = isset($wap_user['phone']) ? $wap_user['phone'] : "";
$userId = isset($wap_user['userid']) ? $wap_user['userid'] : 1;

// 清除超时订单
// $deadline_time = option('hairpan_set.expiry_time') ? option('hairpan_set.expiry_time') : 60*30;
$deadline_time = 30;
// /************平台币清除超时订单 start ***********/
$leka_where = ['create_time'=>['<=',time()-$deadline_time],"status"=>'0',"type"=>0];
$leka_orders = D("Orders")->where($leka_where)->select();
if($leka_orders){
	foreach($leka_orders as $key=>$value){
		$leka_orderIds[] = $value['id'];
		if($value['tran_id'] == $value['tran_other']){
			$leka_num[$value['tran_id']] += $value['number'];
			// 市场直卖单  // num + number   frozen-number
			$leka_marker_num[$value["sell_id"]] += $value['number'];
			$leka_marker_frozen[$value['sell_id']] += $value['number'];
			// 保证金
			if($value['bail']){
				// bail-bail   number+bail
				$leka_marker_num[$value['sell_id']] += $value['bail'];
				$leka_bail_num[$value['sell_id']] += $value['bail'];
			}
		}else{
			$leka_num[$value['tran_id']] += $value['number'];
			$leka_num[$value['tran_other']] += $value['number'];
			$leka_frozen[$value['tran_other']] = ['id'=>$value['tran_other'],"operator"=>"-","step"=>$leka_num[$value['tran_other']],"field"=>"frozen"];
		}

		$leka_frozen[$value['tran_id']] = ['id'=>$value['tran_id'],"operator"=>"-","step"=>$leka_num[$value['tran_id']],"field"=>"frozen"];
	}
	M("Card_transaction")->frozen($leka_frozen);
	if($leka_marker_num){
		foreach($leka_marker_num as $key=>$value){
			$clearPackage[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"+","field"=>'num',"step"=>$value];
			$clearPackage[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"-","field"=>'frozen',"step"=>$value];
			if($leka_bail_num[$key])
				$clearPackage_bail[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"-","field"=>'bail',"step"=>$leka_bail_num[$key]];
		}
		$additional[] = ['field'=>'type','operator'=>'=','val'=>option("hairpan_set.platform_type_name")];
		M("Card_package")->dataModification($clearPackage,$additional);
		M("Card_package")->dataModification($clearPackage_bail,$additional);
	}
	D("Orders")->where(['id'=>['in',$leka_orderIds]])->setField("status",'4');
}
// /************平台币清除超时订单 end *************/

// /************卡券清除超时订单 start *************/
$card_where = ['create_time'=>['<=',time()-$deadline_time],"status"=>'0',"type"=>1];
$card_orders = D("Orders")->where($card_where)->select();
// dump($card_orders);
if($card_orders){
	foreach($card_orders as $key=>$value){
		$card_orderIds[] = $value['id'];
		$card_num[$value['tran_id']] += $value['number'];
		$card_frozen[$value['tran_id']] = ['id'=>$value['tran_id'],"operator"=>"-","step"=>$card_num[$value['tran_id']],"field"=>"frozen"];
	}
	M("Card_transaction")->frozen($card_frozen);
	D("Orders")->where(['id'=>['in',$card_orderIds]])->setField("status",4);
}
// /************卡券清除超时订单  end  *************/


// // 清除超时订单
// $deadline = option('hairpan_set.expiry_time') ? option('hairpan_set.expiry_time') : 60*30;
// $where = ['create_time'=>["<=",time()-$deadline],"status"=>"0",'type'=>['!=',2]];
// $orderlist = D("Orders")->where($where)->select();
// if($orderlist){
// 	foreach($orderlist as $key=>$value){
// 		$frozenNum[$value['tran_id']] += $value['number'];
// 		$frozenNum[$value['tran_other']] += $value['number'];

// 		$frozenList[$value['tran_id']] = ['id'=>$value['tran_id'],"operator"=>"-","step"=>$frozenNum[$value['tran_id']],"field"=>"frozen"];
// 		if(isset($value['tran_other']) && $value['tran_other'] != $value['tran_id']){
// 			$frozenList[$value['tran_other']] = ['id'=>$value['tran_other'],"operator"=>"-","step"=>$frozenNum[$value['tran_other']],"field"=>"frozen"];
// 		}
// 		// 市场直卖订单超时处理
// 		if(isset($value['tran_other']) && $value['tran_other'] == $value['tran_id']){
// 			// num+number   frozen-number
// 			$marketSellNum[$value['sell_id']] += $value['number'];
// 			$marketSellFrozen[$value['sell_id']] += $value['number'];
// 			if($value['bail']){
// 				// bail-bail    num+bail
// 				$marketSellNum[$value['sell_id']] += $value['bail'];
// 				$marketBailNum[$value['sell_id']] += $value['bail'];
// 			}
// 		}
// 	}
// 	foreach($marketSellNum as $key => $value){
// 		$clearPackage[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"+","field"=>'num',"step"=>$marketSellNum[$key]];
// 		$clearPackage[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"-","field"=>'frozen',"step"=>$marketSellFrozen[$key]];
// 		if($marketBailNum[$key])
// 			$clearPackage[] = ['id'=>['field'=>"uid",'val'=>$key],"operator"=>"-","field"=>'bail',"step"=>$marketBailNum[$key]];
// 	}
// 	$res = M("Card_transaction")->frozen($frozenList);
// 	$additional[] = ['field'=>'type','operator'=>'=','val'=>option("hairpan_set.platform_type_name")];
// 	$re = M("Card_package")->dataModification($clearPackage,$additional);
// 	D("Orders")->where(['create_time'=>["<=",time()-$deadline],"status"=>"0"])->setField("status",4);

// }

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
		// require_once dirname(__FILE__).'/class/Transfer.class.php';
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
$ruleJudge = D("User_audit")->field("type,status,uid,isdelete")->where(['uid'=>$userId])->find();

$type = $ruleJudge['type'];
$status = $ruleJudge['status'];
$isDelete = $ruleJudge['isdelete'];

if($type == 2 && $status == 1 && empty($isDelete)){
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'认证'],
            ['icon'=>'&#xe758;','url'=>'./cardType.php','title'=>'卡/券'],
            ['icon'=>'&#xe803;','url'=>'./userApi.php','title'=>'接口'],
            ['icon'=>'&#xe83a;','url'=>'promotion.php','title'=>'推广'],
        ];
}elseif($type == 3 && $status == 1 && empty($isDelete)){
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'认证'],
            ['icon'=>'&#xe803;','url'=>'./userApi.php','title'=>'接口'],
        ];
}elseif($isDelete != 0){
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'认证','msg'=>'无认证权限，请联系管理员'],
        ];
}else{
	$menu = [
            ['icon'=>'&#xe6f5;','url'=>'./postcard.php','title'=>'认证'],
        ];
}
$menu[] = ['icon'=>'&#xe6ae;','url'=>'./setup.php','title'=>'设置'];

$res=D('User')->where(['phone' => $phone])->find();

include display('my');
echo ob_get_clean();
exit();

