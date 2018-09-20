<?php
require_once dirname(__FILE__).'/global.php';
// $payPwd = $_POST['payPwd'];
// if(md5($payPwd) != $userInfo['pay_password']){
// 	dexit(['res'=>1,'msg'=>'支付密码错误']);
// }
$orderId = $_POST['orderId'];
$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
$payType = $_POST['payType']	
switch ($payType) {
	case 'weixin':
		implode('weixin_pay');
		$data = [
			'appid' => "wxcf45e0f03cb2fe06", 
	        'mch_id' => "1504906041", 
	        'api_key' => "7458e55e72ea67b4e03c8380668a8793",
		]
		$money = '0.01';
		$order_id = time();
		$pay = new weixin_pay($data['appid'],$data['mch_id'],$data['api_key']);
		$res = $pay->getPrePayOrder('乐卡支付',$order_id,$money,$openid,'weixin');

		break;
	case 'platform':
		$userInfo = D("User")->where(["id"=>$userId])->find();
		if(md5($payPwd) != $userInfo['pay_password']){
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
		// dexit(['res'=>0,"msg"=>"购买成功","orderId"=>$orderinfo['id']]);
		break;
	case 'test' :
		break;
	
	default:
		# code...
		break;
}
// $orderResult = ['error'=>0,'msg'=>'已生成订单',"orderId"=>$order_id];
dexit($orderResult);