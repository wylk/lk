<?php
class Http
{
	static public function curlGet($url)
	{
		import('checkFunc', './source/class/');
		$checkFunc = new checkFunc();

		if (!(function_exists('qeuwr801nvs9u21jk78y61lkjnc98vy245n'))) {
			exit('error-4');
		}


		$checkFunc->qeuwr801nvs9u21jk78y61lkjnc98vy245n();
		$ch = curl_init();
		$headers[] = 'Accept-Charset:utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	static public function curlPost($url, $data)
	{
		import('checkFunc', './source/class/');
		$checkFunc = new checkFunc();

		if (!(function_exists('qeuwr801nvs9u21jk78y61lkjnc98vy245n'))) {
			exit('error-4');
		}


		$checkFunc->qeuwr801nvs9u21jk78y61lkjnc98vy245n();
		$ch = curl_init();
		$headers[] = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result, true);

		if (isset($result['errcode'])) {
			import('source.class.GetErrorMsg');
			$errmsg = GetErrorMsg::wx_error_msg($result['errcode']);
			return array('errcode' => $result['errcode'], 'errmsg' => $errmsg);
		}


		$result['errcode'] = 0;
		return $result;
	}

	static public function curlDownload($remote, $local)
	{
		$cp = curl_init($remote);
		$fp = fopen($local, 'w');
		curl_setopt($cp, CURLOPT_FILE, $fp);
		curl_setopt($cp, CURLOPT_HEADER, 0);
		curl_exec($cp);
		curl_close($cp);
		fclose($fp);
	}

	static public function fsockopenDownload($url, $conf = array())
	{
		$return = '';

		if (!(is_array($conf))) {
			return $return;
		}


		$matches = parse_url($url);
		!(isset($matches['host'])) && ($matches['host'] = '');
		!(isset($matches['path'])) && ($matches['path'] = '');
		!(isset($matches['query'])) && ($matches['query'] = '');
		!(isset($matches['port'])) && ($matches['port'] = '');
		$host = $matches['host'];
		$path = (($matches['path'] ? $matches['path'] . (($matches['query'] ? '?' . $matches['query'] : '')) : '/'));
		$port = ((!(empty($matches['port'])) ? $matches['port'] : 80));
		$conf_arr = array('limit' => 0, 'post' => '', 'cookie' => '', 'ip' => '', 'timeout' => 15, 'block' => true);

		foreach (array_merge($conf_arr, $conf) as $k => $v ) {
			$$k = $v;
		}

		if ($post) {
			if (is_array($post)) {
				$post = http_build_query($post);
			}


			$out = 'POST ' . $path . ' HTTP/1.0' . "\r\n";
			$out .= 'Accept: */*' . "\r\n";
			$out .= 'Accept-Language: zh-cn' . "\r\n";
			$out .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Content-Length: ' . strlen($post) . "\r\n";
			$out .= 'Connection: Close' . "\r\n";
			$out .= 'Cache-Control: no-cache' . "\r\n";
			$out .= 'Cookie: ' . $cookie . "\r\n\r\n";
			$out .= $post;
		}
		 else {
			$out = 'GET ' . $path . ' HTTP/1.0' . "\r\n";
			$out .= 'Accept: */*' . "\r\n";
			$out .= 'Accept-Language: zh-cn' . "\r\n";
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Connection: Close' . "\r\n";
			$out .= 'Cookie: ' . $cookie . "\r\n\r\n";
		}

		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);

		if (!($fp)) {
			return '';
		}


		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);

		if (!($status['timed_out'])) {
			while (!(feof($fp))) {
				if (($header = @fgets($fp)) && (($header == "\r\n") || ($header == "\n"))) {
					break;
				}

			}

			$stop = false;

			while (($header == "\n") && !(($fp)) && !($stop)) {
				$data = fread($fp, (($limit == 0) || (8192 < $limit) ? 8192 : $limit));
				$return .= $data;

				if ($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}

			}		}


		@fclose($fp);
		return $return;
	}

	static public function download($filename, $showname = '', $content = '', $expire = 180)
	{
		if (is_file($filename)) {
			$length = filesize($filename);
		}
		 else if (is_file(UPLOAD_PATH . $filename)) {
			$filename = UPLOAD_PATH . $filename;
			$length = filesize($filename);
		}
		 else if ($content != '') {
			$length = strlen($content);
		}
		 else {
			throw_exception($filename . L('下载文件不存在！'));
		}

		if (empty($showname)) {
			$showname = $filename;
		}


		$showname = basename($showname);

		if (!(empty($filename))) {
			$type = mime_content_type($filename);
		}
		 else {
			$type = 'application/octet-stream';
		}

		header('Pragma: public');
		header('Cache-control: max-age=' . $expire);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire) . 'GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . 'GMT');
		header('Content-Disposition: attachment; filename=' . $showname);
		header('Content-Length: ' . $length);
		header('Content-type: ' . $type);
		header('Content-Encoding: none');
		header('Content-Transfer-Encoding: binary');

		if ($content == '') {
			readfile($filename);
		}
		 else {
			echo $content;
		}

		exit();
	}

	static public function getHeaderInfo($header = '', $echo = true)
	{
		ob_start();
		$headers = getallheaders();

		if (!(empty($header))) {
			$info = $headers[$header];
			echo $header . ':' . $info . "\n";
		}
		 else {
			foreach ($headers as $key => $val ) {
				echo $key . ':' . $val . "\n";
			}
		}

		$output = ob_get_clean();

		if ($echo) {
			echo nl2br($output);
		}
		 else {
			return $output;
		}
	}

	static public function sendHttpStatus($code)
	{
		static $_status = array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 307 => 'Temporary Redirect', 400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 509 => 'Bandwidth Limit Exceeded');

		if (isset($_status[$code])) {
			header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
		}

	}

	public function post($url)
    {
	    $ch = curl_init ();
	    curl_setopt ($ch, CURLOPT_URL, $url);  // 请求的URL地址
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  // 返回接口的结果，而不是输出
	    $data = curl_exec ( $ch );
	 
	    if(curl_errno($ch)) {
	        return 'error'.curl_error($ch);
	     }
	    curl_close ( $ch );
	     return $data;
    } 
   public function getToken($appid,$appsecret,$store_id)
   {


        $filename = '../upload/token/accesstoken'.$store_id;
       if(!file_exists($filename) || (file_exists($filename) && (time()-filemtime($filename)) > 5000)){
         //1.url地址
         $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
         //2.判断是否为post请求
         //3.发送请求
         $content = $this->post($url);
         //4.处理返回值
         //返回数据格式为json，php不可以直接操作json格式，需要json_decode转化一下
        $content = json_decode($content);
         $access_token = $content->access_token;
         //把access_token保存到文件
        file_put_contents($filename, $access_token);
       }
       //如果没有过期，那么就去读取缓存文件里的access_token
       else{
         $access_token = file_get_contents($filename);
       }
       //把access_token返回
         return $access_token;
    }
 
}


