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

            //卡包
            $dataPackage = [];
            $dataPackage['uid'] = $uid;
            $dataPackage['card_id'] = $contract_id;
            $dataPackage['num'] = $data['sum'];
            $dataPackage['address'] = md5($uid.$contract_id);
            D('Card_package')->data($dataPackage)->add();

            //记账hash field
            $hsah = D('Account_book')->field('hash')->where('')->find();
            $new_block = new block($dataPackage['address'],$data['sum'],$contract_id,time(),$hsah['hash']);

            $accountData = array();
            $accountData['address'] = $new_block->address;
            $accountData['account_balance'] = $new_block->account_balance;
            $accountData['card_id'] = $new_block->card_id;
            $accountData['time'] = $new_block->time;
            $accountData['hash'] = $new_block->hash;

            D('Account_book')->data($accountData)->add();
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

/**
* 
*/
/*class ClassName extends AnotherClass
{
    
    function __construct(argument)
    {
        # code...
    }
}*/


class block
{  
    private $address;  
    private $account_balance;  
    private $card_id;  
    private $time; 
    private $previous_hash; 
    private $hash;

    public function __construct($address,$account_balance,$card_id,$time,$previous_hash)  
    {  
        $this->address = $address;  
        $this->account_balance = $account_balance;  
        $this->card_id = $card_id;  
        $this->time = $time;  
        $this->random_str=$random_str;  
        $this->previous_hash = $previous_hash;  
        $this->hash = $this->hash_block();  
    }

    public function __get($name){  
        return $this->$name;  
    }

    private function hash_block(){  
        $str=$this->address.$this->account_balance.$this->card_id.$this->time.$this->previous_hash;  
        return hash("sha256",$str);  
    }

}

