<?php
class offsetCard extends Card
{
	public function add_tpl()
	{
        import('HtmlForm');
		$html = new HtmlForm('add',"./cardmaking.php");
        $radio = [['val'=>0,'title'=>'免费','checked'=>'checked'],['val'=>1,'title'=>'收费','checked'=>'']];
        $option = [['val'=>1,'name'=>'北京'],['val'=>2,'name'=>'上海']];
        $checkbox = [['val'=>1,'title'=>'北京','checked'=>'checked'],['val'=>2,'title'=>'天津','checked'=>'']];
        return $html->input(['name','卡名'],['name',['reg','cn']])
                    //->radio(['is_free','是否收费'],$radio,'price')
                    ->input(['price','单价'],['price',['reg','floa']])
                    ->input(['sum','总量'],['sum',['reg','floa']])
                    ->input(['group','发布几份'],['group',['reg','int']])
                    ->upload('会员卡log','img_id','card_log')
                    ->textarea(['describe','卡券描述'])
                    ->resSuccess('./cardType.php')
                    ->addFrom();
	}

    //发卡
    public function add($datas)
    {
        $uid =$datas['uid'];
        $data = $datas['postData'];

        $contract_id =  md5($data['contract'].$uid);
        $dataArr = [];
        foreach ($data as $key => $value) {
            $field = D('Contract_field')->where(['val'=>$key])->find();
            $dataArr[] = array('uid'=>$uid,'val'=>$value,'c_id'=>$field['id'],'card_id'=>$contract_id);
        }

        $Account_book = new AccountBook();
        $json = json_encode(['uid'=>$uid,'contract_id'=>$contract_id,'account_balance'=>$data['sum']]);

        $address = $Account_book->addAccount($this->encrypt($json,option('version.public_key')));
        if(empty($address)){
            dexit(['error'=>1,'msg'=>'添加账本错误！']);
        }
        if(!D('Card')->where(['card_id'=>$contract_id])->find()){
            D('Card')->data($dataArr)->addAll();
            //卡包
            $dataPackage = [];
            $dataPackage['uid'] = $uid;
            $dataPackage['type'] = $data['contract'];
            $dataPackage['card_id'] = $contract_id;
            $dataPackage['num'] = $data['sum'];
            $dataPackage['is_publisher'] = 1;
            $dataPackage['address'] = $address;
            if(D('Card_package')->data($dataPackage)->add())
                dexit(['error'=>0,'msg'=>'添加成功']);
            else
                dexit(['error'=>1,'msg'=>'添加失败']);
        }else{
            dexit(['error'=>1,'msg'=>'只能使用一次喔']);
        }
    }

    //添加新卡包
    public function addCardPackage($data)
    {
        import('AccountBook');
        $Account_book = new AccountBook();
        $json = json_encode(['uid'=>$data['uid'],'contract_id'=>$data['card_id'],'account_balance'=>0]);
        $address = $Account_book->addAccount(encrypt($json,option('version.public_key')));
        $card['address'] = $address;
        $card['type'] = 'offset';
        $card['card_id'] = $data['card_id'];
        $card['uid'] = $data['uid'];
        return D('Card_package')->data($card)->add();

    }
    public function receive()
    {
    	echo "in receive";
    }

    public function verification()
    {
    	echo "in verification";
    }
}



