<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$id = clear_html($_GET['id']);
$userInfo = D("Card_package")->where(['id'=>$id])->find();
$cardId = $userInfo['card_id'];
$address = $userInfo['address'];

$where = "`card_id` ='".$cardId."' and( `get_address`='".$address."' or `send_address`='".$address."')";
$recordList = D("Record_books")->where($where)->order("createtime desc")->select();
// var_dump($recordList);
include display("recordBooks");