<?php
header("Content-type: text/html; charset=utf-8");
/* 店铺管理 */

define('PIGCMS_PATH', dirname(__FILE__).'/');
define('GROUP_NAME', 'user');
define('USE_FRAMEWORK', true);

$url 	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if(strpos($url,'amp;amp;')) {
	$url1 	= str_replace('amp;amp;','',$url);
	header('Location: '.$url1);
	exit;
}
require_once PIGCMS_PATH.'source/init.php';

?>