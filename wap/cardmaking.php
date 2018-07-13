<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
if(IS_POST){
  $postData = clear_html($_POST);
  import('Hook');
  $hook = new Hook($postData['contract']);
  $hook->add($postData['contract']);
  $res = $hook->exec('add',[['postData'=>$postData,'uid'=>$wap_user['userid']]]);
  if($res){
    header("location:cardType.php");
  }
}

import('Hook');
$contract = $_GET['card'];
$hook = new Hook($contract);
$hook->add($contract);
$html = $hook->exec('add_tpl');

include display('cardmake');
echo ob_get_clean();
