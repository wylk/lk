<?php
require_once dirname(__FILE__).'/global.php';
/**
*   对接接口的类
*/
class  Api{

        public $key;


        public function __construct()
        {
               // $this->addUser();
               // 1.解析xml
               // 2.验签
               // 商城那边调用接口方法(商城那边传api_name)
               // 传过来什么就调用下面什么方法
        }
        //注册
        public  function addUser($data)
        {
            $phone = $data['phone'];
            $phoneRes = D("User")->field("id")->where(['phone'=>$phone])->find();
            if(!$phoneRes){
                import("PlatformCurrency");
                $platformObj = new PlatformCurrency();
                $addAccountRes = $platformObj->addAccountInterface($data);
                if($addAccountRes['res'])   dexit($addAccountRes);
                dexit(['res'=>0,"msg"=>'注册成功']);
            }else{
                dexit(['res'=>4,"msg"=>'账号已经注册']);
            }
        }

        //添加会员卡
        public   function addMembership_card()
        {

        }

        //会员卡列表
        public  function listMembership_card()
        {

        }
        //会员卡余额
        public  function balanceMembership_card()
        {

        }
        //添加订单
        public   function addOrder()
        {

        }
        //转账
        public   function add_Transfer_accounts()
        {

        }
        public function sign($data){
        $str = $this->arrayToUrlstr($data,false);
        $str = $str."&key=".$this->key;
        $str = md5($str);
        $str = strtoupper($str);
        return $str;
        }
        public function arrayToUrlstr($data,$urlencode){
          ksort($data);
          $str = "";
          foreach($data as $key=>$value){
            if($urlencode) $value = urlencode($value);
            $str .= $key."=".$value."&";
           }
          $str = substr($str,0,-1);
          return $str;
        }
        public function xmlToArray($xml){
          $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
              return $array_data;
        }
}
$data['phone']='173160751110';
$data['name']='小小';
$data['avatar']='123';
$text=new Api();
$msg=$text->addUser($data);
var_dump($msg);













