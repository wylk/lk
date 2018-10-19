<?php
//用户
class hairpin_controller extends base_controller
{
    public $userId;
    public $phone;
    public $userInfo;
    public $balance = 1000000;
    public $cardType;
    public function __construct(){
        // $this->userId = 108;
        
        // $this->getPhone();
        $phone = D("Admin")->field("phone")->where(['name'=>"admin"])->find();
        $this->phone = $phone['phone'];

        $this->userInfo = D("User")->where(['phone'=>$this->phone])->find();
        $this->userId = $this->userInfo['id'];
        $this->cardType = option("hairpan_set.platform_type_name");
    }
    // 获取手机号
    public function getPhone(){
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $this->phone = $platformObj->getPhone();
    }
    //平台币管理
    public function index()
    {
        $packageInfo = D("Card_package")->where(['uid'=>$this->userId,"type"=>$this->cardType])->find();
        $datas['totalNumNow'] = $packageInfo['num']+$packageInfo['frozen'];
        $datas['sellNumTotal'] = $packageInfo['sell_count'];
        $datas['buyNumTotal'] = $packageInfo['recovery_count'];
        $datas['tranNumTotal'] = D("Record_books")->where("type = '".$this->cardType."'")->sum("num");
        $datas['tranNumToday'] = D("Record_books")->where("type = '".$this->cardType."' and createtime >= ".strtotime(date("Y-m-d")))->sum("num");

        // 交易记录
        $books = D("Record_books")->where("type = '".$this->cardType."'")->select();
        // dump($books);

        $this->assign('datas',$datas);
        $this->assign('userInfo',$this->userInfo);
        $this->assign('phone',$this->phone);
        $this->assign('books',$books);
        $this->display();
    }

    public function addAdminAccount(){
        // $phone = $_POST['phone'];
        // $userdata['phone'] = $_POST['phone'];
        // $userdata['phone'] = $_POST['phone'];
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $userdata['phone'] = $this->phone;
        $res = $platformObj->checkAccount();
        if(!$res) dexit(['res'=>1,"msg"=>"账户已注册"]);

        $addAccountRes = $platformObj->addAccountInterface($userdata,$this->balance);
        // $userInfo = D("User")->where(['phone'=>$this->phone])->find();

        // D("Card_package")->data(['num'=>$this->balance])->where(['uid'=>$userInfo['id'],"type"=>$this->cardType])->save();
        dexit($addAccountRes);
    }

    public function deal()
    {
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $packageInfo = D("Card_package")->where(['uid'=>$this->userId,"type"=>"leka"])->find();

        // 市场委托买单
        $buyList = $platformObj->selectTradeList(['userId'=>$this->userId,'type'=>'1','cardId'=>$packageInfo['card_id'],'status'=>'0']);
        // 市场委托卖单
        $sellList = $platformObj->selectTradeList(['userId'=>$this->userId,'type'=>'2','cardId'=>$packageInfo['card_id'],'status'=>'0']);

        // 订单列表
        $finishOrderList = $platformObj->selectOrderList(['userId'=>$this->userId,'status'=>"in (1)"]);
        $orderingList = $platformObj->selectOrderList(['userId'=>$this->userId,'status'=>"in (0,3)"]);
        $registerList = $platformObj->selectPersonRegister(['userId'=>$this->userId,"card_id"=>$packageInfo['card_id']]);

        $this->assign("packageInfo",$packageInfo);
        $this->assign("buyList",$buyList);
        $this->assign("sellList",$sellList);
        $this->assign("finishOrderList",$finishOrderList);
        $this->assign("orderingList",$orderingList);
        $this->assign("registerList",$registerList);
        $this->assign("userId",$this->userId);
        $this->display();
    }
    // 买入平台币
    public function buyTran(){
        $tranId = clear_html($_POST['tranId']);
        $num = clear_html($_POST['num']);
        $packageId = clear_html($_POST['packageId']);
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $orderData = ['tranId'=>$tranId,"userId"=>$this->userId,"num"=>$num,"packageId"=>$packageId];
        $res = $platformObj->marksetTrade($orderData);
        // dexit(['tranId'=>$tranId,'res'=>$res]);
        dexit($res);
    }
    // 卖出平台币
    public function sellTran(){
        $tranId = clear_html($_POST['tranId']);
        $num = clear_html($_POST['num']);
        $packageId = clear_html($_POST['packageId']);
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $orderData = ['tranId'=>$tranId,"userId"=>$this->userId,"num"=>$num,"packageId"=>$packageId];
        $res = $platformObj->marksetTrade($orderData);
        // dexit(['tranId'=>$tranId,'res'=>$res,"tranId"=>$tranId]);
        dexit($res);
    }
    // 买入卖出委托单
    public function addRegister(){
        $data['userid'] = $this->userId;
        $data['price'] = clear_html($_POST['price']);
        $data['tranNum'] = clear_html($_POST['tranNum']);
        $data['limitNum'] = clear_html($_POST['limitNum']);
        $data['packageId'] = clear_html($_POST['packageId']);
        $data['type'] = clear_html($_POST['type']);
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency($data);
        $res = $platformObj->addEntrust();
        dexit($res);
    }
    public function revokeRegister(){
        $data['tranId'] = $_POST['tranId'];
        $data['packageId'] = $_POST['packageId'];
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $res = $platformObj->revokeRegister($data);
        dexit($res);
    }
    public function revokeOrder(){
        $orderId = $_POST['orderId'];
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency(['userid'=>$this->userId]);
        $orderRes = $platformObj->revokeOrder($orderId);
        dexit($orderRes);
    }

