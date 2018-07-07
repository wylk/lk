<?php 

/**
*   账单类
*/
class AccountBook 
{
    private $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCpaBKcZHVDbOwgKCrSGaqHbYG9MarI96US/eZfO5D0I2rrGbFgc/NwappuM/Sv/a0kTjrkB8PYZ/oQZPotTaHqrHHQnDd+KuLFmbDJYnozmWpYkDSnZuN1QKorYfv/6zone5Ncm8s2CChojZJdok6gAKrm6ThGbqDsI31Mk13FOWBrp85JSPMjo3dtrbsmaniVpYcWEeX3eso9LH+a/Tyns/myP0YwkwAfAW+Or7/GJSVfaTNbSqpBPd5e/sjwnpC7ony9vcrxSpQZ3YM6gL2JU6Kq1yna7m4xKT6mBCowrpS+dNDzfxbFsTL22cAHkxbMSZkRO8L7k4cZN0QGqcJRAgMBAAECggEAaapeoWoPsoTIK66iNvaHZX2qhQXrzvqY3mW8Qf53hbBpykb2WoE4gRAdT0vc/cEvNAwPs5gcUmlYks1JNuTLcAMr4sDt5CZ/2Fzq5lIkgvbYXHFmRlxo2AQDoJe3hYOFfIcZ/ZO3hvZDriNP/lN001xXPTyPO29ZtLDWQONSg+cnVxBaPubL9v3THqjxZwL90nzXs1EUhHHKPtUT1tK/rjyb3TlS7HgtX/5w7MgtyLxcjuXrK1Bo1Q0IW5cnPti1A9rIA2TiwRJTqRxzsUCqsVQZL7mo0X/wB+U0hYiecq4xfQ0ZZu51hsaYj4aVwT66Eaf6quV1xFWqIZawg/rcAQKBgQDhymCgFeLbcnYtoEmeaIFffi6L4w/Wx/BcLapA6k1v0ilnqh8FzdVa4zvb3ll6F84jz+sw9x9dJY2Ld85/OC1lwqn7Jd0OuT3Gujv9jG3rfXGMJ3ZIdBWbdt54ij0Wak6UENU3H1V0LWXzxI6h8HH/IlzdeDfsUnmQQE70Z/Uk4QKBgQDAEngVKvaAULwy3akmbIuRbF47A3U9rofSBPEc1eUg9Xp5nxVQ8fVIZYTd2spDa7fUT+MMd1w18K2ygMljpbrajtwM0ibDEgeWVFHyAt2ztfGUBy/hBMvDL2TPldo3NnU4FNONVBttyA0ga+04uD+yC6HuWAWGdrqodSCpIejbcQKBgCq/njuw6RqTOTy6NDYBozzpLvbdLoqDoEZTfwB7W93n9F7kHquCpPpoO1UNa/NpvmWZX/YNU6rXCU12iWocwLubd4NNT+URvVh6uhDvHYCQZ4cZkZN2JwEgKE66HYa46deuuC+PhyZP0hWtCTQvyeV8JAjqUew0UT+2bTxo0kkBAoGAN89mCyiPtds/xDv6YYraxyfI/bbUg1bKanE7KljQmlIaA2sBQ6L61c2B3QEtEogjQ1LvM3kfVyEXJ64aVpUahVVLhYIu9zGu+LSJlxvUFdsBVjT8aZL+LjoAPf1aCf8N8nzCt+c/jRe7ELerl3aaM38Dz4DOIjMvq7FVCzAqPFECgYAh3nn1JpYmudyiHW/Ie78u7z9kV0C2IC0ZfvmA4NfKqRrUub2HGuzq7kFsWA7xVjBVsUZqtoZtAMetoTrJCVPuldzlo+7ovhHu+99AgRfnr8QIXgQe/NyO61DU14GXNSWN8Ck2dDYiBV7Xml9A+1T1NnXpsz6hayWGQCvLDQiwkw==
-----END RSA PRIVATE KEY-----';
    
    public function __construct()
    {
        
    }

