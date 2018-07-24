<?php
//用户
class hairpin_controller extends base_controller
{
    //发卡页面
    public function index()
    {
        if(IS_POST){
            $date = clear_html($_POST);
            $buyPrice = $date['buyPrice'];
            $buyNum = $date['buyNum'];
            $limitNum = $date['limitNum'];
            $id = $date['id'];

            ($buyNum > 0 && $buyPrice > 0) ? true : dexit(['res'=>1,"msg"=>"购买价格或者数量不能为0"]);
            $buyNum >= $limitNum ? true : dexit(['res'=>1,"msg"=>"购买的限制最低数量不得大于购买量"]);
            // 自动检测交易单生成订单
            $matchingList = D("Card_transaction")->where(['uid'=>["not in",$_SESSION['admin']['id']],'price'=>$buyPrice,"limit"=>["<=",$buyNum],"type"=>2])->order("createtime asc")->select();

        }
        $card = D("Card_package")->where(['uid'=>$_SESSION['admin']['id'],"type"=>"leka"])->find();
        $buyList = D("Card_transaction")->where(['card_id'=>$card['card_id'],"type"=>1])->select();
        $this->assign('card',$card);
        $this->assign('buyList',$buyList);
        $this->display();
    }

    public function sell()
    {
        $this->display();
    }
}