    //平台币交易
    public function orderList()
    {
        if(IS_POST && $_POST['type'] == "confirmTran"){
            $orderId = $_POST['orderId'];
            import("PlatformCurrency");
            $platformObj = new PlatformCurrency();
            $res = $platformObj->transferCurrency($orderId);
            dexit($res);
        }
        if(IS_POST && $_POST['type'] == "payMoeny"){
            $orderId = $_POST['orderId'];
            $res = D("Orders")->data(['status'=>3])->where(['id'=>$orderId])->save();
            if(!$res) dexit(['res'=>1,"msg"=>"付款更新错误"]);
            dexit(['res'=>0,"msg"=>"已通知对方付款"]);
        }
        $orderId = clear_html($_GET['orderId']);
        $orderInfo = D("Orders")->where(['id'=>$orderId])->find();
        $this->assign("orderInfo",$orderInfo);
        $this->assign("userId",$this->userId);
        $this->display();
    }

    //平台币设置
    public function set()
    {

        if(IS_POST){
            $postData = clear_html($_POST);
            if(D("Hairpan_set")->data($postData)->add()){

                dexit(['error'=>0,'msg'=>'添加成功']);
            }else{

                dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        $inputType = array(
            //['type'=>'img','title'=>'图片'],
            ['type'=>'radio','title'=>'单选'],
            ['type'=>'textarea','title'=>'文本域'],
        );
        $regType = array(
            ['type'=>'min','title'=>'小于多少字符'],
            ['type'=>'max','title'=>'大于多少字符'],
            ['type'=>'required','title'=>'必填'],
        );
        $sets = D("Hairpan_set")->where(['status'=>0])->select();
        import('HtmlForm');
        $html = new HtmlForm('edit',url('add_set'));

        foreach ($sets as $k => $v) {
            switch ($v['type']) {
                case 'txt':
                    $reg = array();
                    if($v['reg']){
                        if($v['reg'] == 'required'){
                            $reg = [$v['reg']];
                        }else{
                            $reg = [$v['name'],[$v['reg'],$v['remark'],$v['title']]];
                        }
                    }
                    $html->input([$v['name'],$v['title'],'text',$v['value']],$reg);
                    break;
                case 'img':
                    # code...
                    break;
                case 'radio':
                    list($a,$b)  = explode(',',$v['remark']);
                    $radio = [['val'=>1,'title'=>$a,'checked'=>($v['value'] == 1?'checked':'')],['val'=>0,'title'=>$b,'checked'=>($v['value'] == 0?'checked':'')]];
                    $html->radio([$v['name'],$v['title'],70],$radio);
                    break;
                case 'textarea':
                    $html->textarea([$v['name'],$v['title'],$v['value']]);
                    break;
                default:
                    # code...
                    break;
            }
        }
        $wap = $html->resSuccess('',1);
        $wap = $html->addFrom();
        $this->assign('wap',$wap);
        $this->assign('inputType',$inputType);
        $this->assign('regType',$regType);
        $this->display();
    }

    public function add_set()
    {
        if(IS_POST){
            $postData = clear_html($_POST);
            $set = D("Hairpan_set");
            foreach($postData as $key=>$value){
                $data['value'] = str_replace('，', ',', trim(stripslashes(htmlspecialchars_decode($value))));
                $set->data($data)->where(array("name"=>$key))->save();
            }
            dexit(['error'=>0,'msg'=>'修改成功']);
        }

    }
}

