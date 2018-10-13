<?php
class index_controller extends base_controller{

	public function index()
	{

		// var_dump($_SESSION['admin']);die;
		$id = $_SESSION["admin"]["id"];
		if($_SESSION["admin"]["name"]){
			$auth = D('Auth')->select();
		}else{
			$auth = D('')->table(array('RoleAdmin'=>'p','Access'=>'t','Auth'=>'y'))->field('y.id,y.name,y.pid,y.auth_c,y.auth_a,y.icon,y.is_show')->where("`p`.`admin_id`='$id' AND `p`.`role_id`=`t`.`role_id` AND `t`.`auth_id`=`y`.`id`")->order('`y`.`id` ASC')->select();
		}

		$this->assign('auth',$auth);
		$this->display();
	}

	public function welcome()
	{
		$peopleTotal = $packageTotal = $packageNumToday = $peopleNumToday = $transactionNum = $transactionNumToday = 0;
		$nameArr = D('Contract_field')->select();
		$nameArr = array_column($nameArr, 'val','id');

		$packagelist = D("Card_package")->where(['is_publisher'=>'1'])->select();
		// $peopleTotal = count($packagelist);
		$peopleUidArr = $peopleUidArrToday =[];

		foreach($packagelist as $key=>$value){
			if(!in_array($value['uid'], $peopleUidArr)) $peopleUidArr[] = $value['uid'];
			$cardIdArr[] = $value['card_id'];
			if($value['createtime'] >= strtotime(date('Y-m-d'))){
				$cardIdToday[] = $value['card_id'];
				$peopleNumToday++;
				if(!in_array($value['uid'], $peopleUidArrToday)) $peopleUidArrToday[] = $value['uid'];
			}
		}
		$peopleTotal = count($peopleUidArr);
		$peopleNumToday = count($peopleUidArrToday);

		$attrList = "card_id in ('".implode($cardIdArr, "','")."')";
		$cardRes = D("Card")->where($attrList)->select();
		foreach($cardRes as $key=>$value){
			if($nameArr[$value['c_id']] == 'sum'){
				$packageTotal += $value['val'];
				if(in_array($value['card_id'], $cardIdToday)){
					$packageNumToday += $value['val'];
				}
			}
		}

		// 交易量
		$transactionNum = D("Card_package")->where("type != 'leka'")->sum('sell_count');
		// $time = strtotime(date('Y-m-d');
		$transactionNumToday = D("Card_package")->where("type != 'leka' and createtime >= ".strtotime(date('Y-m-d')))->sum('sell_count');
		$transactionNum = empty($transactionNum) ? 0 : $transactionNum;
		$transactionNumToday = empty($transactionNumToday) ? 0 : $transactionNumToday;

		$this->assign('peopleTotal',$peopleTotal);
		$this->assign('packageTotal',$packageTotal);
		$this->assign('packageNumToday',$packageNumToday);
		$this->assign('peopleNumToday',$peopleNumToday);
		$this->assign('transactionNum',$transactionNum);
		$this->assign('transactionNumToday',$transactionNumToday);
		$this->display();
	}

	public function orderList()
	{
		$this->display();
	}

	//退出登录
	public function logout()
	{
		unset($_SESSION["admin"]);
		header('refresh:1;url=user.php?c=public&a=login');
		die('正在退出....');

	}
}
