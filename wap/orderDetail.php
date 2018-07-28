<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$id = clear_html($_GET['id']);
$orderInfo = D("Orders")->where(['id'=>$id])->find();
include display("orderDetail");