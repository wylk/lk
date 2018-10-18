<?php
/*
  卡卷管理
 */
class coiling_controller extends base_controller
{
    //浏览页面
	public function index()
    {
        $contract = D('Contract')->where(['status'=>1])->select();

        $cardNum = D("Card")->where(['c_id'=>6])->select();
        foreach($cardNum as $key=>$value){
            $contractInfo[$value['type']."Card"]['sum'] += $value['val'];
            $contractInfo[$value['type']."Card"]['num'] += 1;
        }

        $package = D("Card_package")->field("type,sum(`sell_count`) as sellNum,count(id) as ids")->where("is_publisher=0 and type != '".option('hairpan_set.platform_type_name')."'")->group('type')->select();
        foreach($package as $key=>$value){
            $contractInfo[$value['type']."Card"]['tranNum'] = $value['sellNum'];
            $contractInfo[$value['type']."Card"]['userNum'] = $value['ids'];
        }

        $this->assign('contract',$contract);
        $this->assign('contractInfo',$contractInfo);
        $this->display();
    }

        // import('user_page');
        // $user =D('User')->where(array('isdelete' =>0))->select();
        // $count=count($user);
        // $page = new Page(count($user),4);
        // $res = D('User')->where()->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        // $this->assign('page', $page->show());
        // $this->assign('res',$res);
        // $this->assign('count',$count);
        // $this->display();






    public function cards()
    {
        $type = $_GET['type'];
        $type = substr($type, 0,-4);

        $cardName = D("Contract")->field("contract_name")->where(['contract_title'=>$_GET['type']])->find();
        $cardName['type'] = $type;
        // import('user_page');
        // $res = D('Card')->where(['type'=>])->select();
        // $count=count($res);
        // $page = new Page(count($res),2);
        // $card = D('Card')->where()->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        $card = D("Card")->where(['type'=>$type])->select();
        $Contract_field = D('Contract_field')->where()->select();
        $Contract_fields = $uid = [];
        foreach ($Contract_field as $kk => $vv) {
            $Contract_fields[$vv['id']] = $vv['val'];
        }
        // dump($Contract_fields);
        foreach ($card as $k => $v) {
            $cards[$v['card_id']][$Contract_fields[$v['c_id']]] = $v['val'];
            $cards[$v['card_id']]['uid'] = $v['uid'];
            $cards[$v['card_id']]['card_id'] = $v['card_id'];
            if(!in_array($v['uid'], $uid)) $uid[] = $v['uid'];
        }

        $userInfo = D("User_audit")->field("name,enterprise,uid")->where("uid in (".implode($uid,",").")")->select();
        foreach($userInfo as $key=>$value){
            $user[$value['uid']]['name'] = $value['name'];
            $user[$value['uid']]['enterprise'] = $value['enterprise'];
        }

        $packageInfo = D("Card_package")->field("ratio,uid")->where("uid in (".implode($uid,",").") and type = '".$type."' and is_publisher=1")->select();
        foreach($packageInfo as $key=>$value){
            $ratio[$value['uid']] = $value['ratio'];
        }
// dump($ratio);

        // dump($cards);
        $this->assign('cards',$cards);
        $this->assign('user',$user);
        $this->assign('cardName',$cardName);
        $this->assign('ratio',$ratio);
        // $this->assign('page', $page->show());
        // $this->assign('count',$count);
        $this->display();
    }

    public function lists()
    {
        $orderList = D("Orders")->where(['sell_id'=>$_GET['uid'],"card_id"=>$_GET['card_id'],'status'=>1])->select();
        D("record_books")->where([''])->select();
        $this->assign('orderList',$orderList);
        $this->display();
    }
    public function editRatio(){
        $data['ratio'] = (int)$_POST['ratio'];
        $data['uid'] = $_POST['uid'];
        $data['type'] = $_POST['type'];
        $res = D("Card_package")->data(['ratio'=>$data['ratio']])->where(['uid'=>$data['uid'],"type"=>$data['type'],'is_publisher'=>1])->save();
        if($res) dexit(['res'=>0,"msg"=>"修改成功"]);
        dexit(['res'=>1,"msg"=>"修改失败"]);
    }
}
