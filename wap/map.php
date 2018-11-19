<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

if(IS_POST){
	$userId = $wap_user['userid'];
	$data = clear_html($_POST);
	
	if(D('User_audit')->data($data)->where(array('uid' =>$userId))->save()){
		dexit(['error'=>0,'msg'=>'设置成功']);
	}else{
		dexit(['error'=>1,'msg'=>'设置失败']);
	}
}
//var url = "<?php echo './login.php?referer='.urlencode($_SERVER['REQUEST_URI']);
$referer = $_GET['referer']?$_GET['referer']:'my.php';
if (strpos($referer,'&amp;')) {
    $referer = str_replace('&amp;','&',$referer);
}
include display('map');
echo ob_get_clean();
exit();
