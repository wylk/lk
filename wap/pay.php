<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];


if(IS_POST){

	$orderId = $_POST['orderId'];
	if(!empty($orderId)){
		$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
		if($orderinfo['status']){
			dexit(['res'=>2,'msg'=>'订单已付款或已失效']);
		}
	}else{
		dexit(['res'=>1,"msg"=>"订单信息错误"]);
	}

	$userInfo = D('User')->field('pay_password,openid')->where(['id'=>$userId])->find();
	if(empty($userInfo['openid'])) dexit(['res'=>1,"msg"=>"openid错误"]);
	$out_trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);	
	$payType = $_POST['payType'];	
	switch ($payType) {
		case 'weixin':
			implode('weixin_pay');
			$data = [
				'appid' => option('config.platform_weixin_appid'),
				'mch_id' => option('config.platform_weixin_mchid'),
				'api_key' => option('config.platform_weixin_key'),
			];
			$money = round(($orderinfo['number']*$orderinfo['price']),2);
			$pay = new weixin_pay($data['appid'],$data['mch_id'],$data['api_key']);
			$res = $pay->getPrePayOrder('乐卡支付',$out_trade_no,$money,$userInfo['openid'],'JSAPI');
			if(!$res) dexit(['res'=>1,"msg"=>'payinfo获取失败','data'=>$res]);
			D('Orders')->data(['out_trade_no'=>$out_trade_no])->where(['id'=>$orderId])->save();
			dexit(['res'=>0,"msg"=>'payinfo获取成功','data'=>$res]);
			break;
		case 'platform':
			$payPwd = $_POST['payPwd'];
			// 订单信息
			$orderInfo = D("Orders")->field('out_trade_no')->where(['id'=>$orderId])->find();
			// 判断密码
			if(md5($payPwd) != $userInfo['pay_password']){
				dexit(['res'=>1,'msg'=>'支付密码错误','data'=>md5($payPwd),'id'=>$userId]);
			}
			// 判断余额
			$userPackinfo = D("Card_package")->field('num')->where(['uid'=>$userId,'type'=>option("hairpan_set.platform_type_name")])->find();
			if($orderinfo['number'] - $userPackinfo['num'] > 0) dexit(['res'=>1,'msg'=>'平台币余额不足']);
			// 调用回调
			import('source.class.Http');
			$payment_url = option('config.wap_site_url') . '/notice.php';
			$data['out_trade_no'] = $orderInfo['out_trade_no'];
			$data['payType'] = 'platform';
			$data['userid'] = $userId;
			$result = Http::curlPost($payment_url, $data);

			if($result['errcode']){
				dexit(['res'=>1,"msg"=>'支付失败','data'=>$result]);
			}
			dexit(['res'=>0,"msg"=>'支付成功','orderId'=>$orderId,'data'=>$result]);
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
}

$orderId = $_GET['id'];
$orderinfo = D("Orders")->where(['id'=>$orderId])->find();
if($orderinfo['status']){
	header('location:orderDetail.php?id='.$orderId);
}
include display('pay');