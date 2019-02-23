<?php
require_once dirname(__FILE__).'/global.php';
/**
*   对接接口的类
*/
class  Api{

        public $key;
        public $auditInfo;


        public function __construct()
        {
        }
        //注册
        public  function addUser($data)
        {
            if($data['appid'] != $data['mch_id'])
                return ['error'=>1,"msg"=>"请传入正确的工商号"];
            if($this->auditInfo['type'] != 3)
                return ['error'=>1,"msg"=>"该密钥没有注册权限"];
            $phone = $data['phone'];
            if(empty($phone)){
                return ['error'=>1,"msg"=>"未传手机号"];
            }
            if(strlen($phone)!='11'){
                return ['error'=>1,"msg"=>"传值：手机号格式错误"];
            }
            $phoneRes = D("User")->field("id")->where(['phone'=>$phone])->find();
            if(!$phoneRes){
                import("PlatformCurrency");
                $platformObj = new PlatformCurrency();
                $addAccountRes = $platformObj->addAccountInterface(['phone'=>$phone,"name"=>$data['name'],"avatar"=>$data['avatar']]);
                if($addAccountRes['res'])   dexit($addAccountRes);
                $res = D("User")->data(['platform_uid'=>$this->auditInfo['uid']])->where(['id'=>$addAccountRes['data']])->save();
                if(!$res) return ['error'=>1,"msg"=>"数据修改有误"];
                return ['error'=>0,"msg"=>'注册成功',"data"=>$addAccountRes['data']];
            }else{
                return ['error'=>1,"msg"=>'手机号已经注册'];
            }
        }

        //添加会员卡
        public   function addMembershipcard($data)
        {
            $mch_id=D('User_audit')->where(array('mid'=>$data['mch_id']))->find();
            if(empty($mch_id)){
                return ['error'=>1,'msg'=>"没有该店铺"];
            }
            $phone=$data['phone'];
            $uid=D('User')->where(array('phone'=>$phone))->find();
            if(!$uid){
                return ['error'=>1,'msg'=>"没有乐卡用户"];
            }
            $card_type=$data['card_type'];
            if(empty($card_type)){
                return ['error'=>1,"msg"=>"卡的类型错误"];
            }
            $shopid=D('User_audit')->where(array('mid'=>$data['mch_id']))->find();
            //查出来卡的id
            $card=D('Card_package')->where(array('uid'=>$shopid['uid'],'type'=>$card_type,'is_publisher'=>'1'))->find();
            $res=D('Card_package')->where(array('uid'=>$uid['id'],'card_id'=>$card['card_id']))->find();
            //没有就添加
            if(!$res){
                $contract = $data['card_type'];
                $res = hook('addCardPackage',['card_id'=>$card['card_id'],'uid'=>$uid['id']],$contract);
                    if($res){
                       return ['error'=>0,"msg"=>"添加成功","data"=>$res];
                    }else{
                       return ['error'=>1,"msg"=>"添加失败"];
                    }
            }else {
                return ['error'=>1,"msg"=>"卡券已存在"];
            }
        }

