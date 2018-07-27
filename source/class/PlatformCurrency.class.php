<?php

/**
*   关于平台币的类
*/
class PlatformCurrency{
    public $matchOrderData = [];
    public $tranList = [];
    public $tranNum;       //交易数量
    public $initialNum;      //交易初始数量
    public $frozenNum;      //交易初始数量
    public $limitNum = 0;
    public $userId;
    public $price;
    public $packageId;
    public $platform;
    public $type;  //1买家，2卖家
    public $lkApiObj;
    public function __construct($data=null){
        $this->userId = $data['userid'];
        $this->price = $data['price'];
        $this->initialNum = $this->tranNum = $data['tranNum'];
        $this->limitNum = $data['limitNum'];
        $this->packageId = $data['packageId'];
        $this->type = $data['type'];
    }
    // public function currencyBuy(){
    //     // 判断购买规则是否符合
    //     if(!($this->tranNum > 0 && $this->price > 0)){
    //         return ['res'=>1,"msg"=>"购买价格或者数量不能为0"];
    //     }
    //     if($this->tranNum < $this->limitNum){
    //         return ['res'=>1,"msg"=>"购买的限制最低数量不得大于购买量"];
    //     }

    //     // 自动检测交易单生成订单
    //     $matchWhere = ['uid'=>["not in",[$this->userId]],'price'=>$this->price,"limit"=>["<=",$this->tranNum],"type"=>2,"status"=>0];
    //     $matchingList = D("Card_transaction")->where($matchWhere)->order("createtime asc")->select();
    //     if($matchingList){
    //        $res = $this->matching($matchingList,'buy');
    //        if($res) return $res;
    //     }

    //     // 挂单到数据库
    //      $res = $this->addTransaction(1);

