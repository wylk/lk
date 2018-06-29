<?php
class offsetCard extends Card
{
	public function add_tpl()
	{
        import('HtmlForm');
		$html = new HtmlForm('add',url('user:config:test',[],1));
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
                    ->addFrom();
	}

    public function add($data)
    {
        //dump($data);
        $uid = 214;

        $contract_id =  md5($data['contract'].$uid);

        $dataArr = [];
        foreach ($data as $key => $value) {
            $field = D('Contract_field')->where(['val'=>$key])->find();
            $dataArr[] = array('uid'=>214,'val'=>$value,'c_id'=>$field['id'],'card_id'=>$contract_id);
        }
        if(!D('Card')->where(['card_id'=>$contract_id])->find()){
            D('Card')->data($dataArr)->addAll();
            $Account_book = new AccountBook();
            //卡包
            $dataPackage = [];
            $dataPackage['uid'] = $uid;
            $dataPackage['card_id'] = $contract_id;
            $dataPackage['num'] = $data['sum'];
            $dataPackage['address'] = $Account_book->addAccount($uid,$contract_id);
            D('Card_package')->data($dataPackage)->add();
            //记账hash field
            $Account_book->addAccountBook($uid,$contract_id,$dataPackage['address'],$data['sum']);
            dexit(['error'=>0,'msg'=>'添加成功']);
        }
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



