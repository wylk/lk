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
    //搜索
      public function cardsFind(){
            $type=$_POST['type'];
            $username=$_POST['username'];
            $enterprise=$_POST['enterprise'];
        // $type = "offset";
        // $username = '测';
        // $enterprise = '美';
            if($username && $enterprise){
                $where = "name like '%".$username."%' and enterprise like '%".$enterprise."%'";
            }elseif($username){
                $where = "name like '%".$username."%' ";
            }elseif($enterprise){
                $where = "enterprise like '%".$enterprise."%'";
            }
            $userInfo = D("User_audit")->field("name,enterprise,uid")->where($where)->select();
            foreach($userInfo as $key=>$value){
                $user[$value['uid']]['name'] = $value['name'];
                $user[$value['uid']]['enterprise'] = $value['enterprise'];
                if(!in_array($value['uid'],$uid)) $uid[] = $value['uid'];
            }

            $card = D("Card")->where(['type'=>$type])->select();
            $Contract_field = D('Contract_field')->select();
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

            $packageInfo = D("Card_package")->field("ratio,uid,card_id")->where("uid in (".implode($uid,",").") and type = '".$type."' and is_publisher=1")->select();

            // var_dump($cards);
            // var_dump($packageInfo);die;
          if($userInfo){
             $this->dexit(['error'=>0,'data'=>['userInfo'=>$userInfo,"packageInfo"=>$packageInfo,"cards"=>$cards]]);
            }else{
             $this->dexit(['error'=>1,'msg'=>'该用户不存在']);
            }

    }

    public function cards()
    {
        $type = $_GET['type'];

        $type = substr($type, 0,-4);

        $cardName = D("Contract")->field("contract_name")->where(['contract_title'=>$_GET['type']])->find();
        $cardName['type'] = $type;
        $card = D("Card")->where(['type'=>$type])->select();
        $Contract_field = D('Contract_field')->select();
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
        import('user_page');
        $count=count($cards);
        $page = new Page(count($cards),3);

         // dump($user);die;
        $this->assign('cards',$cards);
        $this->assign('user',$user);
        $this->assign('cardName',$cardName);
        $this->assign('ratio',$ratio);
        $this->assign('page', $page->show());
        $this->assign('count',$count);
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