      //店铺会员卡列表
        public  function listMembershipcard($data)
        {

            $limit=$data['limit'];
            $user=D('User')->where(array('phone'=>$data['phone']))->find();
            $shopInfo=D('User_audit')->where(array('mid'=>$data['mch_id']))->find();
            if(empty($shopInfo['uid'])){
                return ['error'=>1,"msg"=>"店铺id错误"];
            }
            $card_type=$data['card_type'];
            if(empty($card_type)){
                return ['error'=>1,"msg"=>"卡的类型错误"];
            }
            if($data['money']<=0){
                return ['error'=>1,"msg"=>"传值：缺少必要参数、总价"];
            }
            $card=D('Card_package')->where(array('uid'=>$shopInfo['uid'],'type'=>$card_type,'is_publisher'=>'1'))->find();
            if(!$card){
                return ['error'=>1,"msg"=>"会员卡不存在"];
            }
            $transactions = D('Card_transaction')->field('id,((num-frozen)*price) as total,(num-frozen) as num,price,uid,card_id')->where(array('card_id'=>$card['card_id'],'status'=>0,'type'=>0,'limit'=>['<=',$data['money']],'uid'=>['!=',$user['id']]))->order('price asc')->select();
            $transaction = array();
            foreach ($transactions as $key => $value) {
                if($value['total']>0){
                    $transaction[] = $value;
                }
            }
            $arr = array();
            $len = count($transaction);
            foreach ($transaction as $k => $v) {
                if(floatval($v['total']) > 0){
                    if($v['num'] >= $data['money'] || $len == 1){
                        $arr[$k] = $v;
                        if($v['num'] >= $data['money']){
                            $arr[$k]['sum_total'] =$data['money'] - $data['money']*$v['price'];
                            $arr[$k]['prices'] = $data['money']*$v['price'];
                            $arr[$k]['buy_num']  =  $data['money'];
                        }else{
                            $arr[$k]['sum_total'] =$v['num'] - $v['num']*$v['price'];
                            $arr[$k]['prices'] = $v['num']*$v['price'];
                            $arr[$k]['buy_num']  =  $v['num'];
                        }
                    }else{
                        $sum_total = 0;
                        $sum_total = floatval($v['total']);
                        $card_id   = $v['card_id'];
                        $arr[$k][$k] = $v;
                        $num = $v['num'];

                        foreach ($transaction as $kk => $vv) {
                            if($vv['total'] > 0 && $v['id'] != $vv['id']){
                                $v['num']+=$vv['num'];
                                if($v['num'] >= $data['money']){
                                    $sum_total += ($data['money']-$num)*$vv['price'];
                                    $arr[$k][$kk] = $vv;
                                    $arr[$k]['sum_total']  =$data['money'] -  $sum_total;
                                    $arr[$k]['card_id']  =  $card_id;
                                    $arr[$k]['prices']  =  $sum_total;
                                    $arr[$k]['buy_num']  =  $data['money'];
                                    break;
                                }
                                $num+=$vv['num'];
                                $sum_total+=  $vv['total'];
                                $arr[$k][$kk] = $vv;

                                if(($len-1) == $kk || $transaction[$len-1]['id'] == $v['id']){
                                    $arr[$k]['sum_total']  =  $v['num'] - $sum_total;
                                    $arr[$k]['card_id']  =  $card_id;
                                    $arr[$k]['prices']  =  $sum_total;
                                    $arr[$k]['buy_num']  =  $v['num'];
                                }
                            }

                        }

                    }
                }

            }
            array_multisort(array_column($arr,'sum_total'),SORT_DESC,$arr);
            if(empty($limit)){
               $arr = array_slice($arr,0,20);
            }else{
               $arr = array_slice($arr,0,$limit);
            }

            $data = transformArray($arr,'sum_total');
            $combination = func_gzcompress(serialize($arr));//先序列化再压缩
            $combination_id = D('Combination')->data(['content'=>$combination])->add();
            if(empty($transactions)){
                return ['error'=>1,"msg"=>'店铺还未有出售的会员卡',"data"=>[$transactions,$transaction]];
            }
            if(empty($combination_id)){
                return ['error'=>1,"msg"=>'组合数据错误'];
            }
            return ['error'=>0,'data'=>["list"=>$data,'combination_id'=>$combination_id]];

        }
         //会员卡余额
        public  function balanceMembershipcard($data){
            $card_type=$data['card_type'];
            $card=D('Card_package')->where(array('uid'=>$this->auditInfo['uid'],'type'=>$card_type,'is_publisher'=>'1'))->find();
            $phone=$data['phone'];
            $uid=D('User')->where(array('phone'=>$phone))->find();
            $res=D('Card_package')->where(array('uid'=>$uid['id'],'card_id'=>$card['card_id']))->find();
            if(!$res){
                return ['error'=>1,"msg"=>'会员卡参数错误'];
            }
            return ['error'=>0,"msg"=>"余额详情",'data'=>['money'=>$res['num']]];
        }

