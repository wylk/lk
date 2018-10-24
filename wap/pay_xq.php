<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$user = D('User')->where(['id'=>$wap_user['userid']])->find();
$verifyLen = "6";  //验证码长度
$tex=$_GET['type'];

if(IS_POST){
       $res=$_POST;
       $pwd=md5($res['password']);
       if($pwd != $user['pay_password']){
            dexit(["res"=>2,'msg'=>"支付密码输入错误"]);
        }
        $data['pay_num']=$res['pay_num'];
        $data['pay_img'] =$res['pay_img'];
        $data['pay_type']=$res['type'];
        // var_dump($data);die;
        $rag=D('User')->data($data)->where(array('id'=>$user['id']))->save();

        dexit(["res"=>0,'msg'=>"支付宝设置完成"]);



}

include display('pay_qx');




