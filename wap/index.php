<?php
require_once dirname(__FILE__).'/global.php';

/*import('Hook');
$a = $_GET['card'];
$hook = new Hook($a);
$hook->add($a);
$html = $hook->exec('add_tpl');*/
// 认证店铺
$storeInfo = D("User_audit")->where(['status'=>1,"type"=>2])->select();
// $storeUids = array_column($storeInfo,"uid");

// 获取卡券的id
D("Card_package")->where(['type'=>"offset"])->select();




include display('index');
echo ob_get_clean();
