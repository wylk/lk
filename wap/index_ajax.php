<?php
require_once dirname(__FILE__).'/global.php';


if(IS_POST){

    $action  = $_GET['action']?$_GET['action']:'index';

    switch ($action) {
        case 'index':
                $data = clear_html($_POST);
                index($data);
            break;
        case 'eww':
            break;
        default:
            # code...
            break;
    }

}

function index($data){

        if($data['plugin'] > 1){
           $where = "and b.s_id=".($data['plugin']-1);
        }else{
            $where = '';
        }
        $lng = $data['lng'];
        $lat = $data['lat'];
        $_SESSION['map']['lng'] = $lng; 
        $_SESSION['map']['lat'] = $lat; 
        $join = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`b`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`b`.`lat`*PI()/180)*POW(SIN(({$lng}*PI()/180-`b`.`lng`*PI()/180)/2),2)))*1000)";
        $store_package = D('')->table("User_audit as b")
                  ->join('Card_package as a ON a.uid=b.uid','LEFT')
                  ->join('Card as c ON b.uid=c.uid','LEFT')
                  //->join('Map as sc ON sc.uid=a.uid','LEFT')
                  ->field("a.card_id as card_id,b.*,c.val as logo,$join as juli")
                  ->where("a.is_publisher=1 and a.type='offset' and c.c_id=2 and c.type='offset' and b.status=1 and b.isdelete=0 $where")
                  ->order("`juli` ASC")
                  ->limit((($data['i'])*10).",10")
                  ->select();
	   if($store_package){
            $str = '';
            $mapinfo = array();
            foreach ($store_package as $k => $v) {

                if($v['juli']){
                    /*$mapinfo[$k]['lng'] = $v['lng'];
                    $mapinfo[$k]['lat'] = $v['lat'];
                    $mapinfo[$k]['enterprise'] = $v['enterprise'];*/
                    if($v['juli'] > 1000){
                        $juli = round(($v['juli']/1000),2);
                        $m = 'km';
                    }else{
                        $juli = ($v['juli']/1);
                        $m = 'm';
                    }
                    $whe = 'card_id="'.$v['card_id'].'" and status=0 and frozen<num';
                    $max = D('Card_transaction')->where($whe)->max('price');

                    $min = D('Card_transaction')->where($whe)->min('price');
                    $z = '折';
                    $color = 'red';
                    
                    if(empty($max)){
                        $color = 'black_9';
                        $max_min = "售完";
                        $z = '';
                    }else if($max == $min){
                        $max_min = round($max *10,1);
                    }else{
                        $max_min = round($min*10,1).'-'.round($max*10,1);
                    }
                  
                    $str .=  <<<EOM
                    <li class="mui-table-view-cell">
                    <a  href="./home.php?card_id={$v['card_id']}&plugin=offset&shoreUid={$v['uid']}" style="display:flex">
                    
        	            
        	           <img src="{$v['logo']}" class="imgs"/>
        	            
        	            <div class="mui-media-body flex-grow font17">
        	            	{$v['enterprise']}
        	            	<p class="mui-ellipsis"><span class="{$color}">{$max_min}</span>{$z}</p>
        	            </div>
        	            <div class="num">
        	            	<div class="black_9"><span >{$juli}</span>{$m}</div>
        	            </div>
        	         </a>
                     <li>
EOM;
                }
            }

            dexit(['error'=>0,'msg'=>$str]);
        }else{
            dexit(['error'=>1,'msg'=>'加载完成']);
        }

}
