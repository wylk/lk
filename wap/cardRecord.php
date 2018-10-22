<?php 
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = clear_html($_GET['cardId']);
$recordList = D("Card_package")->where(['card_id'=>$cardId,"is_publisher"=>0])->select();
// dump($recordList);
$uid = array_column($recordList, "uid");
$userInfoRes = D("User")->where(['id'=>['in',$uid]])->select();
// dump($userInfoRes);
foreach($userInfoRes as $key=>$value){
	$userInfo[$value['id']]['name'] = $value['name'];
	$userInfo[$value['id']]['avatar'] = $value['avatar'];
}
// $userInfo = array_column($userInfo, null,"id");
// var_dump($userInfo);
include display("cardRecord");