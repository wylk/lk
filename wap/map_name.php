<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
 $userId = $wap_user['userid'];
 $res=$_POST;
 $data['map_name']=$res['map_name'];
 $map_name=D('lk_map')->data($data)->where(array('id' =>$userId))->save();
 if($map_name){
     dexit(["res"=>1,'msg'=>"设置位置完成"]);
 }






