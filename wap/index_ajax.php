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
        $s_id = $data['plugin'];
        if(!empty($s_id)){
           $where = "and b.s_id=$s_id";
        }else{
            $where = '';
        }


        $lng = $data['lng'];
        $lat = $data['lat'];

        $join = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$lng}*PI()/180-`sc`.`lng`*PI()/180)/2),2)))*1000)";

       /* $store_list_min = D('')->table(array('Store_contact'=>'sc','Store'=>'s'))->field("`s`.`store_id`,`s`.`name`,`s`.`logo`,`s`.`distance`,`s`.`specified_amount`,`sc`.`address`,`s`.`intro`,".$join."AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND s.drp_supplier_id = '0' AND `s`.`status`='1' AND ".$join."<5000")->order("`juli` ASC")->limit(12)->select();*/


        $store_package = D('')->table("User_audit as b")
                  ->join('Card_package as a ON a.uid=b.uid','LEFT')
                  ->join('Card as c ON b.uid=c.uid','LEFT')
                  ->join('Map as sc ON sc.uid=a.uid','LEFT')
                  ->field("a.card_id as card_id,b.*,c.val as logo,$join as juli,sc.lng as lng,sc.lat as lat")
                  ->where("a.is_publisher=1 and a.type='offset' and c.c_id=2 and c.type='offset' and b.status=1 and b.isdelete=0 $where")
                  ->order("`juli` ASC")
                  ->limit((($data['i']-1)*10).",10")
                  ->select();
        //dump($store_package);die;
	if($store_package){

        $str = '';
        $mapinfo = array();
        foreach ($store_package as $k => $v) {
            if($v['juli']){
                $mapinfo[$k]['lng'] = $v['lng'];
                $mapinfo[$k]['lat'] = $v['lat'];
                $mapinfo[$k]['enterprise'] = $v['enterprise'];
                if($v['juli']>1000){
                    $juli = round(($v['juli']/1000),2).'km';
                }else{
                    $juli = ($v['juli']/1).'m';
                }
                $str .=  <<<EOM
                <a  href="./home.php?card_id={$v['card_id']}&plugin=offset&shoreUid={$v['uid']}" >
                <div class="store">
    	            <div class="img">
    	                <img src="{$v['logo']}" class="imgs"/>
    	            </div >
    	            <div class="price">
    	            	<div>{$v['enterprise']}</div>
    	            	<div><span style="color:red;font-size:20px;">6-7</span>&nbsp;&nbsp;折卡券&nbsp;&nbsp;已购<span style="color:red;font-size:15px;">30万</span></div>
    	            </div>
    	            <div class="num">
    	            	<div>{$juli}</div>
    	            	<div style="font-size:13px;color:#e88d0b;">正在抢购</div>
    	            </div>
    	         </div></a>

EOM;
            }
        }

        dexit(['error'=>0,'msg'=>$str,'mapinfo'=>$mapinfo]);
    }else{
        dexit(['error'=>1,'msg'=>'加载完成']);
    }

}
