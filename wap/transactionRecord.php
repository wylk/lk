<?php
require_once dirname(__FILE__).'/global.php';
// 判断是否登录状态中
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];

$cardId = clear_html($_GET['cardId']);
if(IS_POST){
	$limitNum = 15;
	$page = $_POST['page'];
	if(empty($page)) $page = 1;
	if($page == 1) $limit = $limitNum;
	else $limit = $limitNum*($page -1) .",". $limitNum;
	$orderList = D("Record_books")->where(['card_id'=>$cardId])->order("createtime desc")->limit($limit)->select();
	if($orderList)
		dexit(['error'=>0,"msg"=>"转账数据","data"=>['data'=>$orderList,"limit"=>$limitNum,"page"=>$page+1]]);
	dexit(['error'=>1,"msg"=>"无转账数据","data"=>['data'=>$orderList,"limit"=>$limitNum,"page"=>$page+1]]);
}

include display("transactionRecord");