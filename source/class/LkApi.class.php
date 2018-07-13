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


}

