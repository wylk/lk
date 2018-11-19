<?php
require_once dirname(__FILE__).'/global.php';
$user = D('User')->where(['id'=>$wap_user['userid']])->find();
if(empty($user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
if(IS_POST){
	$postData = clear_html($_POST);
	
	if(isset($postData['old_pwd'])){
		if(md5($postData['old_pwd']) != $user['pay_password']){
			dexit(['error'=>1,'msg'=>'原密码错误!']);
		}
	}

	if(D('User')->data(['pay_password'=>md5($postData['pay_password'])])->where(['id'=>$wap_user['userid']])->save()){
		dexit(['error'=>0,'msg'=>'修改成功']);
	}else{
		dexit(['error'=>1,'msg'=>'修改失败']);
	}
	
}

$redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id='.$_COOKIE['wap_store_id'] : $config['site_url']));
import('HtmlForm');
$htmls = new HtmlForm('add_pw',"./pay_pw.php");

if($user['pay_password'] != null){
	$htmls->input(['old_pwd','旧密码','password'],['required']);           
}

$htmls->input(['pay_password','新密码','password'],['pay_password',['reg','pwd']]);
$htmls->input(['t_pay_password','再输一次','password'],['t_pay_password',['with','pay_password','两次密码不一致！']]);
$htmls->resSuccess($redirect_uri);


include display('pay_pw');