<?php

require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
if(IS_POST){
	$data = clear_html($_POST);
	$res = D('Pay_img')->data(['status'=>$data['status']])->where(['id'=>$data['id']])->save();
	if($res){
		 dexit(["error"=>0,'msg'=>"修改成功"]);
	}else{
		 dexit(["error"=>1,'msg'=>"修改失败"]);
	}
}
$pay_type = D('Pay_type')->where(['status'=>1])->select();
foreach ($pay_type as $key => &$value) {
	$pay_img = D('Pay_img')->where(['uid'=>$wap_user['userid'],'type'=>$value['id']])->find();
	if($pay_img){
		$value['pay_status'] = $pay_img['status'];
		$value['pay_id'] = $pay_img['id'];
	}else{
		$value['pay_status'] = 2;
	}
}
include display('pay_zf');






