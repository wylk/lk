<?php
/*
  卡卷管理
 */
class coiling_controller extends base_controller
{
    //浏览页面
	public function index()
    {
        $Contract = D('Contract')->where()->select();
        $this->assign('Contract',$Contract);
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
        }
        // dump($cards);
        $this->assign('cards',$cards);

        $this->display();
    }
}
