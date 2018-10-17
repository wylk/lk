<?php
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$cardRes = D("Contract")->where(['status'=>1])->order('`sort` asc')->select();
$res = D("Card_package")->where(['uid'=>$wap_user['userid'],"is_publisher"])->select();
$cardtype = array_column($res, "type");
$cardtype = array_map(function($value,$key){return $value.="Card";}, $cardtype);

include display('cardType');
echo ob_get_clean();
