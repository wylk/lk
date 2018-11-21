<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

if(IS_POST){
   $data = clear_html($_POST);
   $user = D('User')->where(['id'=>$wap_user['userid']])->find();
    if(!$user['pay_password']){
        dexit(["res"=>3,'msg'=>"未设置支付密码"]);
    }
    if(md5($data['password']) != $user['pay_password']){
        dexit(["res"=>2,'msg'=>"支付密码输入错误"]);
    }
    $pay_img = D('Pay_img')->where(['uid'=>$user['id'],'type'=>$data['type']])->find();

    if($data['post_type'] == 'add'){
        if($pay_img){
            dexit(["res"=>1,'msg'=>"保存失败"]);
        }
        if(D('Pay_img')->data(['name'=>$data['name'],'account'=>$data['pay_num'],'uid'=>$wap_user['userid'],'type'=>$data['type'],'img'=>$data['pay_img']])->add()){
            dexit(["res"=>0,'msg'=>"保存成功"]);
        }else{
            dexit(["res"=>1,'msg'=>"保存失败"]);
        }
        
    }else{
        
        if($pay_img['img'] != $data['pay_img']){
            unlink('..'.$pay_img['img']);
        }
        if(D('Pay_img')->data(['name'=>$data['name'],'account'=>$data['pay_num'],'img'=>$data['pay_img']])->where(['id'=>$data['id']])->save()){
            dexit(["res"=>0,'msg'=>"保存成功"]);
        }else{
            dexit(["res"=>1,'msg'=>"保存失败"]);
        }
   }
}
$pay_img = D('Pay_img')->where(['uid'=>$wap_user['userid'],'type'=>$_GET['type']])->find();
if($pay_img){
   $post_type = 'save'; 
}else{
   $post_type = 'add';  
}

$referer_url = './pay_pw.php?referer='.urlencode($_SERVER['REQUEST_URI']);
$verifyLen = "6";  //验证码长度
$tex=$_GET['type'];

include display('pay_qx');




