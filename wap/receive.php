<?php
require_once dirname(__FILE__).'/global.php';
 // $uid = $_GET['uid'];
if(IS_POST){
    $_POST['carated_at'] = time();
    $_POST['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    $_POST['buy_id'] = $_SESSION['admin']['id'];
    // $_POST['uid'] = $uid;
    // dump($_POST);
    $res = D('Orders')->data($_POST)->add();
    if($res){
         import('LkApi');
         $api = new LkApi(['appid'=>'23432','mchid'=>'1273566173','key'=>'sdagjjjjjk']);
         $payData['order_id'] = $res;
         $rwx = $api->weixinPay($payData);
         dump($rwx);
         die;
       dexit(['error'=>0,'msg'=>'购买成功']);
    }else{
       dexit(['error'=>1,'msg'=>'购买失败']);
    }
}

$UserAud = D("Card_transaction")->where(array('id'=>$_GET['id']))->find();

include display('receive');
echo ob_get_clean();
