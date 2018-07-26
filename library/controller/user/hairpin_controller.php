<?php
//用户
class hairpin_controller extends base_controller
{
    public $userId;
    public function __construct(){
        $this->userId = 88;
    }
    //平台币管理
    public function index()
    {
        $datas=[

        ];
        $this->assign('datas',$datas);
        $this->display();
    }

    public function deal()
    {
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $packageInfo = D("Card_package")->where(['uid'=>$this->userId,"type"=>"leka"])->find();
        
        // 市场委托买单
        $buyList = $platformObj->selectRegister(['userId'=>$this->userId,'type'=>'1','cardId'=>$packageInfo['card_id']]);

        // 市场委托卖单
        $sellList = $platformObj->selectRegister(['userId'=>$this->userId,'type'=>'2','cardId'=>$packageInfo['card_id']]);

        // 订单列表
        $finishOrderList = $platformObj->selectOrderList(['userId'=>$this->userId,'status'=>1]);
        $orderingList = $platformObj->selectOrderList(['userId'=>$this->userId,'status'=>1]);

        $this->assign("buyList",$buyList);
        $this->assign("sellList",$sellList);
        $this->assign("finishOrderList",$finishOrderList);
        $this->assign("orderingList",$orderingList);
        $this->display();
    }

    //平台币交易
    public function orderList()
    {
        $this->display();
    }

    //平台币设置
    public function set()
    {
        echo 22;
    }
}

