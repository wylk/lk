<?php
/*
  卡卷管理
 */
class coiling_controller extends base_controller
{
    //浏览页面
	public function index()
    {
        $contract = D('Contract')->where()->select();
        //发布卡数量
        $card = D('Card')->field("uid")->select();
        $out = array();
        foreach ($card as $key=>$value) {
            if (!in_array($value, $out)){
                $out[$key] = $value;
            }
        }
        $out = count(array_values($out));
        //交易数量
        $tran = D('Card_transaction')->field("id")->select();
        $tran = count($tran);
        //发布店铺
        $audit = D('User_audit')->field("type")->where(['type'=>2])->select();
        $audit = count($audit);
        //用户数量
        $user = D('User')->field("id")->select();
        $user = count($user);

        $contract[0]['out'] = $out;
        $contract[0]['tran'] = $tran;
        $contract[0]['audit'] = $audit;
        $contract[0]['user'] = $user;

        $this->assign('contract',$contract);
        $this->display();
    }



    public function cards()
    {
        $card = D('Card')->where()->select();
        $Contract_field = D('Contract_field')->where()->select();
        $Contract_fields = [];
        foreach ($Contract_field as $kk => $vv) {
            $Contract_fields[$vv['id']] = $vv['val'];
        }
        // dump($Contract_fields);
        foreach ($card as $k => $v) {
            $cards[$v['card_id']][$Contract_fields[$v['c_id']]] = $v['val'];
            $cards[$v['card_id']]['uid'] = $v['uid'];
            $cards[$v['card_id']]['card_id'] = $v['card_id'];
        }
        // dump($cards);
        $this->assign('cards',$cards);

        $this->display();
    }

    public function lists()
    {
        $orderList = D("Orders")->where(['sell_id'=>$_GET['uid'],"card_id"=>$_GET['card_id'],'status'=>1])->select();
        $this->assign('orderList',$orderList);
        $this->display();
    }
}
