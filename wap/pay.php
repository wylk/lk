<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// dump($userInfo);die();
if(!IS_POST){
	$orderId = $_GET['id'];
	$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
	// dump($orderinfo);
	include display('pay');
	die();
}
// if(isset($_POST['payPwd'])){
// 	$payPwd = $_POST['payPwd'];
// 	$userInfo = D('User')->field('pay_password')->where(['id'=>$wap_user['userid']])->find();
// 	if(md5($payPwd) != $userInfo['pay_password']){
// 		dexit(['res'=>1,'msg'=>'支付密码错误']);
// 	}
// }
$orderId = $_POST['orderId'];
$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
$payType = $_POST['payType'];	
switch ($payType) {
	case 'weixin':
	dexit(['res'=>1,"msg"=>'weixin支付']);
		implode('weixin_pay');
		$data = [
			'appid' => "wxcf45e0f03cb2fe06", 
	        'mch_id' => "1504906041", 
	        'api_key' => "7458e55e72ea67b4e03c8380668a8793",
		];
		$money = '0.01';
		$order_id = time();
		$pay = new weixin_pay($data['appid'],$data['mch_id'],$data['api_key']);
		$res = $pay->getPrePayOrder('乐卡支付',$order_id,$money,$openid,'weixin');

		break;
	case 'platform':
		$payType = $_POST['payType'];
		$orderId = $_POST['orderId'];
		$payPwd = $_POST['payPwd'];
		$userInfo = D('User')->field('pay_password')->where(['id'=>$userId])->find();
		if(md5($payPwd) != $userInfo['pay_password']){
			dexit(['res'=>1,'msg'=>'支付密码错误','data'=>md5($payPwd),'id'=>$userId]);
		}
		// dexit(['res'=>0,'msg'=>'支付成功']);
		// 判断平台币是否足够
		$userPackinfo = D("Card_package")->field('num')->where(['uid'=>$userId,'type'=>'leka'])->find();
		if($payType - $userPackinfo['num'] > 0) dexit(['res'=>1,'msg'=>'平台币余额不足']);
		// // 平台币转账
		// $orderinfo = D("Orders")->where(['id'=>$orderId])->find();
		// $data[] = ['field'=>'num','opreator'=>'-','step'=>$payPwd,'id'=>$userId];
		// $data[] = ['field'=>'num','opreator'=>'+','step'=>$payPwd,'id'=>$orderinfo['sell_id']];
		// M("Card_package")->frozen($data);
		// D("Orders")->where(['id'=>$orderId,'status'=>3])->save();
		// 调用回调
		import('source.class.Http');
		// $payment_url = option('config.wap_site_url') . '/paynotice.php';
		$payment_url = 'lk.com/wap/notice.php';
		$data['order_id'] = $orderId;
		$result = Http::curlPost($payment_url, $data);
dexit(['res'=>1,"msg"=>'回调结束','data'=>$result]);
		// //模拟支付回调
		// import('LkApi');
		// $api = new LkApi(['appid'=>'23432','mchid'=>'1273566173','key'=>'sdagjjjjjk']);
		// $payData['order_id'] = $orderinfo['id'];
		// $rwx = $api->weixinPay($payData);
		// dump($rwx);
		// D('Orders')->data(['status'=>1])->where(array('onumber'=>$orderinfo['onumber']))->save();
		// dexit(['res'=>0,"msg"=>"购买成功","orderId"=>$orderinfo['id']]);
		break;
	case 'platform_pass' :

		break;
	case 'test' :
		break;
	
	default:
		# code...
		break;
}
// $orderResult = ['error'=>0,'msg'=>'已生成订单',"orderId"=>$order_id];
dexit($orderResult);