<?php

/**
*   对接接口的类
*/
class  Api{
        public function __construct()
        {
               // $this->addUser();
               // 1.解析xml
               // 2.验签
               // 商城那边调用接口方法(商城那边传api_name)
               // 传过来什么就调用下面什么方法
        }
        //注册
        public static function addUser($data)
        {
            $phone = $data['phone']; // 接手机号
//            $avatar = $data['avatar']; // 接头像
//            $name = $data['name']; // 接用户名
//            $ip = $data['ip']; // 接ip
//            $num = $data['num'];// 接随机数
            $phoneRes = D("User")->field("id")->where(['phone'=>$phone])->find();
            if(!$phoneRes){
                // 注册账户接口
                $platformObj = new PlatformCurrency();
                $addAccountRes = $platformObj->addAccountInterface($data);
                if($addAccountRes['res'])   dexit($addAccountRes);
            }
        }






        //添加会员卡
        public  static function addMembership_card()
        {

        }

        //会员卡列表
        public  static function listMembership_card()
        {

        }
        //会员卡余额
        public  static function balanceMembership_card()
        {

        }
        //添加订单
        public  static function addOrder()
        {

        }
        //转账
        public  static function add_Transfer_accounts()
        {

        }

}
$a=new Api();
$b=$a->addUser();
echo $b;









