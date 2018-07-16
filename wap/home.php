<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$userId = $wap_user['userid'];
// echo $userId;

// $user = D("User")->select();
// foreach ($user as $k => $v) {
//     $id = $v['id'];
//     $UserAud[] = D('')->table(array('User'=>'p','Card_transaction'=>'op','card_package'=>'y'))->field('*')->where("`p`.`id`='$id' AND `p`.`id`=`op`.`uid` AND `p`.`id`=`y`.`uid`")->select();
// }
// $UserAud = array_filter($UserAud);


// $res = D('')->table(array('User'=>'p','Card_transaction'=>'op','User_audit'=>'y'))->field('y.name,y.type,y.enterprise,op.num,op.price,op.limit')->where("`p`.`id`='$id' AND `p`.`id`=`op`.`uid` AND `p`.`id`=`y`.`uid`")->select();

$storeUid = clear_html($_GET['shoreUid']);
$tranList = D("Card_transaction")->where(['uid'=>$storeUid,'status'=>0])->order('createtime desc')->select();
foreach($tranList as $key=>$value){
	if(!in_array($value['uid'],$uids)){
		$uids[] = $value['uid'];
	}
}
$uidInfo = D("User_audit")->field("uid,type,name")->where(['uid'=>['in',$uids]])->select();
$type = array_column($uidInfo,null,'uid');
include display('home');
echo ob_get_clean();
