<?php
class Express
{
	static public function kuadi100($url)
	{
		$ch = curl_init();
		$headers[] = 'Accept-Charset:utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.kuaidi100.com/all/qfkd.shtml?from=newindex');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$content_arr = json_decode($result, true);

		if ($content_arr['status'] != '200') {
			$url_parse = parse_url($url);
			parse_str($url_parse['query'], $output);
			$url = 'https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?appid=4001&com=' . $output['type'] . '&nu=' . $output['postid'];
			return Express::baidu($url);
		}


		return $result;
	}

	static public function baidu($url)
	{
		ob_start();
		$ch = curl_init();
		$headers[] = 'Accept-Charset:utf-8';
		$cookieFile = LEKA_PATH . 'cache/cookie.txt';
		curl_setopt($ch, CURLOPT_URL, 'http://www.baidu.com/');
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		$result = curl_exec($ch);
		curl_close($ch);
		ob_clean();
		$ch = curl_init();
		$headers[] = 'Accept-Charset:utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.baidu.com');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($result);
		$return_data = array();

		if ($data->status == '0') {
			$return_data['status'] = 200;

			if (is_array($data->data->info->context)) {
				foreach ($data->data->info->context as $context ) {
					$tmp = array();
					$tmp['time'] = date('Y-m-d H:i:s', $context->time);
					$tmp['context'] = $context->desc;
					$return_data['data'][] = $tmp;
				}
			}
			 else {
				$return_data['status'] = 1;
			}

			return json_encode($return_data);
		}


		return json_encode(array('status' => 1));
	}
}


?>