<?php
/**
* 随行付支付
*/
class Bank
{
	// 公钥
	public $privateKey = "<<<EOD
-----BEGIN RSA PRIVATE KEY-----\nMIICXAIBAAKBgQDcg7tpQEQicK7bKY6ShoqNjsO8a2DZcxI70szZLzYsklg+lQOaaz3DEN8Ysc+uahSuEVl2bG0b5Ksusp38OZYgIizaieOMXN06Elpqfullr4vmNDgBTr3wdIlsBbj3L1k6fvZYifrokAhU7kHK0KC+7r4uop5b9f95NNUg9eoC6wIDAQABAoGAcAMSTbJxabUnfPgtDcz90E42qx04QvyqxGyd1ayfriBgZtm2zNewtcd6K8cWoZgNDSaO9RK6kbKkKcJdceOml5aH4rLMddmMrBHuvGngbJEhYUSwxAUnUdKq7FMNzDYW8WS1mthk+zg8Ww6u/OWrdiGf+9XAXx/WmhZXeNZsFTECQQD0v7YCIlgC3xjf+PuHWApoB/VbYptv94zZxDUEfVAK5deq3ipFC74hjv17ovBUkDU2coGS5rmYDE2feZneMJWFAkEA5qbS14WWLwBoqbkgpb1i1Zifs50d+Cgyxe+v0Jm869vdx2IGBRPtSWVmMGy3yEUL+ufNcDW2c59VoATt5LOprwJAF+iKXRcBxfYJNgfaelQtYBA29aBiUsO57KPwEeoz4XymXripJGmLPzf6pxM5qukTaagx5CnJw4KgKo30a/IPCQJBAONRmw7KG7/q+Tv8to5iXpwAtbTBrp26kH+/wFkoi6cwpB0zIJe0kfH6O4KSQ3bfhfUcq75hUZYWfL8e3I6/+wUCQGt4U0KNgVzIaRJ0vcqFagIixXmqOXb73TnqlxhfFRG9RaNGXO3cOOKFUR4gl8+NvU85BgPKX0liTWCCeCo/3D0=\n-----END RSA PRIVATE KEY-----
EOD";
// 银行私钥
	public $sxfpublic = "<<<EOD
-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOmsrFtFPTnEzfpJ/hDl5RODBxw4i9Ex3NmmG/N7A1+by032zZZgLLpdNh8y5otjFY0E37Nyr4FGKFRSSuDiTk8vfx3pv6ImS1Rxjjg4qdVHIfqhCeB0Z2ZPuBD3Gbj8hHFEtXZq8+msAFu/5ZQjiVhgs5WWBjh54LYWSum+d9+wIDAQAB\n-----END PUBLIC KEY-----
EOD";
	// function __construct()
	// {
	// 	# code...
	// }
	public function test($data,$url){
		$getSign = $this->getSign($data);
		// $url = "https://payapi-test.suixingpay.com/management/product/qrcodeProductSetup";
		$postRes = $this->postCurl($url,$getSign);
		// dump($postRes);
		$checkRes = $this->checkVerify($postRes);
		if($checkRes) return json_decode($postRes,true);
		else return $checkRes;
	}
	public function postCurl($url,$paramStr){
		$curl = curl_init();
		$this_header = array("content_type:application/x-www-form-urlencoded;charset=UTF-8");
		curl_setopt($curl,CURLOPT_HTTPHEADER,$this_header);
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_HEADER,0);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$paramStr);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array(
			'Content-Type:application/json',
			'Content-Length: '.strlen($paramStr)
		));
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,true);
		$tmpInfo = curl_exec($curl);   //返回api的json对象
		curl_close($curl); //关闭URL请求
		return $tmpInfo;

	}
	public function checkVerify($data){
		$info = json_decode($data,JSON_UNESCAPED_UNICODE);
		$newsign = $info['sign'];
		unset($info['sign']);
		ksort($info);
		$infoStr = $this->arrToStr($info);
		$checkRes = $this->verify($infoStr,$newsign,$this->sxfpublic);
		// dump($checkRes);
		if($checkRes) echo "验证成功";
		else echo "验证失败";
		return $checkRes;
	}
	public function getSign($json){
		$myParams = json_decode($json,true);
		ksort($myParams);
		$reqStr = $this->arrToStr($myParams);
		$sign = $this->rsaSign($reqStr,$this->privateKey);
		$myParams['sign'] = $sign;
		return json_encode($myParams,JSON_UNESCAPED_SLASHES);
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public function arrToStr($param){
		$params = [];
		foreach($param as $key=>$value){
			if(is_array($value))
				$value = stripslashes(json_encode($value,JSON_UNESCAPED_UNICODE));
			$params[] = $key."=".$value;
		}
		return implode('&',$params);
	}
	/**
	 * RSA签名
	 * @param $data 待签名数据
	 * @param $privateKey 私钥
	 * return 签名结果
	 */
	public function rsaSign($data,$privateKey){
		$res = openssl_get_privateKey($privateKey);
		openssl_sign($data,$sign,$res);
		openssl_free_key($res);
		// base64编码
		$sign = base64_encode($sign);
		return $sign;
	}
	/**RSA验签
	 * $data待签名数据
	 * $sign需要验签的签名
	 * 验签用支付宝公钥
	 * return 验签是否通过 bool值
	 */
	public function verify($data,$sign,$pubKey){
		$res = openssl_get_publickey($pubKey);
		$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		openssl_free_key($res);
		return $result; //返回资源是否成功
	}
}