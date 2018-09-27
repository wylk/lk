<?php
if (!(function_exists('qeuwr801nvs9u21jk78y61lkjnc98vy245n'))) {
	function qeuwr801nvs9u21jk78y61lkjnc98vy245n()
	{
	}
}


if (!(function_exists('fdsrejsie3qklwewerzdagf4ds'))) {
	function fdsrejsie3qklwewerzdagf4ds()
	{
	}
}


if (!(function_exists('fdsrejsie3qklwewerzdagf4dsz62hs5z421s'))) {
	function fdsrejsie3qklwewerzdagf4dsz62hs5z421s()
	{
	}
}

class checkFunc
{
	public $key;
	public $topdomain;
	private $emergent_mode;

	public function __construct()
	{
		global $_G;

		if (empty($_G)) {
			$conf = C('config');
		}
		 else {
			$conf = $_G['config'];
		}

		$this->key = trim($conf['service_key']);
		$this->emergent_mode = intval($conf['emergent_mode']);
		$this->topdomain = trim($conf['server_topdomain']);

		if (!($this->topdomain)) {
			$this->topdomain = $this->getTopDomain();
		}


		if (empty($_COOKIE['my_version'])) {
			/*$checkUrl = 'http://up.pigcms.cn/oa/admin.php?m=server&c=sys_file&a=getCustomer&domain=' . $this->topdomain . '&productid=4';
			$return = $this->curl_exe($checkUrl, '');
			$return = json_decode($return, true);
   
			if ($return['success'] == 1) {
				setcookie('my_version', $return['version'], time() + (60 * 60 * 24 * 7));
			}*/

		}

	}

	public function curl_exe($url, $data = '', $time = 2)
	{
		$ch = curl_init();
		$header = array('Accept-Charset: utf-8');
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $time);
		$tmpInfo = curl_exec($ch);
		$errorno = curl_errno($ch);

		if ($errorno) {
			return $errorno;
		}


		return $tmpInfo;
	}

	public function getTopDomain()
	{
		$host = ((isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : ((isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . (($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT']))))));
		$host = strtolower($host);

		if (strpos($host, '/') !== false) {
			$parse = @parse_url($host);
			$host = $parse['host'];
		}


		$topleveldomaindb = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me', 'asia');
		$str = '';

		foreach ($topleveldomaindb as $v ) {
			$str .= (($str ? '|' : '')) . $v;
		}

		$matchstr = '[^\\.]+\\.(?:(' . $str . ')|\\w{2}|((' . $str . ')\\.\\w{2}))$';

		if (preg_match('/' . $matchstr . '/ies', $host, $matchs)) {
			$domain = $matchs[0];
			if (($domain == 'weihubao.com') || ($domain == 'dazhongbanben.com')) {
				$domain = $host;
			}

		}
		 else {
			$domain = $host;
		}

		return $domain;
	}

	private function check()
	{
		if ($this->allow()) {
			return true;
		}


		/*$remoteStr = $this->curl_exe($this->getServer(), '');
		if (($remoteStr == 28) || ($remoteStr == 6)) {
			$remoteStr = $this->curl_exe($this->getServer(1), '', 5);

			if ($remoteStr == 28) {
				exit('wow-100');
			}
			 else if ($remoteStr == 6) {
				exit('wow-101');
			}

		}*/


		$rt = json_decode($remoteStr, 1);

		if ($remoteStr != 1) {
			/*if (is_array($rt)) {
				switch (intval($rt['success'])) {
				case -1:
					exit('wow' . $rt['success'] . ':error domain format');
					break;

				case -2:
					exit('wow' . $rt['success'] . ':out of date');
					break;

				case -3:
					exit('wow' . $rt['success'] . ':correct customer in system');
					break;

				case -4:
					exit('wow' . $rt['success'] . ':unknown');
					break;

				case -5:
					exit('wow' . $rt['success'] . ':error ip source');
					break;

				case -6:
					exit('wow' . $rt['success'] . ':error key');
					break;
				}

				exit('wow' . $rt['success']);
			}
			 else {
				//exit('wow');
			}*/
		}


		S('__encryptcode', md5('error'), 3600 * 24 * 5);
	}

	private function allow()
	{
		if ($this->emergent_mode) {
			return true;
		}


		if (S('__encryptcode')) {
			return true;
		}


		if ($this->topdomain == 'pigcms.cn') {
			return true;
		}


		if ($this->dateValidate()) {
			return true;
		}


		return false;
	}

	private function dateValidate()
	{
		$currentHourOfDay = intval(date('H'));
		$currentDayOfWeek = date('w');
		$currentMonth = date('n');
		$currentDay = date('j');
		$currentDate = $currentMonth . '.' . $currentDay;
		$nationalDay = array('10.1', '10.2', '10.3', '10.4', '10.5', '10.6', '10.7');
		$mayDay = array('5.1', '5.2', '5.3');
		$newYearDay = array('1.1');
		$midAutumnDay = array('9.26', '9.27');
		$allowDate = array_merge($nationalDay, $mayDay, $newYearDay, $midAutumnDay);
		if (($currentHourOfDay < 9) || (17 <= $currentHourOfDay)) {
			return true;
		}


		if (($currentDayOfWeek == 0) || ($currentDayOfWeek == 6)) {
			return true;
		}


		if (in_array($currentDate, $allowDate)) {
			return true;
		}


		return false;
	}

	public function fgwixklwudffqdfoevbrwobbbb()
	{
		$this->check();
	}

	public function sduwskaidaljenxsyhikaaaa()
	{
		$this->check();
	}

	public function cfdwdgfds3skgfds3szsd3idsj()
	{
		$this->check();
	}

	public function qeuwr801nvs9u21jk78y61lkjnc98vy245n()
	{
		$this->check();
	}

	private function getServer($num = NULL)
	{
		return 'http://up' . $num . '.pigcms.cn/func.php?key=' . $this->key . '&domain=' . $this->topdomain . '&productid=4';
	}
}


?>