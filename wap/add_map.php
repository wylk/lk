<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
$phone = isset($wap_user['phone']) ? $wap_user['phone'] : "";

$res=$_POST;
$data['lng']=$res['lnglat'][0];
$data['lat']=$res['lnglat'][1];
$data['id']=$userId;
$data['phone']=$phone;
$id=D('lk_map')->where(array('id' =>$data['id']))->find();
if($id==null){
    $add_lnglat=D('lk_map')->data($data)->add();
}else{
    $add_lnglat=D('lk_map')->data($data)->where(array('id' =>$data['id']))->save();
}
 dexit(["res"=>0,'msg'=>"设置位置成功"]);









