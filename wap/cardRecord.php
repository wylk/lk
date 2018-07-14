<?php 
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = clear_html($_GET['cardId']);
$recordList = D("Card_package")->where(['card_id'=>$cardId])->select();


include display("cardRecord");