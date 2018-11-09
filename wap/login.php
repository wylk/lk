<?php
require_once dirname(__FILE__).'/global.php';
$verifyLen = "6";  //验证码长度
//$referer=clear_html($_GET['referer']);
$referer = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $config['site_url']);

if (strpos($referer,'&amp;')) {
    $referer = str_replace('&amp;','&',$referer);
}
// 判断是否是微信、支付宝、手机号登录
// 1、微信号
// 2、支付宝
// 3、手机号登录

//dump($config['reg_readme_content']);
// 手机号注册 ajxa请求处理

if(isset($_POST['phone'])){
    // ajax判断该用户账号是否存在
    if(isset($_POST['type']) && $_POST['type'] == "check"){
        $res = M("lk_user")->findField("id,phone","phone=".$phone);
        if($res) $res1 = ["res"=>false,'msg'=>"该手机号已经被注册"];
        else $res1 = ["res"=>true,"msg"=>"该手机号可以注册"];
        echo dexit($res1);
        exit();
    }
    // 验证码获取
    if(isset($_POST['type']) && $_POST['type'] == "code"){
        import("transfer");
        $a = new Transfer();
        $getPhone = $_POST['phone'];
        $code = rangdNumber($verifyLen);
        $result = $a->message($getPhone,array("code"=>$code));
        $_SESSION['verify'][$getPhone] = $code;
        dexit(['result'=>$result,'code'=>$code]);
    }
    // 退出登录
    if(isset($_POST['type']) && $_POST['type'] == "signOut"){
        session_destroy();
        if(is_weixin()){
            dexit(['error'=>0,'msg'=>'清除成功']);
        }else{
            dexit(['error'=>0,'msg'=>'退出成功']);
        }


    }

    // 验证码登录
    if(isset($_POST['logintype']) && $_POST['logintype'] == "checkAccount"){
        $phone = trim($_POST['phone']);
        $code = trim($_POST['password']);
        import("PlatformCurrency");
        $platformObj = new PlatformCurrency();
        $unphone = $platformObj->getPhone();
        if($unphone == $phone) dexit(["res"=>1,'msg'=>"该手机号无登录权限"]);
        // if($code != $_SESSION['verify'][$phone]){
        //  dexit(["res"=>1,'msg'=>"验证码错误"]);
        // }
        $phoneRes = D("User")->field("id")->where(['phone'=>$phone])->find();

        if(!$phoneRes){
            // 注册账户接口
            $userdata = array();
            $userdata['phone'] = $phone;
            if(!empty($_SESSION['weixin']['userinfo'])){
                $userdata['openid'] = $_SESSION['weixin']['userinfo']['openid'];
                $userdata['name']     = $_SESSION['weixin']['userinfo']['nickname'];
                $userdata['avatar']   = $_SESSION['weixin']['userinfo']['headimgurl'];
            }
            $addAccountRes = $platformObj->addAccountInterface($userdata);
            if($addAccountRes['res'])   dexit($addAccountRes);
            $userid = $addAccountRes['data'];
        // dexit(["res"=>1,'msg'=>"test",'other'=>$addAccountRes]);
        }else{
            $userid = $phoneRes['id'];
            if(!empty($_SESSION['weixin']['userinfo'])){
                $userdata = array();
                $userdata['openid'] = $_SESSION['weixin']['userinfo']['openid'];
                $userdata['name']   = $_SESSION['weixin']['userinfo']['nickname'];
                $userdata['avatar'] = $_SESSION['weixin']['userinfo']['headimgurl'];
                D("User")->data($userdata)->where(['id'=>$userid])->save();
            }

        }
        $_SESSION['wap_user']["phone"] = $phone;
        $_SESSION['wap_user']['userid'] = $userid;
        $_SESSION['wap_user']['address'] =$addAccountRes['address'];
        $_SESSION['wap_user']['logintime'] = time();
        $_SESSION['wx']=$_SESSION['weixin']['userinfo'];

        dexit(["res"=>0,'msg'=>"登录成功","referer"=>$referer]);
    }
}
if(is_weixin()){
    $status = weixin_info();
//自动登录
    if($status['is_oauth'] == "1"){
        $userinfo = D("User")->field("id,phone")->where(['openid'=>$status['openid']])->find();
        $_SESSION['wap_user']["phone"] = $userinfo['phone'];
        $_SESSION['wap_user']['userid'] = $userinfo['id'];
        $_SESSION['wap_user']['logintime'] = time();
        // dump($_SESSION['wap_user']);
        redirect($referer);
        //header("Location:https://bcc.51ao.com/wap/my.php");
    }

}

    include display("login");

























