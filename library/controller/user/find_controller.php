<?php
class find_controller extends base_controller{

	public function index()
	{
		if(IS_POST){
			$type = $_POST['type'];
			switch ($type) {
				case 'addFunc':
					$title = $_POST['title'];
					$desc = $_POST['desc'];
					$data = ['name'=>$title,"state"=>$desc,"switch"=>0,"createtime"=>time()];
					$res = D("Find")->data($data)->add();
					if($res){
						dexit(['error'=>0,"msg"=>"添加成功"]);
					}
					dexit(['error'=>1,'msg'=>"添加失败",'data'=>[$res,$data]]);
					break;
				case 'switch':
					$id = $_POST['id'];
					if($_POST['switch'] == 'true'){
						$switch = 1;
					}else{
						$switch = 0;
					}
					$res = D("Find")->data(['switch'=>$switch])->where(['id'=>$id])->save();
					if($res){
						dexit(['error'=>0,"msg"=>"修改成功"]);
					}
					dexit(['error'=>1,"msg"=>"修改失败","data"=>[$res,$switch,$_POST['switch']]]);
					break;
			}
			
		}
		$page = 1;
		$limit = 10;
		$offset = ($page-1)*10;
		$funcList = D("Find")->limit($offset.",".$limit)->order("createtime desc")->select();
		$this->assign("funcList",$funcList);
		$this->display();
	}
	public function func_name(){
		$id = $_GET['id'];
		$info = D("Find")->where(['id'=>$id])->find();

		$this->assign("info",$info);
		$this->$info['table_name']();
		// $this->display($info['table_name']);
	}
	public function content(){
		$id = $_GET['id'];
		$info = D("Card_circle")->where("id=".$id." or fid=".$id)->order("fid asc,createtime desc")->select();
		$this->assign("info",$info);
		$this->display();
	}
	public function card_circle(){
		if(IS_POST){
			$limit = empty($_POST['limit']) ? 10 : $_POST['limit'];
			$page = empty($_POST['page']) ? 1 : $_POST['page'];
			$offset = ($page-1)*$limit;

			$where = 'is_delete in (0,1) ';
			if(!empty($_POST['content'])){
				$where = " and content like '%".$_POST['content']."%' ";
			}
			if(isset($_POST['type']) && $_POST['type'] != ' '){
				$where .= empty($where) ? " " : " and ";
				$where .= empty($_POST['type']) ? " fid = 0" : " fid != 0 ";
			}
			$findNum = D("Card_circle")->where($where)->count("id");
			$list = D("Card_circle")->where($where)->limit($offset.",".$limit)->order("createtime desc")->select();

			// 用户信息
			$uid = array_column($list, "uid");
			$userinfo = D("User")->field("id,name,avatar")->where(['id'=>["in",$uid]])->select();
			$userinfo = array_column($userinfo, null,"id");

			if($list){
				dexit(['error'=>0,"msg"=>"数据获取成功","data"=>['list'=>$list,"userinfo"=>$userinfo,"findNum"=>$findNum,"post"=>$_POST]]);
			}
			dexit(['error'=>1,"msg"=>"数据获取失败","data"=>['list'=>$list,"userinfo"=>$userinfo,"post"=>$_POST,"where"=>$where,"findNum"=>$findNum,"offset"=>$offset,"limit"=>$limit]]);
		}
		$findNum = D("Card_circle")->count("id");
		$this->assign("findNum",$findNum);
		$this->display('card_circle');
	}
	public function circleSet(){
		$id = $_POST['id'];
		$is_delete = $_POST['is_delete'] == "true" ? 0 : 1;
		$res = D("Card_circle")->data(['is_delete'=>$is_delete])->where(['id'=>$id])->save();
		if($res){
			dexit(['error'=>0,"msg"=>"修改成功"]);
		}
		dexit(['error'=>1,"msg"=>"修改失败","data"=>['res'=>$res,"post"=>$_POST]]);
	}
	// public function findInfo(){
	// 	if(IS_POST){
	// 		$where = '';
	// 		if(!empty($_POST['content'])){
	// 			$where = " content like '%".$_POST['content']."%' ";
	// 		}
	// 		if(isset($_POST['type']) && $_POST['type'] != ' '){
	// 			$where .= empty($where) ? " " : " and ";
	// 			$where .= empty($_POST['type']) ? " fid = 0" : " fid != 0 ";
	// 		}
	// 		$findNum = D("Card_circle")->where($where)->count("id");
	// 		$res = D("Card_circle")->where($where)->limit(10)->order("createtime desc")->select();
	// 		$uids = array_column($res, 'uid');
	// 		$userinfo = D("User")->where(['id'=>['in',$uids]])->select();
	// 		$userinfo = array_column($userinfo, null , "id");
	// 		if($res){
	// 			dexit(['error'=>0,"msg"=>"数据获取成功","data"=>['list'=>$res,"userinfo"=>$userinfo,"findNum"=>$findNum,"post"=>$_POST,$where,$a]]);
	// 		}
	// 		dexit(['error'=>1,"msg"=>"数据获取失败","data"=>['list'=>$res,"userinfo"=>$userinfo,$where]]);
	// 	}
	// }

}