    //     // 自动检测订单添加
    //     if(count($this->matchOrderData) > 0){
    //         foreach($this->matchOrderData as $key=>$value){
    //             $this->matchOrderData[$key]['tran_other'] = $res;
    //         }
    //         if(count($this->matchOrderData) == 1){
    //             $matchOrderData = array_values($this->matchOrderData);
    //             $matchOrderNum = D("Orders")->data($matchOrderData[0])->add();
    //             $num = 1;
    //         }else{
    //             $num = $matchOrderNum = D("Orders")->data($matchOrderData)->addAll();
    //         }
    //         M("Card_transaction")->setData($this->tranList);
    //         if($this->tranNum == 0){
    //             return ['res'=>0,"msg"=>"已生成".$num."条订单，请查看"];
    //         }
    //     }
    //     if(!$res){
    //         return ['res'=>1,"msg"=>"挂单失败"]; 
    //     }
    //     return ['res'=>0,"msg"=>"挂单成功"];
    // }
    public function currency(){
        // 判断售卖规则是否符合
        if($this->type == '2'){
            $this->platform[$this->packageId] = D("Card_package")->where(['id'=>$this->packageId])->find();
            if($this->platform[$this->packageId]['num'] < $this->tranNum){
                return ['res'=>1,"msg"=>"售出数量不能超出现有数量"];
            }
        }
        if(!($this->price > 0 && $this->tranNum > 0 )){
            return ['res'=>1,"msg"=>"销售单价或者数量不能小于0"];
        }
        if($this->tranNum < $this->limitNum){
            return ['res'=>1,"msg"=>"购买的限制最低数量不得大于购买量"];
        }

        // 自动匹配交易单并生成订单
        if($this->type == "2") $type = 1;
        if($this->type == '1') $type = 2;
        $matchingList = D("Card_transaction")->where(['uid'=>["not in",[$this->userId]],'price'=>$this->price,"limit"=>["<=",$this->tranNum],"type"=>$type,"status"=>0])->order("createtime asc")->select();
        if($matchingList){
            $res = $this->matching($matchingList);
            if($res) return $res;
        }

        // 挂单添加到数据库
        $res = $this->addRegister($this->type);
        
        // 自动检测订单添加
        if(count($this->matchOrderData) > 0){
            foreach($this->matchOrderData as $key=>$value){
                $this->matchOrderData[$key]['tran_other'] = $res;
            }
            if(count($this->matchOrderData) == 1){
                $matchOrderData = array_values($this->matchOrderData);
                $matchOrderNum = D("Orders")->data($matchOrderData[0])->add();
                $num = 1;
            }else{
                $num = $matchOrderNum = D("Orders")->data($this->matchOrderData)->addAll();
            }
            // 冻结交易额
            $tranRes = M("Card_transaction")->setData($this->tranList);
        }
        // 挂单数据冻结
        if($this->type == '2'){
            $editData[] = ['field'=>'num',"step"=>$this->initialNum,"operator"=>"-"];
            $editData[] = ['field'=>'frozen',"step"=>$this->initialNum,"operator"=>"+"];
            M("Card_package")->setData($editData,['id',$this->packageId]);
        }
        if($this->tranNum == 0){
            return ['res'=>0,"msg"=>"已生成".$num."条订单，请查看"];
        }
        if(!$res){
            return ['res'=>1,"msg"=>"挂单失败","edit"=>$editRes];
        }
        return ['res'=>0,"msg"=>"挂单成功"];
    }
    // 挂单到数据库 $type：1买方，2卖方
    public function addRegister($type){
        if(!$this->platform[$this->packageId]){
            $this->platform[$this->packageId] = D("Card_package")->where(['id'=>$this->packageId])->find();
        }
        $tranData['uid'] = $this->userId;
        $tranData['card_id'] = $this->platform[$this->packageId]['card_id'] ;
        $tranData['address'] = $this->platform[$this->packageId]['address'] ;
        $tranData['type'] = $type;
        $tranData['num'] = $this->initialNum;
        $tranData['frozen'] = $this->frozenNum;
        if($this->limitNum != 0){
            $tranData['limit'] = $this->limitNum;
        }
        $tranData['price'] = $this->price;
        $tranData['createtime'] = time();
        $tranData['updatetime'] = time();
        if(!D("Card_transaction")->data($tranData)->add()){
            return ['res'=>1,"msg"=>"添加失败"];
        }
        return ['res'=>0,"msg"=>"添加成功"];
    }
// 自动匹配相应的订单
    public function matching($data){
        foreach($data as $key=>$value){
            $orderNum = 0;
            if($value['num']-$value['frozen'] >= $this->tranNum && $this->tranNum >= $value['limit']){
                $orderNum = $this->tranNum;
                $this->tranNum = 0;
            }
            if($value['num']-$value['frozen'] < $this->tranNum && $value['num']-$value['frozen'] >= $limitNum){
                $orderNum = $value['num']-$value['frozen'];
                $this->tranNum = $this->tranNum - ($value['num']-$value['frozen']);
            }
            if($orderNum == 0) continue;
            $this->frozenNum += $orderNum;
            $this->matchOrderData[$key]['tran_id'] = $value['id'];
            $this->matchOrderData[$key]['card_id'] = $value['card_id'];
            if($this->type == '1'){
                $this->matchOrderData[$key]['sell_id'] = $value['uid'];
                $this->matchOrderData[$key]['buy_id'] = $this->userId;
            }elseif($this->type == '2'){
                $this->matchOrderData[$key]['buy_id'] = $value['uid'];
                $this->matchOrderData[$key]['sell_id'] = $this->userId;
            }
            $this->matchOrderData[$key]['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $this->matchOrderData[$key]['number'] = $orderNum;
            $this->matchOrderData[$key]['price'] = $this->price;
            $this->matchOrderData[$key]['create_time'] = time();
            // 订单生成后，挂单信息修改
            $this->tranList[$value['id']]['id'] = $value['id'];
            $this->tranList[$value['id']]['frozen'] = $value['frozen'];
            $this->tranList[$value['id']]['operator'] = '+';
            $this->tranList[$value['id']]['step'] = $orderNum;
            if($this->tranNum == 0) break;
        }
    }
    // 在交易市场中交易生成订单
    // $type :1买方，2卖方
    // $data 交易单id ，以及当前用户uid
    public function createOrder($data,$type){
        $tranId = $data['tranId'];
        $this->userId = $data['userId'];
        $this->type = $type;
        // $this->packageId = $data['packageId'];

        if(empty($data) || empty($type)) 
            return ['res'=>1,"数据错误"];

        $tranList = D("Card_transaction")->where(['id'=>$tranId])->find();
        if($tranList['uid'] == $this->userId){
            return ['res'=>1,"此订单为本人发布"];
        }
        // 生成订单数据
        $orderData['tran_id'] = $tranList['id'];
        $orderData['tran_other'] = $tranList['id'];
        $orderData["card_id"] = $tranList['card_id'];
        $orderData['sell_id'] = $tranList['uid'];
        $orderData['buy_id'] = $this->userId;
        if($this->type == '1'){
            $orderData['sell_id'] = $tranList['uid'];
            $orderData['buy_id'] = $this->userId;
        }elseif($this->type == '2'){
            $orderData['sell_id'] = $this->userId;
            $orderData['buy_id'] = $tranList['uid'];
        }
        $orderData['number'] = $tranList['num'];
        $orderData['price'] = $tranList['price'];
        $orderData['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $orderData['create_time'] = time();
        $orderData['update_time'] = time();
        $res = D("Orders")->data($orderData)->add();
        // if($this->type == '2'){
            // $this->initialNum = $tranList['num'];
            // $this->frozenNum = $tranList['num'];
            // $this->price = $tranList['price'];
            // $this->addRegister($this->type);
        // }
        // 冻结交易单中的数据
        D("Card_transaction")->where(['id'=>$tranId])->setInc("frozen",$tranList['num']);
        if(!$res){
            return ['res'=>0,"msg"=>"订单生成失败","order"=>$res,"data"=>$orderData];
        }
        return ['res'=>0,"msg"=>"订单已生成",'order'=>$res,"data"=>$orderData];
    }
    // 平台币转账接口
    public function interfaceCurrency($buyAddress,$sellAddress,$num){
        // 连接平台转账
        import('LkApi');
        $this->lkApiObj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
        $this->lkApiObj->geth_api(['address'=>$sellAddress,'c'=>'Contracts','a'=>'unlock']);
        $res = $this->lkApiObj->geth_api(['to'=>$sellAddress,'from'=>'0x56ed6901879d9dcb7d469ce4c6de2de09ded3e3d','c'=>'Geth','a'=>'transaction']);
        if($res['error'] != '0') return ['res'=>1,"msg"=>"平台连接错误","res"=>$sellAddress,'buy'=>$buyAddress];
        $tranRes = $this->lkApiObj->geth_api(['to'=>$buyAddress,'from'=>$sellAddress,'val'=>$num,'c'=>'Contracts','a'=>'transfer_contract']);
        if($tranRes['error'] != '0') return ['res'=>1,"msg"=>"转账错误","tranres"=>$tranRes];
    }
    public function interfaceBalance($address){
        $res = $this->lkApiObj->geth_api(['address'=>$address,'c'=>'Contracts','a'=>'balance_contract']);
        if($res['error'] != '0') return ['res'=>1,"msg"=>"数据获取错误"];
        return $res['balance'];
    }
    // 平台币转账
    public function transferCurrency($orderId){
        $orderInfo = D("Orders")->where(['id'=>$orderId])->find();
        if($orderInfo['status'] != '0') return ['res'=>1,"msg"=>"订单失效"];
        $sellInfo = D("Card_package")->where(['uid'=>$orderInfo['sell_id'],"card_id"=>$orderInfo['card_id']])->find();
        $buyInfo = D("Card_package")->where(['uid'=>$orderInfo['buy_id'],"card_id"=>$orderInfo['card_id']])->find();
        $interfaceRes = $this->interfaceCurrency($buyInfo['user_address'],$sellInfo['user_address'],(int)$orderInfo['number']);
        if($interfaceRes) return $interfaceRes;
        // 交易单数据修改
        D("Card_transaction")->where(['id'=>["in",[$orderInfo['tran_id'],$orderInfo['tran_other']]]])->setDec("num",$orderInfo['number']);
        D("Card_transaction")->where(['id'=>['in',[$orderInfo['tran_id'],$orderInfo['tran_other']]]])->setDec("frozen",$orderInfo['number']);
        // 获取平台币数值
        $sellRes = $this->interfaceBalance($sellInfo['user_address']);
        $buyRes = $this->interfaceBalance($buyInfo['user_address']);

        $tranInfo = D("Card_transaction")->where(['id'=>["in",[$orderInfo['tran_id'],$orderInfo['tran_other']]]])->select();
        foreach($tranInfo as $key=>$value){
            if($value['num'] == 0)    $tranIds[] = $value['id'];
            if($value['uid'] == $orderInfo['sell_id']) $packageFrozen = true;
        }
        if(!empty($tranIds)){
            D("Card_transaction")->where(['id'=>['in',$tranIds]])->setField("status",1);
        }
        if($packageFrozen){
            // 交易成功减少卖家冻结 卖出的部分
            $a = D("Card_package")->where(['uid'=>$orderInfo['sell_id'],"card_id"=>$orderInfo['card_id']])->setDec("frozen",$orderInfo['number']);
            $data[] = ["id"=>$sellInfo['id'],"num"=>$sellRes-($sellInfo['frozen']-$orderInfo['number'])];
        }else{
            $data[] = ["id"=>$sellInfo['id'],"num"=>$sellRes-$sellInfo['frozen']];
        }
        $data[] = ["id"=>$buyInfo['id'],"num"=>$buyRes];
        $balanceRes = M("Card_package")->saveAll($data);
        $statusRes = D("Orders")->data(['status'=>1])->where(['id'=>$orderId])->save();
        // return ['res'=>1,"msg"=>"转账失败","balanceRes"=>$balanceRes,"num"=>$orderInfo['number'],'a'=>$a];
        if(!$statusRes){
            return ['res'=>1,"msg"=>"转账失败","balanceRes"=>$balanceRes,"status"=>$statusRes];
        }
        return ['res'=>0,"msg"=>"转账成功"];
    }
    // 委托列表
    public function selectRegister($data){
        // 查询当前卖单信息
        $list = D("Card_transaction")->where(['uid'=>['not in',[$data['userId']]],'card_id'=>$data['cardId'],"type"=>$data['type'],"status"=>'0'])->select();
        return $list;
    }
    // 交易记录列表
    public function selectOrderList($data){
        $packageInfo = D("Card_package")->where(['uid'=>$data['userId'],"type"=>"leka"])->find();
        $orderWhere = "(`buy_id` = ".$data['userId']." or `sell_id` = ".$data['userId'].") and `card_id` = '".$packageInfo['card_id']."' and status = ".$data['status'];
        return D("Orders")->where($orderWhere)->order("create_time desc")->select();
    }
    public function selectPersonRegister($data){
        // $packageInfo = D("Card_package")->where(['uid'=>$data['userId'],"type"=>"leka"])->find();
        $tranWhere = ['uid'=>$data['userId'],"card_id"=>$data['card_id'],"status"=>0];
        return D("Card_transaction")->where($tranWhere)->order("createtime desc")->select();
    }
    public function revokeRegister($tranId){
        if(!D("Card_transaction")->where(['id'=>$tranId])->setField("status",3)){
            return ['res'=>1,"msg"=>"撤销失败"];
        }
        return ['res'=>0,"msg"=>"撤销成功"];
    }
}
