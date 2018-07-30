<?php
//用户
class hairpin_controller extends base_controller
{
    public $userId = 88;
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
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $res = $platformObj->createOrder(['tranId'=>$tranId,"userId"=>$this->userId],"1");
        // dexit(['tranId'=>$tranId,'res'=>$res]);
        dexit($res);
    }
    // 卖出平台币
    public function sellTran(){
        $tranId = clear_html($_POST['tranId']);
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $res = $platformObj->createOrder(['tranId'=>$tranId,"userId"=>$this->userId],"2");
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
        $res = $platformObj->currency();
        dexit($res);
    }
    public function revokeRegister(){
        $tranId = $_POST['tranId'];
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $res = $platformObj->revokeRegister($tranId);
        dexit($res);
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

