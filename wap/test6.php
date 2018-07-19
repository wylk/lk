<?php
require_once dirname(__FILE__).'/global.php';

import('LkApi');
$obj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
$res = $obj->geth_api(['phone'=>'13967426223','c'=>'Geth','a'=>'add_account']);
dump($res);
/*function encrypt($data,$key){
    $encryptedList = array();
    $step          = 11700;
    $encryptedData = '';
    $len = strlen($data);
    for ($i = 0; $i < $len; $i += $step) {
       $tmpData   = substr($data, $i, $step);
       $encrypted = '';
        openssl_public_encrypt($tmpData, $encrypted, $key,OPENSSL_PKCS1_PADDING);
       $encryptedList[] = ($encrypted);
    }
     $encryptedData = base64_encode(join('', $encryptedList));
    return $encryptedData;
}

$public_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqWgSnGR1Q2zsICgq0hmqh22BvTGqyPelEv3mXzuQ9CNq6xmxYHPzcGqabjP0r/2tJE465AfD2Gf6EGT6LU2h6qxx0Jw3firixZmwyWJ6M5lqWJA0p2bjdUCqK2H7/+s6J3uTXJvLNggoaI2SXaJOoACq5uk4Rm6g7CN9TJNdxTlga6fOSUjzI6N3ba27Jmp4laWHFhHl93rKPSx/mv08p7P5sj9GMJMAHwFvjq+/xiUlX2kzW0qqQT3eXv7I8J6Qu6J8vb3K8UqUGd2DOoC9iVOiqtcp2u5uMSk+pgQqMK6UvnTQ838WxbEy9tnAB5MWzEmZETvC+5OHGTdEBqnCUQIDAQAB
-----END PUBLIC KEY-----';
import('AccountBook');*/

//$token = json_encode(['uid'=>'1','contract_id'=>'33d2433410e3a8d5912f051792bf1910','sendAddress'=>'dc6c49af4b9eafd383a462e4242564f5','num'=>100,'getAddress'=>'a7c1b739593c67db34d66261ec86fd42']);
//$token = json_encode(['uid'=>'1','contract_id'=>'33d2433410e3a8d5912f051792bf1910','account_balance'=>100]);

/*$encryptedData = encrypt($token,$public_key);
$bb = new AccountBook();*/

//$bb->transferAccounts($encryptedData);//转账
//$bb->addAccount($encryptedData);//添加新地址
/*$da = D('Account_book')->data(['now'=>1])->where(['id'=>['in',[80,81]]])->save();
dump($da);*/

// $card = D('Card')->where()->select();
// $Contract_field = D('Contract_field')->where()->select();
// $Contract_fields = [];
// foreach ($Contract_field as $kk => $vv) {
//     $Contract_fields[$vv['id']] = $vv['val'];
// }
// //dump($Contract_fields);
// $cards = array();
// foreach ($card as $k => $v) {
//     $cards[$v['card_id']][$Contract_fields[$v['c_id']]] = $v['val'];
//     $cards[$v['card_id']]['uid'] = $v['uid'];
// }
// dump($cards);
/*import('Hook');
$contract = $_GET['card'];
$hook = new Hook($contract);
$hook->add($contract);
$html = $hook->exec('add_tpl');*/
/*include display('sell');*/
echo ob_get_clean();
