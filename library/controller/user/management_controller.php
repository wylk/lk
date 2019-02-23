<?php
/**
* 应用管理 店铺
*/
class management_controller extends base_controller
{
	
	// function __construct(argument)
	// {
		
	// }
	function inter(){
		if(IS_POST){
			$pid = $_POST['pid'];
			$status = $_POST['status'];
			$res = D("Inter_type")->data(['switch'=>$status])->where(['pid'=>$pid])->select();
			if($status) $status = '打开';
			else $status = '关闭';
			if($res) dexit(['res'=>0,"msg"=>"已成功<span style='color:red'>{$status}</span>接口"]);
			dexit(['res'=>1,"msg"=>"接口修改失败"]);
		}
		
		$field = "*,group_concat(concat_ws('_',id,inter,switch,inter_attr,pid)) as info";
		$list = D("Inter_type")->field($field)->group('pid')->select();

		foreach($list as $key=>$value){
			$attr = explode(",",$value['info']);
			foreach($attr as $k=>$v){
				$attr1 = explode("_",$v);
				$list1[$key]['attr'][$k]['inter'] = $attr1[1];
				$list1[$key]['attr'][$k]['switch'] = $attr1[2];
				$list1[$key]['attr'][$k]['pid'] = $attr1[4];
			}
		}


		$this->assign("inter_list",$list);
		$this->display();
	}
	function shop(){
		$field = "uid,platform_id,group_concat(concat_ws('_',inter_name,num,money,switch_set) order by inter_name) as info";
		$shop_inter = D("Shop_inter")->field($field)->group("platform_id")->limit(12)->select();

		foreach($shop_inter as $key=>$value){
			if(!in_array($value['uid'],$user_arr)) $user_arr[] = $value['uid'];
			$inter_attr = explode(",",$value['info']);
			$i = false;$j = true;
			foreach ($inter_attr as $k => $v) {
				$attr_val = explode("_",$v);
				$inter_info[$key]['inter'][$k]['inter_name'] = $attr_val[0];
				$inter_info[$key]['inter'][$k]['num'] = empty($attr_val[1]) ? "0" : $attr_val[1];
				$inter_info[$key]['inter'][$k]['money'] = empty($attr_val[2]) ? "0.00" : $attr_val[2];
				$inter_info[$key]['inter'][$k]['switch_set'] = empty($attr_val[3]) ? '0' : $attr_val[3];
				if($attr_val[3] == 0) $j = false;
				if($attr_val[3] && $j) $i = true;
				else $i = false;
			}
			$inter_info[$key]['uid'] = $value['uid'];
			$inter_info[$key]['platform_id'] = $value['platform_id'];
			$inter_info[$key]['switch_set'] = $i;
		}
		// dump($inter_info);
		$userinfo = D("User_audit")->field("uid,enterprise")->where(['uid'=>['in',$user_arr]])->select();
		$userinfo = array_column($userinfo, 'enterprise','uid');
		// dump($userinfo);
		$this->assign('inter_info',$inter_info);
		$this->assign('userinfo',$userinfo);
		$this->display();
	}
	function switch_set(){
		if(IS_POST){
			$val = $_POST['val'];
			$status = $_POST['status'];
			$userId = $_POST['uid'];
			if($status == 1)
				$data = ['switch_set'=>$status];
			else
				$data = ['switch_set'=>$status,"status"=>$status];
			$res = D("Shop_inter")->data($data)->where(['uid'=>$userId,"platform_id"=>$val])->save();
			if($status) $status = '打开';
			else $status = "关闭";
			if($res) dexit(['res'=>0,"msg"=>"您已成功<span style='color:red;'>{$status}</span>接口"]);
			dexit(['res'=>1,"msg"=>"接口开关修改失败",'data'=>[$res,$_POST]]);
		}
	}
}