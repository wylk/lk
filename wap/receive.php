<?php
require_once dirname(__FILE__).'/global.php';

if(IS_POST){
    $_POST['carated_at'] = time();
    if(D('Orders')->data($_POST)->add()){
       dexit(['error'=>0,'msg'=>'购买成功']);
    }else{
       dexit(['error'=>1,'msg'=>'购买失败']);
    }
}

$id = $wap_user['userid'];
    $UserAud = D('')->table(array('User'=>'p','Card_transaction'=>'op','Card_package'=>'y'))->field('op.price,op.num,op.limit')->where("`p`.`id`='$id' AND `p`.`id`=`op`.`uid` AND `op`.`card_id`=`y`.`card_id`")->find();
include display('receive');
echo ob_get_clean();
