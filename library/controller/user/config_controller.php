<?php
/*
  系统设置
 */

class config_controller extends base_controller{
	public function index()
	{
		$where['gid'] = '1';
		$where['status'] = '1';
		$config = M('Config')->getConfig($where);
		$this->assign('config',$config);
		$this->display();
	}

	//修改系统设置
	public function saveConfig()
	{
		if(IS_POST){
			$database_config = D('Config');
			foreach($_POST as $key=>$value){
				$data['name'] = str_replace('，', ',', $key);
				$data['value'] = str_replace('，', ',', trim(stripslashes(htmlspecialchars_decode($value))));
				$database_config->data($data)->where(array("name"=>$key))->save();
				if ($key == 'wechat_sourceid') {
					$data['name'] = 'wechat_token';
					$data['value'] = md5('pigcms_wechat_token' . $data['value']);
					$database_config->data($data)->where(array("name"=>'wechat_token'))->save();
				}
			}
			//import('ORG.Util.Dir');
			//Dir::delDirnotself('./cache');
			$this->dexit(['error'=>0,'msg'=>'修改成功']);
		}else{
			$this->dexit(['error'=>1,'msg'=>'修改失败']);
		}

	}


	//合约管理
	public function application()
	{
		$contracts = M('Contract')->find();
		$this->assign('contracts',$contracts);
		$this->display();
	}

	//添加合约
	public function addApplication()
	{
		if(IS_AJAX){
			$postData =  $this->clear_html($_POST);
			if($postData['id']){
				$id = $postData['id'];
				unset($postData['id']);
				if(D('Contract')->data($postData)->where(['id'=>$id])->save()){
					$this->dexit(['error'=>0,'msg'=>'修改成功']);
				}else{
					$this->dexit(['error'=>1,'msg'=>'修改失败']);
				}
			}else{
				unset($postData['id']);
				if(M('Contract')->add($postData)){
					$this->dexit(['error'=>0,'msg'=>'添加成功']);
				}else{
					$this->dexit(['error'=>1,'msg'=>'添加失败']);
				}
			}
		}
		if($_GET['id']){
			$contract = D('Contract')->where(['id'=>$_GET['id']])->find();
			$contract['btn']  ='修改';
		}else{
			$contract  =array();
			$contract['btn']  ='增加';

		}
		$this->assign('contract',$contract);
		$this->display();
	}

	//合约状态
	public function applicationStatus()
	{
		$postData = $this->clear_html($_POST);
		$status = $postData['status'] == '1'?'0':'1';
		if(D('Contract')->data(['status'=>$status])->where(['id'=>$postData['id']])->save()){
			$this->dexit(['error'=>0,'msg'=>'修改成功']);
		}else{
			$this->dexit(['error'=>1,'msg'=>'修改失败']);
		}
	}
	//删除合约
	public function applicationDel()
	{
		if($_GET['id']){
			$id = $this->clear_html($_GET['id']);
			if(D('Contract')->where(['id'=>$id])->delete()){
				$this->dexit(['error'=>0,'msg'=>'删除成功']);
			}else{
				$this->dexit(['error'=>1,'msg'=>'删除失败']);
			}
		}

	}

	//合约排序
	public function applicationSort()
	{
		if(IS_POST){
			$postData = $this->clear_html($_POST);
			if(D('Contract')->data(['sort'=>$postData['sort']])->where(['id'=>$postData['id']])->save()){
				$this->dexit(['error'=>0,'msg'=>'操作成功']);
			}else{
				$this->dexit(['error'=>1,'msg'=>'操作失败']);
			}
		}
	}

	public function test()
	{
		if(IS_POST){
			$postData = $this->clear_html($_POST);
			import('Hook');
			$hook = new Hook($postData['contract']);
			$hook->add($postData['contract']);
			$hook->exec('add',[$postData]);
		}

	}
}
