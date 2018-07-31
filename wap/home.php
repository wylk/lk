<?php
require_once dirname(__FILE__).'/global.php';
// if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

// $userId = $wap_user['userid'];

$storeUid = clear_html($_GET['shoreUid']);
// 获取该店铺中发布所有的卡片
$shoreInfos = D("Card_package")->where(['uid'=>$storeUid,'is_publisher'=>1])->find();

$tranList = D("Card_transaction")->where(['card_id'=>$shoreInfos['card_id'],"status"=>0])->order('createtime desc')->select();
foreach($tranList as $key=>$value){
	if(!in_array($value['uid'],$uids)){
		$uids[] = $value['uid'];
	}
}
$uidInfo = D("User_audit")->field("uid,type,name")->where(['uid'=>['in',$uids]])->select();
$type = array_column($uidInfo,null,'uid');
include display('home');
echo ob_get_clean();
