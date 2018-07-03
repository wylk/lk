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
                    ->addFrom();
	}

    public function add($data)
    {
        $uid = 12;

        $contract_id =  md5($data['contract'].$uid);

        $dataArr = [];
        foreach ($data as $key => $value) {
            $field = D('Contract_field')->where(['val'=>$key])->find();
            $dataArr[] = array('uid'=>$uid,'val'=>$value,'c_id'=>$field['id'],'card_id'=>$contract_id);
        }

        if(!D('Card')->where(['card_id'=>$contract_id])->find()){
            D('Card')->data($dataArr)->addAll();
            $Account_book = new AccountBook();
            //卡包
            $dataPackage = [];
            $dataPackage['uid'] = $uid;
            $dataPackage['type'] = $data['contract'];
            $dataPackage['card_id'] = $contract_id;
            $dataPackage['num'] = $data['sum'];
            $dataPackage['address'] = $Account_book->addAccount( $this->encrypt(json_encode(['uid'=>$uid,'contract_id'=>$contract_id,'account_balance'=>$data['sum']])));
            if(D('Card_package')->data($dataPackage)->add()) 
                dexit(['error'=>0,'msg'=>'添加成功']);
            else 
                dexit(['error'=>0,'msg'=>'添加失败']);
            //记账hash field
            //$Account_book->addAccountBook($uid,$contract_id,$dataPackage['address'],$data['sum']);
            
        }else{
            dexit(['error'=>0,'msg'=>'只能使用一次喔']);
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
    public function encrypt($data){ 
        $key = '-----BEGIN PUBLIC KEY-----
        MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqWgSnGR1Q2zsICgq0hmqh22BvTGqyPelEv3mXzuQ9CNq6xmxYHPzcGqabjP0r/2tJE465AfD2Gf6EGT6LU2h6qxx0Jw3firixZmwyWJ6M5lqWJA0p2bjdUCqK2H7/+s6J3uTXJvLNggoaI2SXaJOoACq5uk4Rm6g7CN9TJNdxTlga6fOSUjzI6N3ba27Jmp4laWHFhHl93rKPSx/mv08p7P5sj9GMJMAHwFvjq+/xiUlX2kzW0qqQT3eXv7I8J6Qu6J8vb3K8UqUGd2DOoC9iVOiqtcp2u5uMSk+pgQqMK6UvnTQ838WxbEy9tnAB5MWzEmZETvC+5OHGTdEBqnCUQIDAQAB
        -----END PUBLIC KEY-----';  
        $encryptedList = array();
        $step          = 11700; 
        $encryptedData = ''; 
        $len = strlen($data); 
        for ($i = 0; $i < $len; $i += $step) {        
           $tmpData   = substr($data, $i, $step); 
           $encrypted = '';
            openssl_public_encrypt($tmpData, $encrypted, $key,OPENSSL_PKCS1_PADDING); 
           $encryptedList[] = ($encrypted);
        }    
         $encryptedData = base64_encode(join('', $encryptedList));
        return $encryptedData;
    }

}



