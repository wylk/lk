<?php
require_once dirname(__FILE__).'/global.php';
// 微信登录
// $appid = 'wxcf45e0f03cb2fe06';
// $appSecret = '230bbd5800c6e0fa2524266f03892c3a';
// // $redirect_uri = urlencode('lk.com/wap/my.php');
// // $redirect_uri = urlencode('https://mall.epaikj.com/user.php?c=user&a=login');
// $redirect_uri = urlencode('www.lk.com');
// // echo $redirect_uri;
// $scope = 'snsapi_userinfo';
// $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state=STATE#wechat_redirect';
// header('location:'.$url);

// // 微信登录
// implode('weixin_pay');
// $data = [
// 	'appid' => "wxcf45e0f03cb2fe06", 
//     'mch_id' => "1504906041", 
//     'api_key' => "7458e55e72ea67b4e03c8380668a8793",
// ];
// $money = '0.01';
// $order_id = time();
// $openid = '';//获取需要后台设置
// $pay = new weixin_pay($data['appid'],$data['mch_id'],$data['api_key']);
// $res = $pay->getPrePayOrder('乐卡支付',$order_id,$money,$openid,'weixin');

// $a = php_sapi_name();
// dump($a);
// dump(PHP_VERSION);
// dump(function_exists (mysql_close));
// dump(PHP_OS);
// dump($_SERVER ['SERVER_SOFTWARE']);
// dump(mysql_get_server_info());
// var_dump($_SERVER['SERVER_NAME']);	
// echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件";
// dump(get_cfg_var ("upload_max_filesize"));
// include display('testh');

// $platformObj = new PlatformCurrency();
// $res = $platformObj->checkBail();
// dump($res);
// $data[] = ['id'=>161,'operator'=>'-',"field"=>'num',"step"=>2.0202];

$order  = D('Orders')->where(['out_trade_no'=>'20181013113513439257'])->find();
dump($order);
// 转账处理
// if($payType == 'platform'){
	// 平台币转账
	$dataEdit[] = ['id'=>['val'=>$order['buy_id'],"field"=>"uid"],'field'=>"num","operator"=>"+","step"=>$order['number']];
	$dataEdit[] = ['id'=>['val'=>$order['sell_id'],"field"=>"uid"],'field'=>"num","operator"=>"-","step"=>$order['number']];
	$additional[] = ["field"=>'type',"operator"=>'=',"val"=>'leka'];
	dump($dataEdit);
	M("Card_package")->dataModification($dataEdit,$additional);
// }