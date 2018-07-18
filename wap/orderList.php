<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 为付账订单
$unpaidOrderList = D("Orders")->where(['buy_id'=>$userId,"status"=>0])->order("create_time desc")->select();
// 付款订单
$paidOrderList = D("Orders")->where(['buy_id'=>$userId,"status"=>1])->order("create_time desc")->select();
// var_dump($paidOrderList);
// 全部订单
$orderList = D("Orders")->where(['buy_id'=>$userId])->order("create_time desc")->select();
// 用户发布的所有评论
$evaluate = D("Evaluate")->where(['uid'=>$userId])->order("createtime desc")->select();

include display("orderList");