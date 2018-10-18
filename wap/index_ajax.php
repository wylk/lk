<?php
require_once dirname(__FILE__).'/global.php';



 $one=$_POST['one'];
 if($one){
   $res=D('Shopclass')->where(array('name'=>$one))->find();
   $s_id=$res['id'];
   add($s_id);
 }
 $too=$_POST['too'];
 if($too){
   $res=D('Shopclass')->where(array('name'=>$too))->find();
   $s_id=$res['id'];
   add($s_id);
 }
 $stree=$_POST['stree'];
 if($stree){
   $res=D('Shopclass')->where(array('name'=> $stree))->find();
   $s_id=$res['id'];
   add($s_id);
 }
 $val=$_POST['val'];
 if($val){
   $res=D('Shopclass')->where(array('name'=> $val))->find();
   $s_id=$res['id'];
  add($s_id);
 }

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
function add($s_id){
    // var_dump($s_id);die;
        $store = D('')->table("Card_package as a")
                  ->join('User_audit as b ON a.uid=b.uid','LEFT')
                  ->join('Card as c ON a.uid=c.uid','LEFT')
                  ->where("a.is_publisher=1 and c.c_id=2 and b.status=1 and b.isdelete=0 and b.s_id=$s_id")
                  ->field("a.card_id as card_id,b.*,c.val as logo")
                  ->select();
    if($store){

        $str = '';
        foreach ($store as $k => $v) {
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
        dexit(['error'=>1,'msg'=>'没有店铺']);
    }



}

function index($data){
        $store_package = D('')->table("Card_package as a")
                  ->join('User_audit as b ON a.uid=b.uid','LEFT')
                  ->join('Card as c ON a.uid=c.uid','LEFT')
                  ->where("a.is_publisher=1 and c.c_id=2 and b.status=1 and b.isdelete=0")
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
