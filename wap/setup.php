<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
$user = D('User')->where(['id'=>$userId])->find();
include display('setup');
echo ob_get_clean();
exit();

