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
                    //->input(['price','单价'],['price',['reg','floa']])
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
            $dataArr[] = array('uid'=>$uid,'val'=>$value,'c_id'=>$field['id'],'card_id'=>$contract_id,'type'=>'offset');
        }

        $Account_book = new AccountBook();
        $json = json_encode(['uid'=>$uid,'contract_id'=>$contract_id,'account_balance'=>$data['sum']]);

        $address = $Account_book->addAccount(encrypt($json,option('version.public_key')));
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

    //首页展示

    public function indexHtml($data)
    {
        $type = "offset";
        $store_package = D('')->table("Card_package as a")
                              ->join('User_audit as b ON a.uid=b.uid','LEFT')
                              ->join('Card as c ON a.uid=c.uid','LEFT')
                              ->where("a.type='".$type."' and a.is_publisher=1 and c.c_id=2 and c.type='offset' and b.status=1 and b.isdelete=0")
                              ->field("a.card_id as card_id,b.*,c.val as logo")
                              ->limit((($data['i']-1)*10).",10")
                              ->select();
        if($store_package){

        $str = '';
        foreach ($store_package as $k => $v) {
            $str .=  <<<EOM
            <div class="store">
                            <div class="img">
                                <img src="{$v['logo']}" class="imgs"/>
                            </div >
                            <div class="price">{$v['enterprise']}</div>
                            <div class="num">
                                <a  href="./home.php?card_id={$v['card_id']}&plugin=offset&shoreUid={$v['uid']}" class="layui-btn home">交易</a>
                            </div>
                          </div>
                      <hr>
EOM;
        }
            dexit(['error'=>0,'msg'=>$str]);
        }else{
            dexit(['error'=>1,'msg'=>'加载完成']);
        }
       

    }

    public function homeHtml($data)
    {
        $datas = D('')->table("Card_transaction as a")
                        ->join('User_audit as b ON a.uid=b.uid','LEFT')
                        ->where("a.card_id='".$data['card_id']."' and a.status=0")
                        ->field("a.*,b.uid as b_uid,b.type as b_type,b.name as b_name")
                        ->order("b_type desc")
                        ->limit((($data['i']-1)*10).",10")
                        ->select();
        if($datas){
        $str = '';
        foreach ($datas as $k => $value) {
            $b_type = $value['b_type'] == 1 ?'个人认证':'店铺认证';
            $price = number_format($value['price'],2);
            $limit = number_format($value['limit'],0).'-'.number_format($value['num'],0);
            $str .=  <<<EOM
           <div class="home-plugin-info-row">
             <div class="home-plugin-info-row-card line-heights">
                <div class="home-plugin-info-row-card-img">
                    <img src="http://img2.imgtn.bdimg.com/it/u=2883786711,2369301303&fm=200&gp=0.jpg" style="height:100%;width:100%;border-radius: 20%;">
                </div>
             </div>
             <div class="home-plugin-info-row-card row-card2">
                <div style="height: 50px;line-height: 28px">
               <p><span style="font-weight: bold">{$value['b_name']}</span><span class="layui-badge layui-bg-orange">
                {$b_type}
               </span></p>
               <p>单价:¥&nbsp <span style="color:red;">{$price}</span> &nbsp;&nbsp; 限制:&nbsp;{$limit}</p>
               </div>
             </div>
             <div class="home-plugin-info-row-card card-3 line-heights" >
                <a href="./receive.php?id={$value['id']}&uid={$value['uid']}" class="layui-btn layui-btn-primary">购买</a>
             </div>
         </div>
         <hr>
EOM;
        }
            dexit(['error'=>0,'msg'=>$str]);
        }else{
            dexit(['error'=>1,'msg'=>'加载完成']);
        }
    }
}



