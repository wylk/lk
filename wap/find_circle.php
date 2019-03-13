<?php
require_once dirname(__FILE__).'/global.php';
// dump($wap_user);die();
// $userId = 3;
if(IS_POST && isset($_POST['type'])){
	$type = $_POST['type'];
	switch ($type) {
		case 'check':
			if(empty($wap_user)){
				// redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
				$url = './login.php?referer='.urlencode($_SERVER['REQUEST_URI']);
				dexit(['error'=>1,"msg"=>"未登录",'data'=>['url'=>$url]]);
			}
			dexit(['error'=>0,"msg"=>"已登录"]);
			break;
		case 'release':
			if(empty($wap_user)){
				dexit(['error'=>1,"msg"=>"请先登录"]);
			}
		    $userId = $wap_user['userid'];
			$content = $_POST['content'];
			$img = !empty($_POST['img']) && $_POST['img'] != 'undefined' ? $_POST['img'] : "";
			$data = ['img'=>$_POST['img'],'bu'=>empty($_POST['img'])];
			$data = ["content"=>$content,"uid"=>$userId,"img"=>$img,"createtime"=>time()];
			$res = D("Card_circle")->data($data)->add();
			if($res) dexit(['error'=>0,"msg"=>"成功",'data'=>[$img,$_POST['img'],$_POST]]);
			else dexit(['error'=>1,"msg"=>"失败"]);
			break;
		case 'comment':
			if(empty($wap_user)){
				dexit(['error'=>1,"msg"=>"请先登录"]);
			}
			$userId = $wap_user['userid'];
			if(isset($_POST['id']) && is_numeric($_POST['id'])){
				$id = $_POST['id'];
			}else{
				dexit(['error'=>1,"msg"=>"参数错误"]);
			}
			$content = $_POST['content'];
			$data = ["content"=>$content,"uid"=>$userId,"fid"=>$id,"createtime"=>time()];
			$res = D("Card_circle")->data($data)->add();
			$userinfo = D("User")->field('id,name,avatar')->where(['id'=>$userId])->find();
			if($res) dexit(['error'=>0,"msg"=>"成功","data"=>['userinfo'=>$userinfo]]);
			else dexit(['error'=>1,"msg"=>"失败"]);
			break;
		case 'heart':
			if(isset($_POST['id']) && is_numeric($_POST['id'])){
				$id = $_POST['id'];
			}else{
				dexit(['error'=>1,"msg"=>"参数错误"]);
			}
			if($_POST['option'] == 'add'){
				$res = D("Card_circle")->where(['id'=>$id])->setInc("heart");
				$msg = "支持成功";
			}else{
				$res = D("Card_circle")->where(['id'=>$id])->setDec("heart");
				$msg = "取消支持";
			}
			if($res) dexit(['error'=>0,"msg"=>$msg]);
			else dexit(['error'=>1,"msg"=>"失败"]);
			break;
		case "page":
			$page = $_POST['page'];
			$limit = 5;
			$offset = ($page-1) * $limit;
			$res = D("Card_circle")->where(['fid'=>0])->limit($offset.",".$limit)->order("createtime desc")->select();
			if(!$res){
				dexit(['error'=>1,"msg"=>"获取数据失败","data"=>[]]);
			}

			$uids = array();
			foreach($res as $key=>$value){
				$fid_list[] = $value['id'];
				// 获取用户的uid
				if(!in_array($value['uid'],$uids)){
					$uids[] = $value['uid'];
				}
			}
			// 评论内容
			$comment_list = D("Card_circle")->where(['fid'=>['in',$fid_list]])->select();
			foreach($comment_list as $key=>$value){
				$comment[$value['fid']][] = $value;
				// 获取用户的uid
				if(!in_array($value['uid'],$uids)){
					$uids[] = $value['uid'];
				}
			}
			
			// 用户信息 
			$userinfo = D("User")->field("id,name,avatar")->where(['id'=>['in',$uids]])->select();
			$userinfo = array_column($userinfo, null,"id");

			if($res){
				dexit(['error'=>0,"msg"=>"获取数据成功","data"=>['list'=>$res,'comment_list'=>$comment,"userinfo"=>$userinfo],"test"=>['offset'=>$offset,'limit'=>$limit]]);
			}else{
				dexit(['error'=>1,"msg"=>"获取数据失败","data"=>[]]);
			}
			break;
	}
	
	
}

include display("find_circle");

