<?php

$xml = file_get_contents("php://input");
$xmljson= json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA) );
$xmlarray=json_decode($xmljson,true);//将json转换成数组
// include './api.php';
if(isset($xmlarray['action'])){
   $resa = ['error'=>0,"msg"=>"有action"];
 }else{
   $resa = ['error'=>1,"msg"=>"无action"];
 }
 if(isset($xmlarray['phone'])==''){
    $res= ['error'=>2,"msg"=>"手机号不能为空"];
 }else{
    $res = ['error'=>3,"msg"=>"有值"];
 }
$data=json_encode($xmlarray);
echo $data;

// $arr;//把xml转化成数组
// // 1、验签 判断
// //2、判断必备参数
// // 3、进入函数处理
// $arr['action'] = 'addUser';
// $action=$arr['action'];
// //引入文件
// $api=new Api();
// $adduser=$api->$action($xmlarray);
// // 4返回值
// dexit(['res',"msg"]);




