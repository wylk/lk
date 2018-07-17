<?php
/**
 *  乐卡帮助库
 */
class comm_util_pub
{
	public $appid;
	public $mchid;
	public $key;

	function __construct($appid,$mchid,$key)
	{
		$this->appid = $appid;
		$this->mchid = $mchid;
		$this->key   = $key;
	}

	/**
     *  作用：产生随机字符串，不长于32位
     */
	public function trimeString($value)
	{
		$ret = null;
		if($value != null){
			$ret = $value;
			if(strlen($ret) == 0){
				$ret =null;
			}
		}
		return $ret;
	}

	/**
	*  作用：产生随机字符串，不长于32位
	*/
    public function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

	/**
     *  作用：格式化参数，签名过程需要使用
     */
    public function  formatBizQuerParaMap($paraMap, $urlencode)
    {
    	$buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v){
            if($urlencode){
               $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0){
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }
    /**
     *  作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v){
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQuerParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$this->key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //$String = sha1($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }
    /**
     *  作用：array转xml
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
             if (is_numeric($val))
             {
                $xml.="<".$key.">".$val."</".$key.">";

             }
             else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     *  作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
        //return $xml;
        //return json_decode($xml,true);
    }

    public function jsonArray($xml)
    {
    	$xmlData = json_decode($xml,true);
        if(is_null($xmlData)){
            return $xml;
        }else{
            return $xmlData;
        }
    }

        /**
     *  作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml,$url,$second=30)
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        curl_close($ch);
        //返回结果
        if($data){
            return $data;
        }else{
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            return false;
        }
    }

    public function postXmlSSLCurl($xml,$url,$second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, getcwd() . '/source/class/pay/Weixinnewpay/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, getcwd() . '/source/class/pay/Weixinnewpay/apiclient_key.pem');
        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /**
     *  作用：打印数组
     */
    public function printErr($wording='',$err='')
    {
        print_r('<pre>');
        echo $wording."</br>";
        var_dump($err);
        print_r('</pre>');
    }

}

class yp_client_pub extends comm_util_pub
{
	public $parameters;
	public $response;//微信返回的响应
    public $result;//返回参数，类型为关联数组
	public $url;
	public $curl_timeout;

	public function setParameter($parameter,$value)
	{
		$this->parameters[$parameter] = $value;
	}

	function createXml()
    {
        $this->parameters["appid"] = $this->appid;//公众账号ID
        $this->parameters["mch_id"] = $this->mchid;//商户号
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);
    }

     /**
     *  作用：post请求xml
     */
    function postXml()
    {
        $xml = $this->createXml();
        $this->response = $this->postXmlCurl($xml,$this->url,$this->curl_timeout);
        return $this->response;
    }

    /**
     *  作用：使用证书post请求xml
     */
    function postXmlSSL()
    {
        $xml = $this->createXml();
        arrlog($xml,'xml1');
        $this->response = $this->postXmlSSLCurl($xml,$this->url,$this->curl_timeout);
        return $this->response;
    }

    /**
     *  作用：获取结果，默认不使用证书
     */
    function getResult()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->response);
        return $this->result;
    }

}

//微信支付
class weixin_api extends yp_client_pub
{
    public function __construct($appid,$mchid,$key)
    {
        comm_util_pub::__construct($appid,$mchid,$key);
        $this->url = 'http://lk.com/wap/notice.php';
        $this->curl_timeout = 60;
    }

    public function createXml()
    {
        try{
            $this->parameters["appid"] = $this->appid;//公众账号ID
            $this->parameters["mch_id"] = $this->mchid;//商户号
            //$this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters);//签名
            return  $this->parameters;
        }catch(Exception $e){
            print $e->getMessage(); exit();
        }
    }

    public function pay()
    {
        $this->postXml();
        return $this->jsonArray($this->response);
    }

}

/*
调用demo
$appid  = 'ep7941ffea4379e027';
$mchid = '1483239892';
$key    = 'epoiqg81tlknwgqiqlk0815ymdvqi1lk';
$yp = new yp_name_api($appid,$mchid,$key);
$yp->setParameter('mobile',18811480487);
$yp->setParameter('password','111111');
$re = $yp->getData();
var_dump($re);
*/