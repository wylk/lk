<?php
require_once dirname(__FILE__).'/global.php';
$userid = $wap_user['userid'];


// $res = $obj->addEntrust();
$res = check($userid);
// dump($res);die;

function check($userid){
    // 判断用户是否认证
     $userJudge = D("User_audit")->where(array('uid'=>$userid,'status'=>1))->find();
    if($userJudge==null){
     dexit(['res'=>1,"msg"=>"请先认证","url"=>"./postcard.php"]);
    }
    //判断用户有没有设置位置
    $map=D("Map")->where(array('uid'=>$userid))->find();
    if($map==null){
         dexit(['res'=>2,"msg"=>"请先输入地理位置","url"=>"./setup.php"]);
    }
    //判断用户有没有设置支付管理
    $pay_img=D("Pay")->where(array('uid'=>$userid))->find();
    if($pay_img==null){
         dexit(['res'=>3,"msg"=>"请设置支付管理","url"=>"pay_zf.php"]);
    }
     dexit(['res'=>0,"msg"=>"成功"]);
}

