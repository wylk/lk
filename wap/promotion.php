<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$card = D('Card')->where(['uid'=>$wap_user['userid'],'c_id'=>1])->find();
include display('promotion');
echo ob_get_clean();
exit();