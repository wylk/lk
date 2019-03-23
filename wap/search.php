<?php
require_once dirname(__FILE__).'/global.php';


if(IS_POST){
	$data = clear_html($_POST);
	if(!empty($data['tag'])){
       	$where = "and (b.enterprise like '%".$data['tag']."%' or c.val like '".$data['tag']."')";
    }else{
        dexit(['error'=>1,'msg'=>'加载完成']);
    }
    $lng = isset($_SESSION['map']['lng'])?$_SESSION['map']['lng']:0;
    $lat = isset($_SESSION['map']['lat'])?$_SESSION['map']['lat']:0;

    $join = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`b`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`b`.`lat`*PI()/180)*POW(SIN(({$lng}*PI()/180-`b`.`lng`*PI()/180)/2),2)))*1000)";
    $store_package = D('')->table("User_audit as b")
              ->join('Card_package as a ON a.uid=b.uid','LEFT')
              ->join('Card as c ON b.uid=c.uid','LEFT')
              ->field("a.card_id as card_id,b.*,c.val as logo,$join as juli")
              ->where("a.is_publisher=1 and a.type='offset' and c.c_id=2 and c.type='offset' and b.status=1 and b.isdelete=0 $where")
              ->order("`juli` ASC")
              ->limit($data['i'].",10")
              ->select();
   if($store_package){
        foreach ($store_package as $k => &$v) {
            $whe = 'card_id="'.$v['card_id'].'" and status=0 and frozen<num';
            $v['max'] = D('Card_transaction')->where($whe)->max('price');
            $v['min'] = D('Card_transaction')->where($whe)->min('price');
        }
        dexit(['error'=>0,'msg'=>$store_package]);
    }else{
        dexit(['error'=>1,'msg'=>'加载完成']);
    }

}
//dump($_SESSION);
include display("search");