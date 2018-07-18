<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
//dump($config['reg_readme_content']);


if(IS_POST){
	$orderId = $_POST['orderId'];
	$payPwd = $_POST['payPwd'];
	$userInfo = D("User")->where(["id"=>$userId])->find();
	$userInfo['pay_password'] = "123456";
	if($userInfo['pay_password'] != $payPwd){
		dexit(['res'=>1,'msg'=>'支付密码错误']);
	}
	$orderinfo = D("Orders")->where(['id'=>$orderId])->find();

	//模拟支付回调
	import('LkApi');
	$api = new LkApi(['appid'=>'23432','mchid'=>'1273566173','key'=>'sdagjjjjjk']);
	$payData['order_id'] = $orderinfo['id'];
	$rwx = $api->weixinPay($payData);
	// dump($rwx);
	// D('Orders')->data(['status'=>1])->where(array('onumber'=>$orderinfo['onumber']))->save();
	dexit(['res'=>0,"msg"=>"购买成功","orderId"=>$orderinfo['id']]);
}


// 判断是否有支付密码
// $userInfo = D("User")->where(["id"=>$userId])->find();
// if(empty($userInfo['pay_password'])){
// 	echo "请先设置支付密码";
// 	die();
// }

$id = clear_html($_GET['id']);
$orderInfo = D("Orders")->where(['id'=>$id])->find();

include display('success');
echo ob_get_clean();



