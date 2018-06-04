<?php
if (!(defined('PIGCMS_PATH'))) {
	exit('deny access!');
}


register_shutdown_function('fatalError');
set_error_handler('appError');
set_exception_handler('appException');
defined('DEBUG') || define('DEBUG', false);

if (DEBUG == true) {
	error_reporting(1 | 2 | 4 | 8);
}
 else {
	error_reporting(0);
}

header('Content-Type: text/html; charset=UTF-8');
header('X-Powered-By:pigcms.com');
date_default_timezone_set('Asia/Shanghai');
session_name('pigcms_sessionid');
if (!(my_session_start())) {
	session_id(md5(uniqid()));
	session_start();
	session_regenerate_id();
}


setcookie(session_name(), session_id(), $_SERVER['REQUEST_TIME'] + 63072000, '/');
defined('GROUP_NAME') || define('GROUP_NAME', 'index');
defined('MODULE_NAME') || define('MODULE_NAME', (isset($_GET['c']) ? strtolower($_GET['c']) : 'index'));
defined('ACTION_NAME') || define('ACTION_NAME', (isset($_GET['a']) ? strtolower($_GET['a']) : 'index'));
defined('APP_PATH') || define('APP_PATH', '');
defined('DATA_PATH') || define('DATA_PATH', PIGCMS_PATH . 'cache/data/');
defined('CACHE_PATH') || define('CACHE_PATH', PIGCMS_PATH . 'cache/cache/');
defined('USE_FRAMEWORK') || define('USE_FRAMEWORK', false);
defined('IS_SUB_DIR') || define('IS_SUB_DIR', false);
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET', (REQUEST_METHOD == 'GET' ? true : false));
define('IS_POST', (REQUEST_METHOD == 'POST' ? true : false));
define('IS_PUT', (REQUEST_METHOD == 'PUT' ? true : false));
define('IS_DELETE', (REQUEST_METHOD == 'DELETE' ? true : false));
define('MUI_PATH','../static/mui/');
define('AMAZE_PATH','../static/amazeui/');
define('JS_PATH','../template/wap/default/js/');
define('ALERT_PATH','../static/sweetalert/');
define('JS1_PATH','../static/js/area/');
define('IS_AJAX', (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false));
define('CND_PATH', 'lk.com/');
/* 添加本地目录 在原有基础上前面添加WY_*/
define('WY_TPL_URL', CND_PATH.'/template/wap/default/');//定义手机端样式目录
define('WY_CND_PATH', CND_PATH.'/static/');         //全局静态文件存放js/img/css.....

define('FRICT_STORE_B', 100);
require_file(PIGCMS_PATH . 'source/class/360_safe3.php');
require_file(PIGCMS_PATH . 'source/functions/common.php');

foreach ($_GET as &$get_value ) {
	$get_value = htmlspecialchars(str_replace(array('<', '>', '\'', '"', '(', ')'), '', $get_value));
}

doStripslashes();
$_G['system'] = require_file(PIGCMS_PATH . 'config/config.php');
$config = F('config');
if (empty($config)) {
	$configs = D('Config')->field('`name`,`value`')->select();
	foreach ($configs as $key => $value ) {
		$config[$value['name']] = $value['value'];
	}

	F('config', $config);
}


$_G['config'] = $config;
$static_domain = rtrim(CND_PATH, '/');

if (option('system.STATIC_RESOURCE') == 'off') {
	$static_domain = rtrim($config['site_url'], '/');
}
$wap_url = option('config.wap_site_url');

if (APP_PATH) {
	$static_domain = $static_domain . '/' . rtrim(APP_PATH, '/');
}


defined('TPL_PATH') || define('TPL_PATH', PIGCMS_PATH . 'template/');
defined('TPL_URL') || define('TPL_URL', (!(IS_SUB_DIR) ? $static_domain . '/template/' . GROUP_NAME . '/' . $_G['config']['theme_' . GROUP_NAME . '_group'] . '/' : $static_domain . '/template/' . GROUP_NAME . '/' . $config['theme_' . GROUP_NAME . '_group'] . '/'));

