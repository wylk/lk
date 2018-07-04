<?php
/*
    SMS_133975188 尊敬的用户，今日获取的E币为:${code}。
    SMS_133960225 尊敬的商家，你有新的订单,请尽快处理，订单号为:${code}。
    SMS_133976263  快递发送通知(共联商家)  尊敬的用户,您在${store}购买的商品(订单号:${code})已发货，请保持电话畅通！
 */
class Message {
    public $data;
    function __construct($data = false) {
        $this->data = $data;
        import('Http');
    }

    public function short_message($sms,$phone,$code) 
    {
        require_once(LEKA_PATH.'/source/class/alidayu/TopSdk.php');
        date_default_timezone_set('Asia/Shanghai');
        $c = new TopClient;
        $c->appkey = '23662099';
        $c->secretKey = '3e8caefde3de13e6c095db0b52061290';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("E派速达");
        $req->setSmsParam($code);
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($sms);
        $resp = $c->execute($req);
        $res = json_decode(json_encode($resp), true);
        return $res;
        // arrlog($res,'aldyMe');
        if ($res['result']['msg'] == 'OK' && $res['result']['success'] == "true") {
            return true;
        } else {
           return false;
        }
    }

}