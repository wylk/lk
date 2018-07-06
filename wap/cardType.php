<?php
require_once dirname(__FILE__).'/global.php';
$cardRes = M("Contract")->find();
$res = D("Card_package")->where(['uid'=>"1530523825"])->select();
$cardtype = array_column($res, "type");
$cardtype = array_map(function($value,$key){return $value.="Card";}, $cardtype);

include display('cardType');
echo ob_get_clean();
