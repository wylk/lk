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
        $store_package = D('')->table("User_audit as b")
                  ->join('Card_package as a ON a.uid=b.uid','LEFT')
                  ->join('Card as c ON b.uid=c.uid','LEFT')
                  ->where("a.is_publisher=1 and a.type='offset' and c.c_id=2 and c.type='offset' and b.status=1 and b.isdelete=0 $where")
                  ->field("a.card_id as card_id,b.*,c.val as logo")
                  ->limit((($data['i']-1)*10).",10")
                  ->select();
                  // var_dump($store_package);die();
	if($store_package){

        $str = '';
        foreach ($store_package as $k => $v) {
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
	            	<div>300m</div>
	            	<div style="font-size:13px;color:#e88d0b;">正在抢购</div>
	            </div>
	         </div></a>

EOM;
    }
        dexit(['error'=>0,'msg'=>$str]);
    }else{
        dexit(['error'=>1,'msg'=>'加载完成']);
    }

}
