<?php

/**
*   关于平台币的类
*/
class PlatformCurrency{
    public $tradingSwitch =  true;
    public $tradingMsg = "暂时停止交易";
    public $matchOrderData = [];
    public $tranList = [];
    public $tranNum;       //交易数量
    public $initialNum;      //交易初始数量
    public $frozenNum;      //交易初始数量
    public $tranId;
    public $limitNum = 0;
    public $userId;
    public $price;
    public $packageId;
    public $platform;
    public $type;  //1买家，2卖家
    public $cardType = "leka";
    public $interfaceType; //是否连接区块链 true:连接区块链
    public $lkApiObj;
    public $frozenList; //冻结数据数组
    public function __construct($data=null){
        $this->userId = $data['userid'];
        $this->price = option('hairpan_set.price');
        $this->initialNum = $this->tranNum = $data['tranNum'];
        $this->limitNum = option('hairpan_set.limit') ? option('hairpan_set.limit') : $data['limitNum'];
        $this->packageId = $data['packageId'];
        $this->type = $data['type'];
        $this->interfaceType = option('config.blockchain_switch');
    }
    // 添加账户接口
    public function addAccountInterface($phone,$balance=0){
        if($this->interfaceType){
            $addAccountInfo = $this->interfaceAddCount($phone);
            if($addAccountInfo['error'] != "0") return $addAccountInfo;
            $addAccountRes = D("User")->data(['phone'=>$phone,'address'=>$addAccountInfo['address']])->add();
        }else{
            $addAccountRes = D("User")->data(['phone'=>$phone])->add();
            $addAccountInfo = $this->imitateAccount($addAccountRes,$balance);
            if($addAccountInfo['res']) return $addAccountInfo;
            D("User")->data(['address'=>$addAccountInfo['address']])->where(['id'=>$addAccountRes])->save();
        }

        $data['uid'] = $addAccountRes;
        $data['type'] = $this->cardType;
        $data['num'] = 0;
        $data['card_id'] = $addAccountInfo['addr'];
        $data['address'] = md5($addAccountRes.$addAccountInfo['addr']);
        $data['user_address'] = $addAccountInfo['address'];
        D("Card_package")->data($data)->add();
        if(!$addAccountRes){
            return ["res"=>1,'msg'=>"注册失败"];
        }
        return ["res"=>0,'msg'=>"注册成功","data"=>$addAccountRes];
    }
    // 添加交易单
    public function addEntrust(){
        // 判断是否可以交易
        if(!option('hairpan_set.coin_open'))    return ['res'=>1,"msg"=>"暂时停止交易"];
        // 判断售卖规则是否符合
        $platform =$this->platform[$this->packageId] = D("Card_package")->where(['id'=>$this->packageId])->find();
        if($this->type == '2'){
            if($this->platform[$this->packageId]['num'] < $this->tranNum){
                return ['res'=>1,"msg"=>"售出数量不能超出现有可用数量"];
            }
        }
        if(!$this->tranNum > 0 )    
            return ['res'=>1,"msg"=>"购买数量不能小于0"];
        if($this->tranNum < $this->limitNum)
            return ['res'=>1,"msg"=>"限制最低数量不得大于委托数量"];

        // 添加委托数据到数据库
        $data = ['cardId'=>$platform['card_id'],"cardAddress"=>$platform['address']];
        $tradeDataRes = $this->addTradeSheet($data,$this->type);
        if($tradeDataRes['res'] != 0) return $tradeDataRes;
        // 冻结卡包卖家数据
        if($this->type == '2'){
            $frozenList[] = ['id'=>$platform['id'],"operator"=>"+","step"=>$this->tranNum,"field"=>"frozen"];
            $frozenList[] = ['id'=>$platform['id'],"operator"=>"-","step"=>$this->tranNum,"field"=>"num"];
            $this->packageFrozen($frozenList);
        }

        // 自动匹配订单
        if(option('hairpan_set.matching')){
            $this->matching();
            if(!count($this->matchOrderData)) return $tradeDataRes;

            $addOrderRes = $this->addOrder();
            if($addOrderRes['res']) return $addOrderRes;
            
            $this->tradeSheetFrozen($this->frozenList);

            return ['res'=>0,"msg"=>"已匹配到".$addOrderRes['data']."条订单","tradeData"=>$tradeDataRes['data'],'orderData'=>$this->matchOrderData];
        }
        return $tradeDataRes;
    }
    // 自动匹配订单
    public function matching(){
        if($this->type == "2") $type = 1;
        if($this->type == '1') $type = 2;
        $matchingList = D("Card_transaction")->where(['uid'=>["not in",[$this->userId]],'price'=>$this->price,"limit"=>["<=",$this->tranNum],"type"=>$type,"status"=>0])->order("createtime desc")->select();
        foreach($matchingList as $key=>$value){
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
            $this->matchOrderData[$key]['tran_other'] = $this->lastTradeId;
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
            // $frozenList[] = ['id'=>$tradeInfo['id'],"operator"=>"+","step"=>$num,"field"=>"frozen"];
            $this->frozenList[] = ['id'=>$value['id'],"operator"=>"+","step"=>$orderNum,"field"=>"frozen"];
            $this->frozenList[] = ['id'=>$this->lastTradeId,"operator"=>"+","step"=>$orderNum,"field"=>"frozen"];
            if($this->tranNum == 0) break;
        }

    }
    // 添加委托单到交易表
    public function addTradeSheet($data,$type){
        $tranData['uid'] = $this->userId;
        $tranData['card_id'] = $data['cardId'];
        $tranData['address'] = $data['cardAddress'];
        $tranData['type'] = $type;
        $tranData['num'] = $this->initialNum;
        if($this->limitNum != 0){
            $tranData['limit'] = $this->limitNum;
        }
        $tranData['price'] = $this->price;
        $tranData['createtime'] = time();
        $tranData['updatetime'] = time();
        $this->lastTradeId = D("Card_transaction")->data($tranData)->add();
        $tranData['id'] = $this->lastTradeId;
        if(!$this->lastTradeId){
            return ['res'=>1,"msg"=>"挂单失败"];
        }

        return ['res'=>0,"msg"=>"挂单成功","data"=>$tranData];
    }

