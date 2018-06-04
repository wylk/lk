<?php

/* 手机端公共文件 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
define('GROUP_NAME','wap');
define('IS_SUB_DIR',true);
require_once PIGCMS_PATH.'source/init.php';

if (!empty($tmp_store_id) && !empty($_GET['sessid']) && !empty($_GET['token'])) { //对接粉丝登录
    $user = M('User');
    $tmp_sessid = trim($_GET['sessid']);
    $tmp_token = trim($_GET['token']);
    $tmp_openid = trim($_GET['wecha_id']);
    $user = $user->checkUser(array('session_id' => $tmp_sessid, 'token' => $tmp_token, 'third_id' => $tmp_openid, 'status' => array('>', 0)));


    if (!empty($user)) {
        $_SESSION['wap_user'] = $user;
        $_SESSION['wap_user']['store_id'] = $tmp_store_id;
        $_SESSION['sync_user'] = true;

		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = parse_url($url);
		parse_str($url['query'], $params);
		unset($params['token']);
		unset($params['wecha_id']);
		unset($params['sessid']);
		$params = http_build_query($params);
		$url['query'] = $params;
		if (function_exists('http_build_url')) {
			$redirect_url = http_build_url($url);
		} else {
			$url['scheme'] .= '://';
			$url['query'] = '?' . $url['query'];
			$redirect_url = implode('', $url);
		}
		redirect($redirect_url);
    }
}
$php_self 	= php_self();


$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();
/*是否移动端*/
$is_mobile = is_mobile();
/*是否微信端*/
$is_weixin = is_weixin();

//访问统计
function Analytics($store_id, $module, $title, $id)
{
    $analytics = M('Store_analytics');
    $ip = bindec(decbin(ip2long($_SERVER['REMOTE_ADDR'])));
    $time = time();
    $visit_id = $analytics->add(array('store_id' => $store_id, 'module' => $module, 'title' => $title, 'page_id' => $id, 'visited_time' => $time, 'visited_ip' => $ip));
    if (strtolower($module) == 'goods') {
        $product = M('Product');
        $product->analytics(array('product_id' => $id, 'store_id' => $store_id));

        echo $html 	= <<<EOM
		<script type="text/javascript">
            (function visit() {
                var start;
                var end;
                var duration = 0;
                start = new Date(); //用户访问时间
                $(window).bind('beforeunload', function(e) {
                    end = new Date(); //用户离开时间
                    duration = end.getTime() - start.getTime();
                    duration = duration / 1000; //单位秒
                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: 'visit.php',
                        data: {
                            'uid': {$_SESSION['wap_user']['uid']},
                            'store_id': {$store_id},
                            'module': '{$module}',
                            'page_id': {$id},
                            'visit_id': {$visit_id},
                            'duration': duration
                        }
                    });
                });
            })();
		</script>
EOM;
    } else {
        echo $html 	= <<<EOM
		<script type="text/javascript">
            (function visit() {
                var start;
                var end;
                var duration = 0;
                start = new Date(); //用户访问时间
                $(window).bind('beforeunload', function(e) {
                    end = new Date(); //用户离开时间
                    duration = end.getTime() - start.getTime();
                    duration = duration / 1000; //单位秒
                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: 'visit.php',
                        data: {
                            'visit_id': {$visit_id},
                            'duration': duration
                        }
                    });
                });
            })();
		</script>
EOM;
    }

}
//获取当前文件名称 （公用菜单选中效果）
function php_self(){
    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $php_self;
}

//wap报错页面
function wap_error ($msg = '发生错误', $redirect_url = '') {
	$error_msg = $msg;
	$redirect_url = !empty($redirect_url) ? $redirect_url : $_SERVER['HTTP_REFERER'];
	include display('error_404');
	exit;
}
