<?php
/*
  系统设置
 */

class config_controller extends base_controller{

public function index()
	{
		// $where['gid'] = '1';
		$where['status'] = '1';
		$config = M('Config')->getConfig($where);

		if(IS_POST){
            $postData = clear_html($_POST);
            $postData['type']="type=". $postData['type'];
            //单选按钮的值
            $a  = explode(',',$postData['remark']);
            //下拉框里的值
            $b = explode(',',$postData['select_name']);

           // 图片type=image&validate=required:true,url:true
            if($postData['type']=="type=image"){
              if($postData['reg']=="required"){
            	$postData['type']=$postData['type']."&validate=required:true,url:true";
              }else{
              	 $postData['type']=$postData['type'];
              }
            }
           // 文本type=text&validate=required:true
            if($postData['type']=="type=text"){
            	if($postData['reg']=="required"){
            	  $postData['type']=$postData['type']."&validate=required:true,url:true";
            	}else{
            	  $postData['type']=$postData['type'];
            	}

            }
             // 文本域type=textarea&rows=4&cols=93
            if($postData['type']=="type=textarea"){
            	$postData['type']=$postData['type']."&rows=4&cols=93";
            }
             // 单选type=radio&value=1:是|0:否
            if($postData['type']=="type=radio"){
            	$postData['type']=$postData['type']."&value=1:".$a[0]."|0:".$a[1];
            }
             // 下拉type=select&value=0:明文模式|1:兼容模式|2:安全模式
            if($postData['type']=="type=select"){
            	$postData['type']=$postData['type']."&value=0:".$b[0]."|1:".$b[1]."|2:".$b[2];
            }
            if(D("Config")->data($postData)->add()){

                dexit(['error'=>0,'msg'=>'添加成功']);
            }else{

                dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        $inputType = array(
            ['type'=>'image','title'=>'图片'],
            ['type'=>'select','title'=>'下拉框'],
            ['type'=>'radio','title'=>'单选'],
            ['type'=>'textarea','title'=>'文本域'],
        );
        // dump($inputType);die;
        $regType = array(
            ['type'=>'required','title'=>'必填'],
        );

        $this->assign('inputType',$inputType);
        $this->assign('regType',$regType);
		$this->assign('config',$config);
		$this->display();
	}
	public function add_set()
    {
        if(IS_POST){
            $postData = clear_html($_POST);
            $set = D("Config");
            foreach($postData as $key=>$value){
                $data['value'] = str_replace('，', ',', trim(stripslashes(htmlspecialchars_decode($value))));
                $set->data($data)->where(array("name"=>$key))->save();
            }
            dexit(['error'=>0,'msg'=>'修改成功']);
        }

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
	 //ajax图片上传
    public function uploadFile()
    {
        if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
            $img_id = sprintf("%09d",1);
            $rand_num = 'images/'.substr($img_id,0,3).'/'.substr($img_id,3,3).'/'.substr($img_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
            $upload_dir = './upload/' . $rand_num;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            import('UploadFile');
            $upload = new UploadFile();
            $upload->maxSize = 1*1024*1024;
            $upload->allowExts = array('jpg','jpeg','png','gif');
            $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
            $upload->savePath = $upload_dir;
            $upload->saveRule = 'uniqid';
            if($upload->upload()){
                $uploadList = $upload->getUploadFileInfo();
                $this->dexit(['error'=>0,'msg'=>getAttachmentUrl($rand_num.$uploadList[0]['savename'])]);
            }else{
                $this->dexit(['error'=>1,'msg'=>$upload->getErrorMsg()]);
            }
        }
    }

    //
    public function delFile()
    {
        if(isset($_POST['url'])){
            $_POST['url'] = '.'.substr($_POST['url'],strrpos($_POST['url'],'/upload'));
            if(isset($_POST['url'])){
                if(file_exists($_POST['url'])){
                    unlink($_POST['url']);
                }
            }
        }

    }
}
