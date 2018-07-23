<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$packageInfo = D("Card_package")->where(['uid'=>$userId,"type"=>"leka"])->find();
$orderWhere = "(`buy_id` = ".$userId." or `sell_id` = ".$userId.") and `card_id` = '".$packageInfo['card_id']."' and status = 1";
$orderList = D("Orders")->where($orderWhere)->order("create_time desc")->select();



include display('card_orderlist');
echo ob_get_clean();
