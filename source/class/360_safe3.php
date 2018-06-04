<?php
$referer = ((empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER'])));
set_error_handler('customError', 1);
$getfilter = '\'|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)';
$postfilter = '\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)';
$cookiefilter = '\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)';

if (isset($_GET)) {
	foreach ($_GET as $key => $value ) {
		if (strExist($value, '>') || strExist($value, '<script') || (strExist($key, ';') && !(strExist($key, '404;'))) || (strExist($key, 'put') && !(strExist($key, 'input'))) || strExist($value, 'eval') || strExist($value, '"') || strExist($value, '\'')) {
		}


		stopattack($key, $value, $getfilter, 'get');
	}
}


if (isset($_POST)) {
	if (!(isset($_POST['except']))) {
		foreach ($_POST as $key => $value ) {
			stopattack($key, $value, $postfilter, 'post');
		}
	}

}


if (isset($_COOKIE)) {
	foreach ($_COOKIE as $key => $value ) {
		stopattack($key, $value, $cookiefilter, 'cookie');
	}
}


if (isset($referer)) {
	foreach ($referer as $key => $value ) {
		stopattack($key, $value, $getfilter, 'referer');
	}
}

function customError($errno, $errstr, $errfile, $errline)
{
	echo '<b>Error number:</b> [' . $errno . '],error on line ' . $errline . ' in ' . $errfile . '<br />';
	exit();
}

function StopAttack($StrFiltKey, $StrFiltValue, $ArrFiltReq, $type = '')
{
	if (($type == 'post') && ($StrFiltKey == 'referer')) {
	}
	 else {
		$StrFiltValue = arr_foreach($StrFiltValue);

		if (preg_match('/' . $ArrFiltReq . '/is', $StrFiltValue) == 1) {
			print('<div style=\\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\\"><br>' . $type . '请不要提交html、script等代码类数据，系统在您自己的服务器上不会碰到类似问题，请测试其他功能，感谢支持。!</div>');
			exit();
		}


		if (preg_match('/' . $ArrFiltReq . '/is', $StrFiltKey) == 1) {
			print('<div style=\\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\\"><br>' . $type . '请不要提交html、script等代码类数据，系统在您自己的服务器上不会碰到类似问题，请测试其他功能，感谢支持</div>');
			exit();
		}

	}
}

function slog($logs)
{
	$toppath = $_SERVER['DOCUMENT_ROOT'] . '/log.htm';
	$Ts = fopen($toppath, 'a+');
	fputs($Ts, $logs . "\r\n");
	fclose($Ts);
}

function arr_foreach($arr)
{
	static $str;

	if (!(is_array($arr))) {
		return $arr;
	}


	foreach ($arr as $key => $val ) {
		if (is_array($val)) {
			arr_foreach($val);
		}
		 else {
			$str[] = $val;
		}
	}

	return implode($str);
}

function strExist($haystack, $needle)
{
	return !(strpos($haystack, $needle) === false);
}


?>