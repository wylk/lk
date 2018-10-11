<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

// 未付账订单
$where = " and out_trade_no != ''";
$unpaidOrderList = D("Orders")->where("buy_id=".$userId." and status=0 and ".$where)->order("create_time desc")->select();
// 付款订单
$paidOrderList = D("Orders")->where("buy_id = ".$userId." and status = 1".$where)->order("create_time desc")->select();
// 全部订单
$orderList = D("Orders")->where("buy_id = ".$userId.$where)->order("create_time desc")->select();
// 用户发布的所有评论
// $evaluate = D("Evaluate")->where(['uid'=>$userId])->order("createtime desc")->select();
$evaluate = D("Evaluate")->where("uid = ".$userId.$where)->order("createtime desc")->select();

include display("orderList");