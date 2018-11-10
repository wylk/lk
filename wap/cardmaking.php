<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
 import('Hook');
$user_audit = D('User_audit')->where(array('uid' =>$wap_user['userid']))->find();
if(!$user_audit){
    redirect('./cardType.php'); 
}else{
    if(!$user_audit['lat']){
        redirect('./map.php?referer='.urlencode($_SERVER['REQUEST_URI']));
    }
}
if(IS_POST){
  $postData = clear_html($_POST);
  // 发卡前平台币是否冻结判断
  
  if(option('config.card_currency_set')){
  	$userInfo = D("Card_package")->where(['uid'=>$wap_user['userid'],"type"=>option("hairpan_set.platform_type_name")])->find();
  	$limit = option('config.card_currency_limit');
  	$limit = str_replace("：",":",$limit);
  	$limitArr = explode(":", $limit);
    // 发卡前平台币冻结
  	$frozenCurrency = $postData['sum']/$limitArr[1]*$limitArr[0];
  	dexit(['error'=>1,"msg"=>(float)$frozenCurrency."---".(float)$userInfo['num']]);
  	if((float)$frozenCurrency > (float)$userInfo['num']){
  		dexit(['error'=>1,"msg"=>"平台币不足"]);
  	}
  	$frozenList[] = ['id'=>$userInfo['id'],"operator"=>"+","step"=>$frozenCurrency,"field"=>"frozen"];
    $frozenList[] = ['id'=>$userInfo['id'],"operator"=>"-","step"=>$frozenCurrency,"field"=>"num"];
  	M("Card_package")->frozen($frozenList);
  }

  $hook = new Hook($postData['contract']);
  $hook->add($postData['contract']);
  $hook->exec('add',[['postData'=>$postData,'uid'=>$wap_user['userid']]]);
}
$contract = $_GET['card'];
$hook = new Hook($contract);
$hook->add($contract);
$html = $hook->exec('add_tpl');

include display('cardmake');
echo ob_get_clean();
