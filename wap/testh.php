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

// // 微信支付
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



// 回调测试
// $userId = $wap_user['userid'];
// // dump($userId);
// // $order  = D('Orders')->where(['out_trade_no'=>"20181020151223148583"])->find();
// $cardId = "0b170a15dd8ea510bd0267c9d8b2ae73";

// // dump();die();
// $data = $order = D('Orders')->where(['out_trade_no'=>"20181023183350877126"])->find();
// $sendAddress = D('Card_package')->field('address')->where(['uid'=>$order['sell_id'],'card_id'=>$order['card_id']])->find();
// $getAddress = D('Card_package')->field('address,is_publisher,bail')->where(['uid'=>$order['buy_id'],'card_id'=>$order['card_id']])->find();
// // $data = $order;
// $data['sendAddress'] = "c0391df98c9e521d06f8e683228e63e4";
// $data['getAddress'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// $data['type'] = "8ce142b799fad5ee468cfeff0ceb21c7";

// // $data['tran_id'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['sell_id'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['buy_id'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['card_id'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['number'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['price'] = "8ce142b799fad5ee468cfeff0ceb21c7";
// // $data['out_trade_no'] = "8ce142b799fad5ee468cfeff0ceb21c7";

// dump($data);
// // die();

// import("CardAction");
// $card = new CardAction(['userid'=>$userId]);
// // $data = ['cardId'=>$cardId,'getAddress'=>$id,"sendAddress","num","type",""];
// $sellRes = $card->payTran($data);
// dump($sellRes);

// $editList[] = ['id'=>['field'=>"uid","val"=>$userId],"field"=>"frozen","operator"=>"+","step"=>$num];
// $editList[] = ['id'=>['field'=>"uid","val"=>$userId],"field"=>"num","operator"=>"-","step"=>$num];
// $addition[] = ['field'=>"card_id","val"=>$cardId,"operator"=>'='];
// $res = M("Card_package")->dataModification($editList,$addition);
// dump($res);

// $xml = "<xml><appid><![CDATA[wxcf45e0f03cb2fe06]]></appid>
// <bank_type><![CDATA[CFT]]></bank_type>
// <cash_fee><![CDATA[10]]></cash_fee>
// <fee_type><![CDATA[CNY]]></fee_type>
// <is_subscribe><![CDATA[Y]]></is_subscribe>
// <mch_id><![CDATA[1504906041]]></mch_id>
// <nonce_str><![CDATA[1L4NoXan0mG5dWg75KxGRESLu1hhFPZ6]]></nonce_str>
// <openid><![CDATA[o3DhqwYWyDquFkGfPz6bAwj2POD0]]></openid>
// <out_trade_no><![CDATA[20181024141515119353]]></out_trade_no>
// <result_code><![CDATA[SUCCESS]]></result_code>
// <return_code><![CDATA[SUCCESS]]></return_code>
// <sign><![CDATA[3F4E9FF986C9A68105CA60A03405378A]]></sign>
// <time_end><![CDATA[20181024141523]]></time_end>
// <total_fee>10</total_fee>
// <trade_type><![CDATA[JSAPI]]></trade_type>
// <transaction_id><![CDATA[4200000204201810243021513395]]></transaction_id>
// </xml>";
// return $xml;

// $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
// dump($array_data);
// $sign = $array_data['sign'];
// unset($array_data['sign']);
// dump($array_data);
// $check = new weixin_pay(option('config.platform_weixin_appid'),option('config.platform_weixin_mchid'),option('config.platform_weixin_key'));
// $res = $check->getSign($array_data);
// if($res != $sign) echo "失败";
// else echo "成功";

// function checkSign($xml){
// 	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
// 	// dump($array_data);
// 	foreach($array_data as $key=>$value){
// 		if($key == "sign") continue;
// 		$str .= $key."=".$value."&";
// 	}
// 	$str = md5(substr($str, 0,-1));
// 	// dump($str);dump($array_data['sign']);
// 	if($str == $array_data['sign']){
// 		echo "验证通过";
// 	}else{
// 		echo "验证失败";
// 	}
// 	return $str;
// }
// $res = checkSign($xml);
// dump($res);
$num = 4;
if(IS_POST){
	$page = $_POST['page'];
	if($page == 1) $limit = $num;
	else $limit = ($page-1)*$num.",".$num;
	$bookRes = D("Record_books")->limit($limit)->select();
	if($bookRes)
		dexit(['error'=>0,"msg"=>"第".$page."页数据","data"=>["data"=>$bookRes,"page"=>$page+1,"limit"=>$num]]);
	else
		dexit(['error'=>1,"msg"=>"加载失败","data"=>$bookRes]);
}

// $bookRes = D("Record_books")->limit("15,30")->select();
// dump($bookRes);
include display('testh');