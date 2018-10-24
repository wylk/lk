<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
 $userId = $wap_user['userid'];
 $res=$_POST;
 $data['address']=$res['name'];
 $map_name=D('User_audit')->data($data)->where(array('uid' =>$userId))->save();
 if($map_name){
     dexit(["res"=>1,'msg'=>"设置位置完成"]);
 }