    //账户余额转账$uid,$contract_id,$sendAddress,$num,$getAddress
    public function transferAccounts($encryptedData)
    {
    	$encrypte = $this->decrypt($encryptedData);

        $address1 = md5($encrypte['uid'].$encrypte['contract_id']);
        if($address1 == $encrypte['sendAddress']){
        	$num = $encrypte['num'];
        	$sendAddress = $encrypte['sendAddress'];
        	$getAddress = $encrypte['getAddress'];
        	$contract_id = $encrypte['contract_id'];

            $account_book = D('Account_book')->field('id,account_balance')->where(['address'=>$sendAddress])->order('id DESC')->find();
            $get_account_book = D('Account_book')->field('id,account_balance')->where(['address'=>$getAddress])->order('id DESC')->find();

            if($get_account_book && $account_book['account_balance'] > $num && $num > 0.0001){
                $this->commAccount($contract_id,$sendAddress,($account_book['account_balance'] - $num));
                $this->commAccount($contract_id,$getAddress,($get_account_book['account_balance'] + $num));
                $this->accontBill($encrypte);
                if(D('Account_book')->data(['now'=>1])->where(['id'=>['in',[$account_book['id'],$get_account_book['id']]]])->save()){
                	return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //添加账户
    public function addAccount($encryptedData)
    {
    	$encrypte = $this->decrypt($encryptedData);
        $address = md5($encrypte['uid'].$encrypte['contract_id']);
        if(!D('Account_book')->where(['address'=>$address])->find()){
            $aa = $this->commAccount($encrypte['contract_id'],$address,$encrypte['account_balance']); 
            if($aa) return $address;
        }else{
            return $address;
        }     
    }

    //数据修改
    public function commAccount($contract_id,$address,$account_balance = 0)
    {
    	
    	if(!$this->verify()){
    		die(dexit(['error'=>1,'msg'=>'账单不对']));
    	}
        $hsah = D('Account_book')->field('hash')->order('id DESC')->find();
        $new_block = new block($address,$account_balance,$contract_id,time(),$hsah['hash']);
        $accountData = array();
        $accountData['address'] =$new_block->address;
        $accountData['account_balance'] = $new_block->account_balance;
        $accountData['card_id'] = $new_block->card_id;
        $accountData['time'] = $new_block->time;
        $accountData['hash'] = $new_block->hash;
        $res = D('Account_book')->data($accountData)->add();
        return $res;
    }


    //记录交易详情
    public function accontBill($encrypte)
    {
    	$this->verifyBill();
    	$hsah = D('Account_book_bill')->field('hash')->order('id DESC')->find();
    	$new_block = new blockBill($encrypte['sendAddress'],$encrypte['getAddress'],$encrypte['num'],$encrypte['contract_id'],time(),$hsah['hash']);
    	$data = [];
    	$data['card_id'] = $new_block->card_id;
    	$data['address_send'] = $new_block->address_send;
    	$data['address_get'] = $new_block->address_get;
    	$data['num'] = $new_block->num;
    	$data['time'] = $new_block->time;
    	$data['hash'] = $new_block->hash;

    	D('Account_book_bill')->data($data)->add();
    }

    //验证
    public function verifyBill()
    {
    	$books = D('Account_book_bill')->order('id DESC')->limit('0,20')->select();
    	$res = true;
		foreach ($books as $k => $v) {
			if($k > 0){
				$new_block = new blockBill($books[$k-1]['address_send'],$books[$k-1]['address_get'],$books[$k-1]['num'],$books[$k-1]['card_id'],$books[$k-1]['time'],$v['hash']);
				if($books[$k-1]['hash'] != ($new_block->hash)){
					$res = false;
				}
			}
		}
		if(!$res){
			if(IS_AJAX){
				die(dexit(['error'=>1,'msg'=>'流水账单不对']));
			}else{
				dump(['error'=>1,'msg'=>'流水账单不对']);
			}
		}
    }
    //验证
    public function verify()
    {
    	$books = D('Account_book')->order('id DESC')->limit('0,20')->select();
    	$res = true;
		foreach ($books as $k => $v) {
			if($k > 0){
				$new_block = new block($books[$k-1]['address'],$books[$k-1]['account_balance'],$books[$k-1]['card_id'],$books[$k-1]['time'],$v['hash']);
				if($books[$k-1]['hash'] != ($new_block->hash)){
					$res = false;
				}
			}
		}
		return $res;
    }

    //解密
    function decrypt($encryptedData)
	{
        if (empty($encryptedData)) {
            return '';
        }
        $encryptedData = base64_decode($encryptedData);
        $decryptedList = array();
        $step          = 12800;
        $len = strlen($encryptedData);
        for ($i = 0; $i < $len; $i += $step) {
            $data      = substr($encryptedData, $i, $step);
            $decrypted = '';
            @openssl_private_decrypt($data, $decrypted, $this->private_key, OPENSSL_PKCS1_PADDING);
            $decryptedList[] = $decrypted;
        }
        if($decrypted != ''){
        	return  json_decode(join('', $decryptedList),true);
        }else{
        	die(dexit(['error'=>2,'msg'=>'非法访问']));
        }
	}

}


class blockBill
{  
    private $address_send;  
    private $address_get;  
    private $num;  
    private $card_id;  
    private $time; 
    private $previous_hash; 
    private $hash;

    public function __construct($address_send,$address_get,$num,$card_id,$time,$previous_hash)  
    {  
        $this->address_send = $address_send;  
        $this->address_get = $address_get;  
        $this->num = $num;  
        $this->card_id = $card_id;  
        $this->time = $time; 
        $this->previous_hash = $previous_hash;  
        $this->hash = $this->hash_block();  
    }

    public function __get($name){  
        return $this->$name;  
    }

    private function hash_block(){  
        $str = $this->address_send.$this->address_get.round($this->num).$this->card_id.$this->time.$this->previous_hash; 
        return hash("sha256",$str);  
    }

}

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
        $this->previous_hash = $previous_hash;  
        $this->hash = $this->hash_block();  
    }

    public function __get($name){  
        return $this->$name;  
    }

    private function hash_block(){  
        $str = $this->address.round($this->account_balance).$this->card_id.$this->time.$this->previous_hash; 
        return hash("sha256",$str);  
    }

}