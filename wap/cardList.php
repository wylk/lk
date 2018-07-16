<?php
require_once dirname(__FILE__).'/global.php';

// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// 获取店铺发卡的类型
$cardBagList = D("Card_package")->where(['uid'=>$userId])->select();


include display("cardList");