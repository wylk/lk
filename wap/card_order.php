<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];


import("PlatformCurrency");
$platformObj = new PlatformCurrency();
$orderList = $platformObj->selectOrderList(['userId'=>$userId,'status'=>['in',['0','1']]]);

include display('card_order');
echo ob_get_clean();