defined('STATIC_PATH') || define('STATIC_PATH', PIGCMS_PATH . 'static/');
defined('STATIC_URL') || define('STATIC_URL', $static_domain . '/static/');

if (USE_FRAMEWORK == true) {
	R(GROUP_NAME, MODULE_NAME, ACTION_NAME);
	echo ob_get_clean();
}

function my_session_start()
{
	if (ini_get('session.use_cookies') && isset($_COOKIE['pigcms_sessionid'])) {
		$sessid = $_COOKIE['pigcms_sessionid'];
	}
	 else if (!(ini_get('session.use_only_cookies')) && isset($_GET['pigcms_sessionid'])) {
		$sessid = $_GET['pigcms_sessionid'];
	}
	 else {
		session_start();
		return false;
	}

	if (!(preg_match('/^[a-zA-Z0-9,\\-]{22,40}$/', $sessid))) {
		return false;
	}


	session_start();
	return true;
}

function pigcms_tips($msg, $url = '', $isAutoGo = false, $showCopy = true)
{
	if (IS_AJAX) {
		echo json_encode(array('msg' => $msg, 'url' => $url));
	}
	 else {
		if (empty($url)) {
			$url = 'javascript:history.back(-1);';
		}


		if ($msg == '404') {
			header('HTTP/1.1 404 Not Found');
			$msg = '抱歉，你所请求的页面不存在！';
		}


		include PIGCMS_PATH . 'source/sys_tpl/tip.php';
	}

	exit();
}

function appException($e)
{
	$error = array();
	$error['message'] = $e->getMessage();
	$trace = $e->getTrace();

	if ('throw_exception' == $trace[0]['function']) {
		$error['file'] = $trace[0]['file'];
		$error['line'] = $trace[0]['line'];
	}
	 else {
		$error['file'] = $e->getFile();
		$error['line'] = $e->getLine();
	}

	halt($error);
}

function appError($errno, $errstr, $errfile, $errline)
{
	switch ($errno) {
	case 1:

	case 4:

	case 16:

	case 64:

	case 256:
		ob_end_clean();

		if (DEBUG) {
			pigcms_tips($errno . '' . $errstr . ' ' . $errfile . ' 第 ' . $errline . ' 行.', 'none');
		}
		 else {
			pigcms_tips($errno . '' . $errstr . ' ' . basename($errfile) . ' 第 ' . $errline . ' 行.', 'none');
		}

		break;

	case 8:

	case 2048:
		break;

	case 2048:

	case 512:

		if ($errno . '' . $errstr . ' ' . basename($errfile) . ' 第 ' . $errline . ' 行.') {
			pigcms_tips($errstr . ' ' . $errfile . ' 第 ' . $errline . ' 行.', 'none');
		}
		 else {
			pigcms_tips($errstr . ' ' . basename($errfile) . ' 第 ' . $errline . ' 行.', 'none');
		}
	}
}

function fatalError()
{
	if ($e = error_get_last()) {
		switch ($e['type']) {
		case 1:

		case 4:

		case 16:

		case 64:

		case 256:
			ob_end_clean();

			if (DEBUG) {
				pigcms_tips('ERROR:' . $e['message'] . ' ' . $e['file'] . ' 第' . $e['line'] . ' 行.', 'none');
			}
			 else {
				pigcms_tips('ERROR:' . $e['message'] . ' ' . basename($e['file']) . ' 第' . $e['line'] . ' 行.', 'none');
			}

			break;
		}
	}

}

function require_file($load_file)
{
	if (file_exists($load_file)) {
		return require $load_file;
	}


	$file = str_replace(PIGCMS_PATH, '', $load_file);
	pigcms_tips(PIGCMS_PATH . $file . ' 文件不存在。', 'none');
}


?>
