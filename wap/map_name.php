<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
 $userId = $wap_user['userid'];
 $res=$_POST;
 $data['address']=$res['name'];
 $data['uid']=$userId;
 $uid=D('User_audit')->where(array('uid'=>$userId))->select();
 if($uid){
    $map_name=D('User_audit')->data($data)->where(array('uid' =>$userId))->save();
}else{
     $map_name=D('User_audit')->data($data)->add();
}

 if($map_name){
     dexit(["res"=>1,'msg'=>"设置位置完成"]);
 }







