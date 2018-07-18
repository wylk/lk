<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
// $res = D('Card')->where(array('uid' =>38,'c_id' =>6))->find();
if(IS_POST){
    $datas = clear_html($_POST);
    //添加订单
    $data = [];
    $data['card_id'] = $datas['card_id'];
    $data['sell_id'] = $datas['sell_id'];
    $data['buy_id'] = $userId;
    $data['number'] = $datas['number'];
    $data['prices'] = $datas['prices'];
    $data['tran_id'] = $datas['tranId'];
    $data['create_time'] = time();
    $data['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

    if($data['number'] <= $_POST['quantity']){

        $order_id = D('Orders')->data($data)->add();

        $orders = D('Card_transaction')->where(array('id'=>$datas['tranId']))->setInc('frozen',$datas['number']);

        if($order_id && $orders){
            //调用支付接口上线再做

            //模拟支付回调
            $package = D('Card_transaction')->where(array('uid' =>$datas['sell_id']))->find();
            $cards = D('Card_package')->where(array('uid' =>$userId))->find();
            $books['send_address'] = $package['address'];
            $books['get_address'] = $cards['address'];
            $books['num'] = $datas['number'];
            $books['createtime'] = time();
            $books = D('Record_books')->data($books)->add();
            import('LkApi');
            $api = new LkApi(['appid'=>'23432','mchid'=>'1273566173','key'=>'sdagjjjjjk']);
            $payData['order_id'] = $order_id;
            $rwx = $api->weixinPay($payData);
            // dump($rwx);
            $order_id = D('Record_books')->data($data)->add();
            D('Orders')->data(['status'=>1])->where(array('onumber'=>$data['onumber']))->save();
            dexit(['error'=>0,'msg'=>'购买成功',"other"=>$rwx]);
        }else{
            dexit(['error'=>1,'msg'=>'购买失败']);
        }
    }

    // die;
}

$UserAud = D("Card_transaction")->where(array('id'=>$_GET['id']))->find();
//添加新卡包
if(!D('Card_package')->where(['uid'=>$userId,'card_id'=>$UserAud['card_id']])->find()){
    $contract = $_GET['card']?$_GET['card']:'offset';
    $res = hook('addCardPackage',['card_id'=>$UserAud['card_id'],'uid'=>$userId],$contract);
}
include display('receive');
echo ob_get_clean();



