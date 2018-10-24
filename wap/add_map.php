<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
$phone = isset($wap_user['phone']) ? $wap_user['phone'] : "";
$res=$_POST;
$data['lng']=$res['lnglat'][0];
$data['lat']=$res['lnglat'][1];
$data['uid']=$userId;
$uid=D('User_audit')->where(array('uid'=>$userId))->select();
if($uid){
$add_lnglat=D('User_audit')->data($data)->where(array('uid' =>$userId))->save();
}else{
 $add_lnglat=D('User_audit')->data($data)->add();
}
dexit(["res"=>0,'msg'=>"设置位置成功"]);