        //选择卡券接口
        public function  chooseCard($data)
        {
            $comb = D('Combination');
            if($comb->where(array('id'=>$data['combination_id'],'status'=>0))->find()){
                $status = $comb->data(['kv'=>$data['combination_key'],'add_time'=>time()])->where(array('id'=>$data['combination_id']))->save();
                if($status){
                    return ['error'=>0,'msg'=>"选择成功"];
                }else{
                    return ['error'=>1,'msg'=>"选择失败"];
                }
            }else{
                return ['error'=>1,'msg'=>"数据不存在"];
            }
        }

      //添加订单
     public   function addOrder($data)
        {
            $phone=$data['phone'];
            $uid=D('User')->where(array('phone'=>$phone))->find();
            if(empty($uid['id'])){
                return ['error'=>1,'msg'=>'没有乐卡用户'];
            }
            $id=D('User_audit')->where(array('mid'=>$data['appid']))->find();
            if(empty($id)){
                return ['error'=>1,'msg'=>"没有平台账号请申请"];
            }
            $combination_id=$data['combination_id'];
            $orderid=D('Orders')->where(['combination_id'=>$combination_id])->find();
            if($orderid){
                 return ['error'=>2,'msg'=>"订单已存在",'data'=>['order_id'=>$orderid['id']]];
            }
            $combfunction=D('Combination')->where(array('id'=>$combination_id))->find();
            $key=$combfunction['kv'];
            $res = unserialize(func_gzuncompress($combfunction['content']));
            $card=$res[$key];
            if(isset($card['id'])){
                $tran = D('Card_transaction')->field('id,uid,card_id,address,price,(num-frozen) as num')->where(array('id'=>$card['id']))->find();
                if($card['buy_num']>$tran['num']){
                    return ['error'=>1,'msg'=>'卡券已被领取请重新选择领取'];
                }
                if( D('Card_transaction')->where(array('id'=>$tran['id']))->setInc('frozen',$card['buy_num'])){
                        $daTa['card_id'] = $card['card_id'];
                        $daTa['buy_id'] = $uid['id'];
                        $daTa['type'] = 2;
                        $daTa['prices'] =$card['price'];
                        $daTa['combination_id'] =$combination_id;
                        //平台uid
                        $daTa['app_id']=$id['uid'];
                        $daTa['create_time'] = time();
                        $daTa['number']=$data['money'];
                        $daTa['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
                        $daTa['out_trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
                        $addorder = D('Orders')->data($daTa)->add();
                        if($addorder){
                            D('Combination')->data(array('status'=>1))->where(array('id'=>$combination_id))->save();
                            $Arr['sell_id'] = $card['uid'];
                            $Arr['buy_id'] = $uid['id'];
                            $Arr['order_id'] = $addorder;
                            $Arr['create_time'] = time();
                            $Arr['price'] = $card['price'];
                            $Arr['num']=$card['buy_num'];
                            $Arr['combination_id']=$card['id'];
                            $res=D('Combination_order')->data($Arr)->add();
                            if(!$res){
                                return ['error'=>1,"msg"=>'订单记录添加失败'];
                            }else{
                                return ['error'=>0,"msg"=>'订单添加成功',"data"=>['order_id'=>$addorder]];
                            }
                        }
                }
            }else{
                $daTa['card_id'] = $card['card_id'];
                $daTa['buy_id'] = $uid['id'];
                $daTa['type'] = 2;
                $daTa['prices'] =$card['price'];
                $daTa['combination_id'] =$combination_id;
                //平台uid
                $daTa['app_id']=$id['uid'];
                $daTa['create_time'] = time();
                $daTa['number']=$card['buy_num'];
                $daTa['onumber'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
                $daTa['out_trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
                $addorder = D('Orders')->data($daTa)->add();
                if($addorder){
                     D('Combination')->data(array('status'=>1))->where(array('id'=>$combination_id))->save();
                    $new_arr = [];
                    $buy_num = $card['buy_num'];
                    foreach ($card as $key => &$value) {
                        if (is_int($key)) {
                            $card['buy_num']-=$value['num'];
                            if($card['buy_num']<=0){
                                $value['buy_num'] = ($card['buy_num']+$value['num']);
                            }else{
                                $value['buy_num'] = ($value['num']+0);
                            }
                            D('Card_transaction')->where(array('id'=>$value['id']))->setInc('frozen',$value['buy_num']);
                            $valStr .= "('".$value['uid']."','".$uid['id']."','".$addorder."','".time()."','".$value['price']."','".$value['buy_num']."','".$value['id']."'),";
                        }
                    }
                    $str = "(`sell_id`,`buy_id`,`order_id`,`create_time`,`price`,`num`,`combination_id`) ";
                    $str .= " value ".substr($valStr,0,-1);
                    $res=D('Combination_order')->data($str)->add();
                    if(!$res){
                        return ['error'=>1,"msg"=>'订单记录添加失败'];
                    }else{
                        return ['error'=>0,"msg"=>'订单添加成功',"data"=>$addorder];
                    }
                }
            }

        }

         //会员支付转账
        public function cardPay($data)
        {
            $appid=D("User_audit")->where(['mid'=>$data['appid']])->find();
            if(empty($appid)){
               return ['error'=>1,'msg'=>"传参错误：缺少appid"];
            }
            $user = D('User')->where(array('phone'=>$data['phone']))->find();
            if(!$user){
                return ['error'=>1,'msg'=>"用户不存在"];
            }
            if($user['pay_password'] != md5($data['pay_paw'])){
                return ['error'=>1,'msg'=>"支付密码错"];
            }
            $user_audit = D('User_audit')->where(array('mid'=>$data['mch_id']))->find();

            $store_card = D('Card_package')->where(['uid'=>$user_audit['uid'],'type'=>$data['card_type'],'is_publisher'=>1])->find();
            $user_card = D('Card_package')->where(['uid'=>$user['id'],'card_id'=>$store_card['card_id'],'is_publisher'=>0])->find();
            $userId = $user['id'];
            $cardId = $store_card['card_id'];
            $sendAddress = $user_card['address'];
            $getAddress = $store_card['address'];
            $num = $data['num'];
            if($num>$user_card['num']){
                return['error'=>1,"msg"=>"账户余额不足"];
            }
            $platform_user_audit = D('User_audit')->where(array('mid'=>$data['appid']))->find();
            $re_palatform = $this->Platform_calculation($platform_user_audit['uid'],$user_audit['uid'],$num);
            if($re_palatform['res'] != 0){
                 return ['error'=>1,'msg'=>"商家平台币余额不足,不能完成交易"];
            }
            // 添加账本信息
            // 判断转账卡券类型
            import("AccountBook");
            $Account_book = new AccountBook();
            $bookJson = json_encode(['uid'=>$userId,"contract_id"=>$cardId,'sendAddress'=>$sendAddress,"num"=>$num,"getAddress"=>$getAddress]);
            $bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));
            if(!$bookRes){
                return['error'=>1,"msg"=>"添加账本错误"];
            }
           // 卡券转账
            import("CardAction");
            $card = new CardAction(['userid'=>$userId]);
            $tranRes = $card->addressTran(['num'=>$num,"type"=>$data['card_type'],"cardId"=>$cardId,"sendAddress"=>$sendAddress,"getAddress"=>$getAddress]);

            // /*****余额支付接口数据统计 start *****/
            if(!D("Shop_inter")->where(['platform_id'=>$this->auditInfo['uid'],"inter_name"=>"余额支付"])->find()){
                D("Shop_inter")->data(['uid'=>$user_audit['uid'],"platform_id"=>$this->auditInfo['uid'],"inter_name"=>"余额支付"])->add();
            }
            $data = "num=`num`+1,money=`money`+$num";
            $res = D("Shop_inter")->data($data)->where(['uid'=>$user_audit['uid'],"inter_name"=>"余额支付"])->save();
            // /*****余额支付接口数据统计 end *****/

            return $tranRes;
          //平台币

        }


        public function Platform_calculation($platform_id,$sotre_id,$num)
        {
            import("PlatformCurrency");
            $platformObj = new PlatformCurrency(['userid'=>$platform_id]);
            $platformObj->payTran($platform_id,$sotre_id,$num);

        }
        //会员组合支付转账
        public   function add_Transferaccounts($data)
        {
            $order = D('Orders')->where(array('id'=>$data['order_id'],'type'=>2))->find();
            if(!$order){
                return ['error'=>1,'msg'=>"订单不存在"];
            }
            if($order['status']!=0){
                return ['error'=>1,'msg'=>order_status($order['status'])];
            }
            //企业号
            $user_audit = D('User_audit')->where(array('mid'=>$data['appid']))->find();
            $rest = D('Card_package')->where(array('uid'=>$user_audit['uid'],'type'=>'leka'))->find();

            if($order['number']>$rest['num']){
                return ['error'=>1,'msg'=>"平台币余额不足,请选择别的付款方式"];
            }
            $card_package_obj = D('Card_package');
            //店铺卡包
            $card_package_store = $card_package_obj->where(['card_id'=>$order['card_id'],'is_publisher'=>1,'type'=>'offset'])->find();

            $res = D('Combination_order')->where(array('order_id'=>$data['order_id']))->select();
            import("AccountBook");
            $Account_book = new AccountBook();
            import("CardAction");
            import("PlatformCurrency");

            $sell_id=$rest['uid'];//企业号uid
            $getAddress=$card_package_store['address'];//店铺卡包地址
            $cardId=$order['card_id'];//卡id

            $re_palatform = $this->Platform_calculation($sell_id,$card_package_store['uid'],$order['number']);
            if($re_palatform['res'] != 0){
                 return ['error'=>1,'msg'=>"商家平台币余额不足,不能完成交易"];
            }
            $combine_inter_num = 0;
            foreach ($res as $k => $v) {
                $stores=D('Card_transaction')->where(array('id'=>$v['combination_id'],'card_id'=>$order['card_id']))->find();
                $sendAddress=$stores['address'];//卖家卡包地址
                $userId=$v['sell_id'];
                $lk_num=$v['num'];                    //会员卡数量
                $num = $v['price']*$v['num'];
                //卖家=店铺
                if($v['sell_id'] != $card_package_store['uid']){
                    //转让会员卡到店铺卡包
                    $bookJson = json_encode(['uid'=>$userId,"contract_id"=>$cardId,'sendAddress'=>$sendAddress,"num"=>$v['num'],"getAddress"=>$getAddress]);
                    $bookRes = $Account_book->transferAccounts(encrypt($bookJson,option('version.public_key')));
                    $bookRes = true;

                    if($bookRes){
                    // 卡券转账
                        $card = new CardAction(['userid'=>$userId]);
                        $tranRes = $card->addressTran(['num'=>$lk_num,"type"=>$data['card_type'],"cardId"=>$cardId,"sendAddress"=>$sendAddress,"getAddress"=>$getAddress],1);
                    }

                }else{
                    $combine_inter_num += $lk_num;
                    $combine_inter_shopId = $card_package_store['uid'];
                }
                //转平台币
                $platformObj = new PlatformCurrency(['userid'=>$userId]);
                $platformObj->payTran($userId,$sell_id,$num);
                if($stores['num'] == $stores['frozen']){
                    D('Card_transaction')->data(array('status'=>1))->where(array('id'=>$stotres['id']))->save();
                }

            }
                $order_status=D('Orders')->data(array('status'=>3))->where(array('id'=>$order['id']))->save();
                $this->Platform_calculation($sell_id,$card_package_store['uid'],$order['number']);

            // /*****组合支付接口数据统计 start *****/
            if($combine_inter_num>0){
                if(!D("Shop_inter")->where(['platform_id'=>$this->auditInfo['uid'],"inter_name"=>"组合支付"])->find()){
                    $a = D("Shop_inter")->data(['uid'=>$combine_inter_shopId,"platform_id"=>$this->auditInfo['uid'],"inter_name"=>"组合支付"])->add();
                }
                $data = "num=`num`+1,money=`money`+$combine_inter_num";
                $res = D("Shop_inter")->data($data)->where(['uid'=>$combine_inter_shopId,"inter_name"=>"组合支付"])->save();
            }
            // /*****余额支付接口数据统计 end *****/

                if(!$order_status){
                        return ['error'=>1,'msg'=>"付款失败"];
                }else{
                        return ['error'=>0,'msg'=>"付款成功"];
                }
        }


        public function sign($data)
        {
        $str = $this->arrayToUrlstr($data,false);
        $str = $str."&key=".$this->key;
        $str = md5($str);
        $str = strtoupper($str);
        return $str;
        }
        public function arrayToUrlstr($data,$urlencode)
        {
          ksort($data);
          $str = "";
          foreach($data as $key=>$value){
            if($urlencode) $value = urlencode($value);
            $str .= $key."=".$value."&";
           }
          $str = substr($str,0,-1);
          return $str;
        }
        public function xmlToArray($xml)
        {
          $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
              return $array_data;
        }
        public function checkSign($data)
        {
            $sign = $data['sign'];
            unset($data['sign']);
            $checkSign = $this->sign($data);
            if($sign != $checkSign)
                return false;
                // return ['sign'=>$sign,"checkSign"=>$checkSign];
            return true;
        }
        public function checkMidKey($data){
            if(empty($data['mch_id']) || empty($data['appid']))
                return ['error'=>1,"msg"=>"链接失败，请核对参数",'data'=>$data];
            $platform = D("User_audit")->where(['mid'=>$data['mch_id']])->find();
            if(!$platform)
                return ['error'=>1,"msg"=>"该平台未注册"];
            $this->auditInfo = D("User_audit")->where(['mid'=>$data['mch_id']])->find();
            if(!$this->auditInfo)
                return ['error'=>1,"msg"=>"校验失败"];
            $this->key = $this->auditInfo['mid_key'];
            return ['error'=>0,"msg"=>"校验正确"];
        }
}
$xml = file_get_contents("php://input");
//$xml = '<xml><phone>18811480487</phone><action><![CDATA[listMembershipcard]]></action><money>128</money><card_type><![CDATA[offset]]></card_type><appid>75188889999</appid><mch_id>25173987903</mch_id><nonce_str><![CDATA[69n522elza9gipvecijjd5dwmt4oi0mu]]></nonce_str><sign><![CDATA[BF52165D04D828190ADD37B19460DD66]]></sign></xml>';
file_put_contents('./xml.txt', $xml);
$api = new Api();
$data = $api->xmlToArray($xml);
// dexit(['errr'=>"dfgdfg","data"=>$data]);
// 检验资格
$checkRes = $api->checkMidKey(["appid"=>$data['appid'],'mch_id'=>$data['mch_id']]);
if($checkRes['error']) dexit($checkRes);
// 验签
if(!$api->checkSign($data)) dexit(['res'=>1,"msg"=>"传输错误，请核对参数","sign"=>$data['sign']]);

if(isset($data['action'])){
    $res = $api->$data['action']($data);
    if($res['error'])  dexit($res);
    dexit(['error'=>0,"msg"=>$res['msg'],"data"=>$res['data']]);
    // dexit($api->$data['action']($data));
}else
    dexit(['error'=>1,"msg"=>"缺少必备参数","data"=>$data]);


















