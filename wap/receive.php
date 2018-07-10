<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$userId = $wap_user['userid'];
if(IS_POST){
    $_POST['carated_time'] = time();
    $_POST['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    $_POST['buy_id'] = $userId;
    $_POST['sole_id'] = $_POST['uid'];
    unset($_POST['uid']);
    dump($userId);
    $res = D('Orders')->data($_POST)->add();
    if($res){
       dexit(['error'=>0,'msg'=>'购买成功']);
    }else{
       dexit(['error'=>1,'msg'=>'购买失败']);
    }


    $card = $_POST['']
}

// dump($_SESSION);

$UserAud = D("Card_transaction")->where(array('id'=>$_GET['id']))->find();

include display('receive');
echo ob_get_clean();
