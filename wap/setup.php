<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
// 退出登录
if(isset($_POST['type']) && $_POST['type'] == "signOut"){
    session_destroy();
    if(is_weixin()){
        dexit(['error'=>0,'msg'=>'清除成功']);
    }else{
        dexit(['error'=>0,'msg'=>'退出成功']);
    }
}
$userId = $wap_user['userid'];
$user = D('User')->where(['id'=>$userId])->find();
include display('setup');
echo ob_get_clean();
exit();

