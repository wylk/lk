<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

if(!IS_POST){
	$orderId = $_GET['id'];
	$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
	if($orderinfo['status']){
		header('location:orderDetail.php?id='.$orderId);
	}
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
if(!empty($orderId)){
	$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
	if($orderinfo['status']){
		dexit(['res'=>2,'msg'=>'已付款']);
	}
}
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
		$payPwd = $_POST['payPwd'];
		// 判断密码
		$userInfo = D('User')->field('pay_password')->where(['id'=>$userId])->find();
		if(md5($payPwd) != $userInfo['pay_password']){
			dexit(['res'=>1,'msg'=>'支付密码错误','data'=>md5($payPwd),'id'=>$userId]);
		}
		// 判断余额
		$userPackinfo = D("Card_package")->field('num')->where(['uid'=>$userId,'type'=>'leka'])->find();
		// if($orderinfo['number'] - $userPackinfo['num'] > 0) dexit(['res'=>1,'msg'=>'平台币余额不足']);
		// 调用回调
		import('source.class.Http');
		$payment_url = option('config.wap_site_url') . '/notice.php';
		// $payment_url = 'lk.com/wap/notice.php';
		$data['order_id'] = $orderId;
		$result = Http::curlPost($payment_url, $data);
		if($result['errcode']){
			dexit(['res'=>1,"msg"=>'支付失败']);
		}
		dexit(['res'=>0,"msg"=>'支付成功','orderId'=>$orderId]);
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
	// 判断是否有平台支付密码
		$payinfo = D('User')->field("pay_password")->where(['id'=>$userId])->find();
		if(empty($payinfo['pay_password'])){
			dexit(['res'=>1,'msg'=>'请先设置支付密码']);
		}
		dexit(['res'=>0,'msg'=>'已设置支付密码']);

		break;
	case 'test' :
		break;
	
	default:
		# code...
		break;
}
// $orderResult = ['error'=>0,'msg'=>'已生成订单',"orderId"=>$order_id];
dexit($orderResult);