<?php 
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = clear_html($_GET['cardId']);
$orderList = D("Orders")->where(['sell_id'=>$userId,"card_id"=>$cardId,'status'=>1])->select();
// var_dump($orderList);

include display("myDeal");