    // 添加订单
    public function addOrder(){
        if(count($this->matchOrderData) == 1){
            $matchOrderData = array_values($this->matchOrderData);
            if(D("Orders")->data($matchOrderData[0])->add())     $orderNum = 1;
        }else{
            $orderNum = D("Orders")->data($this->matchOrderData)->addAll();
        }

        if(!$orderNum) return ['res'=>1,"msg"=>"订单添加失败"];
        return ['res'=>0,"msg"=>"已匹配到".$orderNum."条订单","data"=>$orderNum];
    }
    // 获取交易市场中的委托单
    public function selectTradeList($data){
        return D("Card_transaction")->where(["uid"=>['not in',[$data['userId']]],"card_id"=>$data['cardId'],'type'=>$data['type'],"status"=>$data['status'],"frozen"=>['>=',0]])->select();
    }
    // 查找个人的委托单
    public function selectPersonRegister($data){
        $tranWhere = ['uid'=>$data['userId'],"card_id"=>$data['card_id'],"status"=>0];
        if($data['type']){
            $tranWhere['type'] = $data['type'];
        }
        return D("Card_transaction")->where($tranWhere)->order("createtime desc")->select();
    }
    // 直接与市场中的委托单交易
    public function marksetTrade($data){
        $this->userId = $data['userId'];
        $tranId = $data['tranId'];
        $num = $data['num'];

        if(!option('hairpan_set.coin_open'))    return ['res'=>1,"msg"=>"暂时停止交易"];

        $tradeInfo = D("Card_transaction")->where(['id'=>$tranId])->find();

        if($num > $tradeInfo['num']) return ['res'=>1,"msg"=>"交易单已失效，请选择其他订单"];
        if($this->userId == $tradeInfo['uid']) return ['res'=>1,"msg"=>"此单为本人发布"];
        if($tradeInfo['status'] != '0') return ['res'=>1,"msg"=>"此交易单已关闭"];
        if($tradeInfo['type'] == '1'){
            $packageInfo = D("Card_package")->where(['id'=>$data['packageId']])->find();
            if($packageInfo['num'] < $num)  return ['res'=>1,"现有金额不足","other"=>$packageInfo['num']];
        }

        $this->matchOrderData[$tranId]['tran_other'] = $tradeInfo['id'];
        $this->matchOrderData[$tranId]['tran_id'] = $tradeInfo['id'];
        $this->matchOrderData[$tranId]['card_id'] = $tradeInfo['card_id'];
        if($tradeInfo['type'] == '2'){   //买单userId
            $this->matchOrderData[$tranId]['sell_id'] = $tradeInfo['uid'];
            $this->matchOrderData[$tranId]['buy_id'] = $this->userId;
        }elseif($tradeInfo['type'] == '1'){  //卖单userId
            $this->matchOrderData[$tranId]['buy_id'] = $tradeInfo['uid'];
            $this->matchOrderData[$tranId]['sell_id'] = $this->userId;
        }
        $this->matchOrderData[$tranId]['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $this->matchOrderData[$tranId]['number'] = $num;
        $this->matchOrderData[$tranId]['price'] = $tradeInfo['price'];
        $this->matchOrderData[$tranId]['create_time'] = time();
        $this->matchOrderData[$tranId]['update_time'] = time();

        $orderRes = $this->addOrder();
        if($orderRes['res']) return $orderRes;
        // 修改冻结数据
        $frozenList[] = ['id'=>$tradeInfo['id'],"operator"=>"+","step"=>$num,"field"=>"frozen"];
        $this->tradeSheetFrozen($frozenList);
        return ['res'=>0,"msg"=>"订单已生成",'data'=>$this->matchOrderData[$tranId]];
    }
    // 卡包数据冻结
    public function packageFrozen($frozenList){
        M("Card_package")->frozen($frozenList);
    }
    // 交易单修改数据冻结
    public function tradeSheetFrozen($frozenList){
        M("Card_transaction")->frozen($frozenList);
    }
    // 交易记录列表
    public function selectOrderList($data){
        $packageInfo = D("Card_package")->where(['uid'=>$data['userId'],"type"=>$this->cardType])->find();
        $orderWhere = "(`buy_id` = ".$data['userId']." or `sell_id` = ".$data['userId'].") and `card_id` = '".$packageInfo['card_id']."' and status ".$data['status'];
        return D("Orders")->where($orderWhere)->order("create_time desc")->select();
    }
    // 撤销委托单
    public function revokeRegister($data){
        $revokeInfo = D("Card_transaction")->where(['id'=>$data['tranId']])->find();
        if((int)$revokeInfo['frozen']) return ['res'=>1,"msg"=>"您还有".number_format($revokeInfo['frozen'],2)."订单未处理，请处理后在撤销"];
        if(!D("Card_transaction")->where(['id'=>$data['tranId']])->setField("status",2)){
            return ['res'=>1,"msg"=>"撤销失败"];
        }
        if($revokeInfo['type'] == '1') return ['res'=>0,"msg"=>"撤销成功"];
        $frozenList[] = ['id'=>$data['packageId'],"operator"=>"-","step"=>$revokeInfo['num'],"field"=>"frozen"];
        $frozenList[] = ['id'=>$data['packageId'],"operator"=>"+","step"=>$revokeInfo['num'],"field"=>"num"];
        // 委托单作废解冻package中的数据
        $this->packageFrozen($frozenList);
        return ['res'=>0,"msg"=>"撤销成功"];
    }
    // 订单的状态
    public function orderStatus($orderId){
        $res = D("Orders")->where(['id'=>$orderId])->setField("status",3);
        if(!$res) return ['res'=>1,"msg"=>"通知失败"];
        return ['res'=>0,"msg"=>"已成功通知对方"];
    }
    public function revokeOrder($orderId){
        $res = D("Orders")->where(['id'=>$orderId])->setField("status",2);
        if(!$res) return ['res'=>1,"msg"=>"撤销失败"];
        // 解冻package transaction
        $orderInfo = D("Orders")->where(['id'=>$orderId])->find();
        if($orderInfo['tran_id'] != $orderInfo['tran_other'] && !empty($orderInfo['tran_other'])){
            $frozenList[$orderInfo['tran_other']] = ['id'=>$orderInfo['tran_other'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"frozen"];
        }
        $frozenList[$orderInfo['tran_id']] = ['id'=>$orderInfo['tran_id'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"frozen"];

        $this->tradeSheetFrozen($frozenList);
        // $this->

        return ['res'=>0,"msg"=>"撤销成功"];
    }
    // 转账记录
    public function recordBooks($data){
        $recordRes = D("Record_books")->data(['card_id'=>$data['cardId'],"send_address"=>$data["sendAddress"],"get_address"=>$data['getAddress'],"num"=>$data['num'],"createtime"=>time()])->add();
    }
    public $sellOrder = false;  //是否是委托卖单
    // 平台币转账
    public function transferCurrency($orderId){
        $orderInfo = D("Orders")->where(['id'=>$orderId])->find();
        if($orderInfo['status'] != '0' && $orderInfo['status'] != '3') return ['res'=>1,"msg"=>"订单失效"];
        $sellInfo = D("Card_package")->where(['uid'=>$orderInfo['sell_id'],"card_id"=>$orderInfo['card_id']])->find();
        $buyInfo = D("Card_package")->where(['uid'=>$orderInfo['buy_id'],"card_id"=>$orderInfo['card_id']])->find();

        // 转账接口调用
        if($this->interfaceType){
            // 转账接口
            $blockchainRes = $this->blockchainInterface($sellInfo,$buyInfo,$orderInfo['number']);
            if($blockchainRes['res']) return $blockchainRes;
            $buyRes = $blockchainRes['buyRes'];
            $sellRes = $blockchainRes['sellRes'];
        }else{
            $imitateRes = $this->imitateInterface($sellInfo,$buyInfo,$orderInfo['number']);
            if($imitateRes['res']) return $imitateRes;
            $buyRes = $buyInfo['num']+$orderInfo['number']+$buyInfo['frozen'];
            $sellRes = $sellInfo['num']-$orderInfo['number']+$sellInfo['frozen'];
        }
        // dexit(['res'=>1,"msg"=>"test","imitateRes"=>$imitateRes]);
        
        // 冻结数据修改
        $frozenList[] = ['id'=>$orderInfo['tran_id'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"num"];
        $frozenList[] = ['id'=>$orderInfo['tran_other'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"num"];
        $frozenList[] = ['id'=>$orderInfo['tran_id'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"frozen"];
        $frozenList[] = ['id'=>$orderInfo['tran_other'],"operator"=>"-","step"=>$orderInfo['number'],"field"=>"frozen"];
        $this->tradeSheetFrozen($frozenList);

        // 转账记录
        $this->recordBooks(["cardId"=>$orderInfo['card_id'],'getAddress'=>$buyInfo['address'],"sendAddress"=>$sellInfo['address'],"num"=>$orderInfo['number']]);

        // 检测交易单是否完成 并修改状态
        $this->judgeTrade(['tranId'=>$orderInfo['tran_id'],"tranOther"=>$orderInfo['tran_other'],"sellId"=>$orderInfo['sell_id']]);

        // 交易成功减少卖家冻结 卖出的部分
        if($this->sellOrder){
            $a = D("Card_package")->where(['uid'=>$orderInfo['sell_id'],"card_id"=>$orderInfo['card_id']])->setDec("frozen",$orderInfo['number']);
            $data[] = ["id"=>$sellInfo['id'],"num"=>$sellRes-($sellInfo['frozen']-$orderInfo['number'])];
        }else{
            $data[] = ["id"=>$sellInfo['id'],"num"=>$sellRes-$sellInfo['frozen']];
        }
        $data[] = ["id"=>$buyInfo['id'],"num"=>$buyRes-$buyInfo['frozen']];
        $balanceRes = M("Card_package")->saveAll($data);
        $statusRes = D("Orders")->data(['status'=>1])->where(['id'=>$orderId])->save();
// dexit(['res'=>1,"msg"=>"test","balanceRes"=>$balanceRes,"status"=>$statusRes,"data"=>$data]);
        if(!$statusRes){
            return ['res'=>1,"msg"=>"转账失败","balanceRes"=>$balanceRes,"status"=>$statusRes];
        }
        return ['res'=>0,"msg"=>"转账成功"];
    }
    
    // 判断交易单是否完成
    public function judgeTrade($data){
       $tranList = D("Card_transaction")->where(['id'=>["in",[$data['tranId'],$data['tranOther']]]])->select();
       foreach($tranList as $key=>$value){
            if($value['num'] == 0)  $tranIds[] = $value['id'];
            if($value['uid'] == $data['sellId']) $this->sellOrder = true;
       }
       if(!empty($tranIds)){
            D("Card_transaction")->where(['id'=>['in',$tranIds]])->setField("status",1);
       }
    }
    // 数据库添加平台币账户接口
    public function imitateAccount($userId,$balance=0){
        $bookObj = new AccountBook();
        $bookJson = json_encode(['uid'=>$userId,'contract_id'=>"0x837c6c3d09c0b36833ce37193f35e3c7108c22d2","account_balance"=>$balance]);
        $bookRes = $bookObj->addAccount(encrypt($bookJson,option('version.public_key')));
        if(!$bookRes) return ['res'=>1,"msg"=>"账号注册失败"];
        return ['res'=>0,"msg"=>"账号注册成功","addr"=>"0x837c6c3d09c0b36833ce37193f35e3c7108c22d2","address"=>$bookRes];
    }
    // 数据库转账接口
    public function imitateInterface($sellInfo,$buyInfo,$num){
        import("AccountBook");
        $bookObj = new AccountBook();
        $bookJson = json_encode(['uid'=>$sellInfo['uid'],"contract_id"=>$sellInfo['card_id'],'sendAddress'=>$sellInfo['address'],"num"=>$num,"getAddress"=>$buyInfo['address']]);
        $bookRes = $bookObj->transferAccounts(encrypt($bookJson,option('version.public_key')));
        // dexit(['res'=>1,"msg"=>"test","imitateRes"=>$bookRes,"bookJson"=>$bookJson]);
        if(!$bookRes) return ['res'=>1,"msg"=>"转账失败","other"=>$bookRes];
        return ['res'=>0,"msg"=>"转账成功"];
    }
    // 区块链转账接口
    public function blockchainInterface($sellInfo,$buyInfo,$num){
        $interfaceRes = $this->interfaceCurrency($buyInfo['user_address'],$sellInfo['user_address'],(int)$num);
        if($interfaceRes) return $interfaceRes;
        
        // 获取平台币数值
        $sellRes = $this->interfaceBalance($sellInfo['user_address']);
        $buyRes = $this->interfaceBalance($buyInfo['user_address']);
        // return [$sellRes,$buyRes];
        return ['res'=>0,"msg"=>"已获取账款余额","sellRes"=>$sellRes,"buyRes"=>$buyRes];
    }
    // 平台币转账接口
    public function interfaceCurrency($buyAddress,$sellAddress,$num){
        // 连接平台转账
        import('LkApi');
        $this->lkApiObj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
        $this->lkApiObj->geth_api(['address'=>$sellAddress,'c'=>'Contracts','a'=>'unlock']);
        $res = $this->lkApiObj->geth_api(['to'=>$sellAddress,'from'=>'0x56ed6901879d9dcb7d469ce4c6de2de09ded3e3d','c'=>'Geth','a'=>'transaction']);
        if($res['error'] != '0') return ['res'=>1,"msg"=>"平台连接错误","res"=>$sellAddress,'buy'=>$buyAddress];
        $tranRes = $this->lkApiObj->geth_api(['to'=>$buyAddress,'from'=>$sellAddress,'val'=>(int)$num,'c'=>'Contracts','a'=>'transfer_contract']);
        if($tranRes['error'] != '0') return ['res'=>1,"msg"=>"转账错误","tranres"=>$tranRes];
    }
    // 查询账户余额接口
    public function interfaceBalance($address){
        $res = $this->lkApiObj->geth_api(['address'=>$address,'c'=>'Contracts','a'=>'balance_contract']);
        if($res['error'] != '0') return ['res'=>1,"msg"=>"数据获取错误"];
        return $res['balance'];
    }
    // 以太网添加账户接口
    public function interfaceAddCount($phone){
        import('LkApi');
        // 以太网接口
        $obj  = new LkApi(['appid'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2','mchid'=>'2343sdf','key'=>'0x11083f099e36850a6d264b1050f6f7ebe652d4c2']);
        $addAccountInfo = $obj->geth_api(['phone'=>$phone,'c'=>'Geth','a'=>'add_account']);
        return $addAccountInfo;
    }

}
