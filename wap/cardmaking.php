<?php
require_once dirname(__FILE__).'/global.php';
if(IS_POST){
  $postData = clear_html($_POST);
  import('Hook');
  $hook = new Hook($postData['contract']);
  $hook->add($postData['contract']);
  $res = $hook->exec('add',[['postData'=>$postData,'uid'=>$wap_user['userid']]]);
}

 function clearHtml($array,$exception = ''){
  $exception = explode(',',$exception);
  foreach($array as $key=>$value){
    if(in_array($key,$exception)){
      $array[$key] = stripslashes($value);
    }else{
      $array[$key] = trim(htmlspecialchars($value));
    }
  }
  return $array;
}
import('Hook');
$contract = $_GET['card'];
$hook = new Hook($contract);
$hook->add($contract);
$html = $hook->exec('add_tpl');

include display('cardmake');
echo ob_get_clean();
