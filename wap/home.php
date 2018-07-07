<?php
require_once dirname(__FILE__).'/global.php';
$user = D("User")->select();
foreach ($user as $k => $v) {
    $id = $v['id'];
    $UserAud[] = D('')->table(array('User'=>'p','Card_transaction'=>'op','card_package'=>'y'))->field('*')->where("`p`.`id`='$id' AND `p`.`id`=`op`.`uid` AND `p`.`id`=`y`.`uid`")->select();
}
$UserAud = array_filter($UserAud);
    // dump($UserAud);

// $res = D('')->table(array('User'=>'p','Card_transaction'=>'op','User_audit'=>'y'))->field('y.name,y.type,y.enterprise,op.num,op.price,op.limit')->where("`p`.`id`='$id' AND `p`.`id`=`op`.`uid` AND `p`.`id`=`y`.`uid`")->select();
include display('home');
echo ob_get_clean();
