<?php
class LkApi
{
    public $data;
    public function __construct($data = false)
    {

        import('lkPubHelper');
        $this->data = $data;
    }

    public function weixinPay($data)
    {
        $yp = new weixin_api($this->data['appid'],$this->data['mchid'],$this->data['key']);

        $yp->setParameter('order_id',$data['order_id']);

        return $yp->pay();
    }

    //测试
    public function geth_api($data)
    {

        $geth = new geth_api($this->data['appid'],$this->data['mchid'],$this->data['key']);
        foreach ($data as $k => $v) {
            $geth->setParameter($k,$v);
        }
        return $geth->execute();

    }


}

