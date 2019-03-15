<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$card_package = D('Card_package')->where(['uid'=>$wap_user['userid'],'type'=>'offset','is_publisher'=>1])->find();

include display("release_group");