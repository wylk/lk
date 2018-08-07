<?php 
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$packageId = clear_html($_GET['id']);

$userInfo = D("Card_package")->where(['id'=>$packageId])->find();
$address = $userInfo['address'];
$cardId = $userInfo['card_id'];
$where = "`card_id` ='".$cardId."' and ( `get_address`='".$address."' or `send_address`='".$address."' )";
$orderList = D("Record_books")->where($where)->select();

include display("myDeal");