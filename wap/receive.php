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

    // 判断购买用户是否存在
    if(!D("User")->where(['id'=>$userId])->find()) {
        dexit(['error'=>1,'msg'=>'请登录后再购买','referer'=>'./login.php?referer='.urlencode($_SERVER['REQUEST_URI']."?id=".$data['tran_id'])]);
    }

    // 判断购买卡片是否是本人发布
    $tranInfo = D("Card_transaction")->where(['id'=>$data['tran_id']])->find();
    $tranInfo['uid'] != $userId ? true : dexit(['error'=>1,'msg'=>'此交易为本人发布']);

    if($data['number'] <= $datas['quantity']){
        $order_id = D('Orders')->data($data)->add();

        $orders = D('Card_transaction')->where(array('id'=>$datas['tranId']))->setInc('frozen',$datas['number']);
        if($order_id){
            //调用支付接口上线再做
            dexit(['error'=>0,'msg'=>'已生成订单',"orderId"=>$order_id]);
        }else{
            dexit(['error'=>1,'msg'=>'订单生成失败']);
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



