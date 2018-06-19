<?php
/*
  系统设置
 */
class config_controller extends base_controller{
	public function __construct()
	{

	}

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
