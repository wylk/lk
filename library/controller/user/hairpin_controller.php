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

