<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = clear_html($_GET['cardId']);
$orderList = D("Record_books")->where(['card_id'=>$cardId])->select();

include display("transactionRecord");