<?php
class weixin_pay
{
    /*
    配置参数
    */
    public $config = array(
        'appid' => "wxcf45e0f03cb2fe06",    /*微信开放平台上的应用id*/
        'mch_id' => "1504906041",   /*微信申请成功之后邮件中的商户id*/
        'api_key' => "7458e55e72ea67b4e03c8380668a8793",    /*在微信商户平台上自己设定的api密钥 32位*/
        // 'notify_url' => 'https://mall.epaikj.com/wap/paynotice.php' 
    );
    public $trade_type;
    // public $notify_url = 'success.php'; /*自定义的回调程序地址id*/
    // public $notify_url = option("config.wap_site_url").'/notice.php'; /*自定义的回调程序地址id*/
    // public $notify_url = option('config.wap_site_url') . '/notice.php';
    public $notify_url = 'https://bcc.51ao.com/wap/notice.php';

    public function  __construct($appid=null,$mch_id=null,$api_key=null) {
        $this->config['appid'] = empty($appid) ? $this->config['appid'] : $appid;
        $this->config['mch_id'] = empty($mch_id) ? $this->config['mch_id'] : $mch_id;
        $this->config['api_key'] = empty($api_key) ? $this->config['api_key'] : $api_key;
    }

    //获取预支付订单
    public function getPrePayOrder($body, $out_trade_no, $total_fee,$openid=false,$trade_type = 'APP')
    {
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $onoce_str = $this->getRandChar(32);
        $data["appid"] = $this->config["appid"];
        $data["body"] = $body;
        $data["mch_id"] = $this->config['mch_id'];
        $data["nonce_str"] = $onoce_str;
        $data["notify_url"] =  $this->notify_url;
        $data["out_trade_no"] = $out_trade_no;
        $data["spbill_create_ip"] = $this->get_client_ip();
        $data["total_fee"] = $total_fee*100;
        if($openid){
          $data["openid"] = $openid;
        }
        $data["trade_type"] = $trade_type;
        $this->trade_type = $trade_type;

        $s = $this->getSign($data);
        $data["sign"] = $s;
// return $data;
        $xml = $this->arrayToXml($data);

        $response = $this->postXmlCurl($xml, $url);
        
        //将微信返回的结果xml转成数组
        $wxdata  = $this->xmlstr_to_array($response);

        if($wxdata['return_code'] == 'SUCCESS'){
            $paydata = $this->getOrder($wxdata['prepay_id']);
            return $paydata;exit();
        }else{
            echo json_encode(array('error'=>1,'msg'=>$wxdata));exit();
        }

    }

    //执行第二次签名，才能返回给客户端使用
    public function getOrder($prepayId)
    {
        $timeStamp = time();
        if($this->trade_type == 'APP'){
          // app
          $data["noncestr"] = $this->getRandChar(32);
          $data["appid"] = $this->config["appid"];
          $data["package"] = "Sign=WXPay";
          $data["partnerid"] = $this->config['mch_id'];
          $data["prepayid"] = $prepayId;
          $data["timestamp"] = time();
          $data['sign'] = $this->getSign($data, false);
        }else{
          // 小程序
          $sign["appId"] = $data['appId'] = $this->config["appid"];
          $sign['package'] = $data['package'] = 'prepay_id='.$prepayId;
          $sign['signType'] = $data['signType'] = "MD5";
          $sign["timeStamp"] = $data["timeStamp"] = "$timeStamp";
          $sign["nonceStr"] = $data["nonceStr"] = $this->getRandChar(32);
          $data["paySign"] = $this->wxAppGetSign($sign, false);
        }
        return $data;
    }

    /*
        生成签名
    */
    public function wxAppGetSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        $String = $String."&key=".$this->config['api_key'];
        //签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    /*
        生成签名
    */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[strtolower($k)] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        $String = $String."&key=".$this->config['api_key'];
        //签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    //获取指定长度的随机字符串
    public function getRandChar($length){
       $str = null;
       $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
       $max = strlen($strPol)-1;

       for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
       }

       return $str;
    }

    //数组转xml
    public function arrayToXml($arr)
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

    //post https请求，CURLOPT_POSTFIELDS xml格式
    public function postXmlCurl($xml,$url,$second=30)
    {
        //初始化curl
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
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data)
        {
            curl_close($ch);
            return $data;
        }
        else
        {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /*
        获取当前服务器的IP
    */
    public function get_client_ip()
    {
        if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
        $cip = getenv("HTTP_CLIENT_IP");
        } else {
        $cip = "unknown";
        }
        return $cip;
    }

    //将数组转成uri字符串
    public function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
               $v = urlencode($v);
            }
            if($this->trade_type == "JSAPI"){
              $buff .= $k . "=" . $v . "&";
            }else{
              $buff .= strtolower($k) . "=" . $v . "&";
            }
        }
        $reqPar;
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }


    //xml转成数组
    public function xmlstr_to_array($xmlstr) {
      $doc = new DOMDocument();
      $doc->loadXML($xmlstr);
      return $this->domnode_to_array($doc->documentElement);
    }
    public function domnode_to_array($node) {
      $output = array();
      switch ($node->nodeType) {
       case XML_CDATA_SECTION_NODE:
       case XML_TEXT_NODE:
        $output = trim($node->textContent);
       break;
       case XML_ELEMENT_NODE:
        for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
         $child = $node->childNodes->item($i);
         $v = $this->domnode_to_array($child);
         if(isset($child->tagName)) {
           $t = $child->tagName;
           if(!isset($output[$t])) {
            $output[$t] = array();
           }
           $output[$t][] = $v;
         }
         elseif($v) {
          $output = (string) $v;
         }
        }
        if(is_array($output)) {
         if($node->attributes->length) {
          $a = array();
          foreach($node->attributes as $attrName => $attrNode) {
           $a[$attrName] = (string) $attrNode->value;
          }
          $output['@attributes'] = $a;
         }
         foreach ($output as $t => $v) {
          if(is_array($v) && count($v)==1 && $t!='@attributes') {
           $output[$t] = $v[0];
          }
         }
        }
       break;
      }
      return $output;
    }
}
