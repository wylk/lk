<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
$userId = $wap_user['userid'];
$phone = $wap_user['phone'];

if($_POST['type'] == 'verify'){
	$code = rangdNumber($verifyLen);
	$obj = new Transfer();
	$messageRes = $obj->message($phone,["code"=>$code]);
	if($messageRes['result']['success']){
		$_SESSION['verify'][$phone] = $code;
		echo json_encode(['messageRes'=>$messageRes['result']['success'],"code"=>$code]);
	}else{
		echo json_encode(['messageRes'=>false]);
	}
	exit();
}
if($_POST['type'] == "apply"){
	$pwd = $_POST['pwd'];
	// if($pwd != $_SESSION['verify'][$phone])
	// 	dexit(['res'=>1,"msg"=>"验证码错误！"]);

	$str1 = strrev(substr($phone,0,3));
	$str2 = strrev(substr($phone,3,4));
	$str3 = strrev(substr($phone,7));
	$mid = $str1.$str2.$str3;

	$key = md5($phone."-".$userId);

	$res = D("User_audit")->data(['mid'=>$mid,"mid_key"=>$key])->where(['uid'=>$userId])->save();
	if($res) dexit(['res'=>0,"msg"=>"您的审核已提交成功"]);
	else dexit(['res'=>1,"msg"=>"您的审核提交失败，请您重新提交"]);
}
if($_POST['type'] == 'switch'){
	$val = $_POST['val'];
	$status = $_POST['status'];
	if($status == 1){
		$shop_inter = D("Shop_inter")->field("switch_set")->where(['uid'=>$userId,"platform_id"=>$val])->select();
		foreach ($shop_inter as $key => $value) {
			if($value['switch_set'] == 0)
				dexit(['res'=>1,"msg"=>"此接口尚未开通，请联系管理员"]);
		}
	}
	$res = D("Shop_inter")->where(['uid'=>$userId,"platform_id"=>$val])->data(['status'=>$status])->save();
	if($status) $status = '打开';
	else $status = "关闭";
	if($res) dexit(['res'=>0,"msg"=>"您已成功<span style='color:red;'>{$status}</span>接口"]);
	dexit(['res'=>1,"msg"=>"接口开关修改失败"]);
	// if($res) dexit(['res'=>0,"msg"=>"接口开关设置成功"]);
	// dexit(['res'=>1,"msg"=>"接口开关设置失败","data"=>[$res,[$val,$status]]]);
}

$userInfo = D("User_audit")->where(['uid'=>$userId])->find();

$phoneShow = substr($phone,0,3)."****".substr($phone,7);


$field = "platform_id,group_concat(concat_ws('_',inter_name,num,status) order by inter_name desc) as info";
$inter_info = D("Shop_inter")->field($field)->where(['uid'=>3])->group("platform_id")->select();
$inter_arr = [];
foreach($inter_info as $key=>$value){
	if(!empty($value['info'])){
		$inter = explode(",",$value['info']);
		$i = false; $j = true;
		foreach($inter as $k=>$v){
			$hh = explode("_",$v);
			if(!empty($hh[0])){
				$inter_arr[$value['platform_id']][$k]['inter_name'] = $hh[0];
				$inter_arr[$value['platform_id']][$k]['num'] = empty($hh[1]) ? '0' : $hh[1];
				$inter_arr[$value['platform_id']][$k]['status'] = empty($hh[2]) ? '0': $hh[2];
			}
			// 判断开关
			if($hh[2] == 0 || empty($hh[2])) $j = false;
			if($hh[2] && $j) $i = true;
			else $i = false;

			// $inter_arr[$value['platform_id']][$k]['i'] = $i;
			// $inter_arr[$value['platform_id']][$k]['j'] = $j;
		}
		$inter_arr[$value['platform_id']]['status'] = $i;
	}
}

// dump($inter_arr);

// $arr = ['15703216869','17319438382'];
// if(in_array($wap_user['phone'], $arr)){
	include display("userApi1");
// 	die();
// }
// include display("userApi");