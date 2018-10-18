<?php

require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$user = D('User')->where(['id'=>$wap_user['userid']])->find();


include display('pay_zf');






