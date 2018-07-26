<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

import("PlatformCurrency");
$platformObj = new PlatformCurrency();
$orderList = $platformObj->selectOrderList(['userId'=>$userId,'status'=>1]);

include display('card_orderlist');
echo ob_get_clean();
