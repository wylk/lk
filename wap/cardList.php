<?php
require_once dirname(__FILE__).'/global.php';

// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// 获取店铺发卡的类型
$type = isset($_GET['type'])?$_GET['type']:'offset';
$user_card = D("Card_package")->where(['uid'=>$userId,'is_publisher'=>1,'type'=>$type])->find();
$card = D('Card')->where(['uid'=>$userId,'c_id'=>1,'card_id'=>$user_card['card_id']])->find();
$sum = D('Card')->where(['uid'=>$userId,'c_id'=>6,'card_id'=>$user_card['card_id']])->find();
$count_fand = D("Card_package")->where(['card_id'=>$user_card['card_id'],'is_publisher'=>0])->count('*');
$count_record = D("Record_books")->where(['card_id'=>$user_card['card_id']])->count('*');
//'SELECT sum(goods_price) as price,`paytime`,FROM_UNIXTIME(paytime,"%m-%d") as perdate FROM `pay_cashier_order` WHERE mid=209 AND  paytime >480000 AND paytime <=1501171170 AND  ispay=1 GROUP BY perdate ORDER BY paytime ASC';
include display("cardList");