<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// $cardWhere['is_publisher'] = 0;
$cardWhere['uid'] = $userId;
$cardList = D("Card_package")->where($cardWhere)->select();
// var_dump($card);

include display('card_package');
echo ob_get_clean();
