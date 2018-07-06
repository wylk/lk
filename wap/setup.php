<?php
require_once dirname(__FILE__).'/global.php';

// 设置
$userInfo = D("User")->field("id,name,phone,wx_openId,ali_userid,upwd,pay_password")->where("phone=".$phone)->select();
$userInfo = transformArray($userInfo);

include display('setup');
echo ob_get_clean();
exit();

