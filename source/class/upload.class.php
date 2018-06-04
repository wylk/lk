<?php
class Upload
{
	private $config = array(
		'maxSize'           => -1,
		'supportMulti'      => true,
		'allowExts'         => array(),
		'allowTypes'        => array(),
		'thumb'             => false,
		'imageClassPath'    => 'ORG.Util.Image',
		'thumbMaxWidth'     => '',
		'thumbMaxHeight'    => '',
		'thumbPrefix'       => 'thumb_',
		'thumbSuffix'       => '',
		'thumbPath'         => '',
		'thumbFile'         => '',
		'thumbExt'          => '',
		'thumbRemoveOrigin' => false,
		'zipImages'         => false,
		'autoSub'           => false,
		'subType'           => 'hash',
		'subDir'            => '',
		'dateFormat'        => 'Ymd',
		'hashLevel'         => 1,
		'savePath'          => '',
		'autoCheck'         => true,
		'uploadReplace'     => false,
		'saveRule'          => 'uniqid',
		'hashType'          => 'md5_file'
		);
	private $error = '';
	private $uploadFileInfo;

	public function __get($name)
	{
		if (isset($this->config[$name])) {
			return $this->config[$name];
		}

	}

	public function __set($name, $value)
	{
		if (isset($this->config[$name])) {
			$this->config[$name] = $value;
		}

	}

	public function __isset($name)
	{
		return isset($this->config[$name]);
	}

	public function __construct($config = array())
	{
		if (is_array($config)) {
			$this->config = array_merge($this->config, $config);
		}

	}

	private function save($file)
	{
		$filename = $file['savepath'] . $file['savename'];

		if (!($this->uploadReplace) && is_file($filename)) {
			$this->error = '文件已经存在！' . $filename;
			return false;
		}


		if (in_array(strtolower($file['extension']), array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf'))) {
			$info = getimagesize($file['tmp_name']);

			if (!($info) && isset($file['size']) && (0 < $file['size'])) {
				$info = $file['size'];
			}


			if ((false === $info) || (('gif' == strtolower($file['extension'])) && empty($info['bits']))) {
				$this->error = '非法图像文件';
				return false;
			}

		}


		if (!(move_uploaded_file($file['tmp_name'], $this->autoCharset($filename, 'utf-8', 'gbk')))) {
			$this->error = '文件上传保存错误！';
			return false;
		}


		if ($this->thumb && in_array(strtolower($file['extension']), array('gif', 'jpg', 'jpeg', 'bmp', 'png'))) {
			$image = getimagesize($filename);

			if (false !== $image) {
				$thumbWidth = explode(',', $this->thumbMaxWidth);
				$thumbHeight = explode(',', $this->thumbMaxHeight);
				$thumbPrefix = explode(',', $this->thumbPrefix);
				$thumbSuffix = explode(',', $this->thumbSuffix);
				$thumbFile = explode(',', $this->thumbFile);
				$thumbPath = (($this->thumbPath ? $this->thumbPath : dirname($filename) . '/'));
				$thumbExt = (($this->thumbExt ? $this->thumbExt : $file['extension']));
				import($this->imageClassPath);
				$i = 0;
				$len = count($thumbWidth);

				while ($i < $len) {
					if (!(empty($thumbFile[$i]))) {
						$thumbname = $thumbFile[$i];
					}
					 else {
						$prefix = ((isset($thumbPrefix[$i]) ? $thumbPrefix[$i] : $thumbPrefix[0]));
						$suffix = ((isset($thumbSuffix[$i]) ? $thumbSuffix[$i] : $thumbSuffix[0]));
						$thumbname = $prefix . basename($filename, '.' . $file['extension']) . $suffix;
					}

					Image::thumb($filename, $thumbPath . $thumbname . '.' . $thumbExt, '', $thumbWidth[$i], $thumbHeight[$i], true);
					++$i;
				}

				if ($this->thumbRemoveOrigin) {
					unlink($filename);
				}

			}

		}


		if ($this->zipImags) {
		}


		return true;
	}

	public function upload($savePath = '')
	{
		if (empty($savePath)) {
			$savePath = $this->savePath;
		}


		if (!(is_dir($savePath))) {
			if (is_dir(base64_decode($savePath))) {
				$savePath = base64_decode($savePath);
			}
			 else if (!(mkdir($savePath))) {
				$this->error = '上传目录' . $savePath . '不存在';
				return false;

				if (!(is_writeable($savePath))) {
					$this->error = '上传目录' . $savePath . '不可写';
					return false;
				}

			}

		}
		 else {
			$this->error = '上传目录' . $savePath . '不可写';
			return false;
		}

		$fileInfo = array();
		$isUpload = false;
		$files = $this->dealFiles($_FILES);

		foreach ($files as $key => $file ) {
			if (!(empty($file['name']))) {
				if (!(isset($file['key']))) {
					$file['key'] = $key;
				}


				$file['extension'] = $this->getExt($file['name']);
				$file['savepath'] = $savePath;
				$file['savename'] = $this->getSaveName($file);

				if ($this->autoCheck) {
					if (!($this->check($file))) {
						return false;
					}

				}


				if (!($this->save($file))) {
					return false;
				}


				if (function_exists($this->hashType)) {
					$fun = $this->hashType;
					$file['hash'] = $fun($this->autoCharset($file['savepath'] . $file['savename'], 'utf-8', 'gbk'));
				}


				unset($file['tmp_name'], $file['error']);
				$fileInfo[] = $file;
				$isUpload = true;
			}

		}

		if ($isUpload) {
			$this->uploadFileInfo = $fileInfo;
			return true;
		}


		$this->error = '没有选择上传文件';
		return false;
	}

	public function uploadOne($file, $savePath = '')
	{
		if (empty($savePath)) {
			$savePath = $this->savePath;
		}


		if (!(is_dir($savePath))) {
			if (!(mkdir($savePath, 511, true))) {
				$this->error = '上传目录' . $savePath . '不存在';
				return false;

				if (!(is_writeable($savePath))) {
					$this->error = '上传目录' . $savePath . '不可写';
					return false;
				}

			}

		}
		 else {
			$this->error = '上传目录' . $savePath . '不可写';
			return false;
		}

		if (!(empty($file['name']))) {
			$fileArray = array();

			if (is_array($file['name'])) {
				$keys = array_keys($file);
				$count = count($file['name']);
				$i = 0;

				while ($i < $count) {
					foreach ($keys as $key ) {
						$fileArray[$i][$key] = $file[$key][$i];
					}

					++$i;
				}
			}
			 else {
				$fileArray[] = $file;
			}

			$info = array();

			foreach ($fileArray as $key => $file ) {
				$file['extension'] = $this->getExt($file['name']);
				$file['savepath'] = $savePath;
				$file['savename'] = $this->getSaveName($file);

				if ($this->autoCheck) {
					if (!($this->check($file))) {
						return false;
					}

				}


				if (!($this->save($file))) {
					return false;
				}


				if (function_exists($this->hashType)) {
					$fun = $this->hashType;
					$file['hash'] = $fun($this->autoCharset($file['savepath'] . $file['savename'], 'utf-8', 'gbk'));
				}


				unset($file['tmp_name'], $file['error']);
				$info[] = $file;
			}

			return $info;
		}


		$this->error = '没有选择上传文件';
		return false;
	}

	private function dealFiles($files)
	{
		$fileArray = array();
		$n = 0;

		foreach ($files as $key => $file ) {
			if (is_array($file['name'])) {
				$keys = array_keys($file);
				$count = count($file['name']);
				$i = 0;

				while ($i < $count) {
					$fileArray[$n]['key'] = $key;

					foreach ($keys as $_key ) {
						$fileArray[$n][$_key] = $file[$_key][$i];
					}

					++$n;
					++$i;
				}
			}
			 else {
				$fileArray[$key] = $file;
			}
		}

		return $fileArray;
	}

	protected function error($errorNo)
	{
		switch ($errorNo) {
		case 1:
			$this->error = '上传的文件超过了' . ini_get('upload_max_filesize');
			break;

		case 2:
			$this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
			break;

		case 3:
			$this->error = '文件只有部分被上传';
			break;

		case 4:
			$this->error = '没有文件被上传';
			break;

		case 6:
			$this->error = '找不到临时文件夹';
			break;

		case 7:
			$this->error = '文件写入失败';
			break;

		default:
			$this->error = '未知上传错误！';
		}
	}

	private function getSaveName($filename)
	{
		$rule = $this->saveRule;

		if (empty($rule)) {
			$saveName = $filename['name'];
		}
		 else if (function_exists($rule)) {
			$saveName = $rule() . '.' . $filename['extension'];
		}
		 else {
			$saveName = $rule . '.' . $filename['extension'];
		}

		if ($this->autoSub) {
			$filename['savename'] = $saveName;
			$saveName = $this->getSubName($filename) . $saveName;
		}


		return $saveName;
	}

	private function getSubName($file)
	{
		switch ($this->subType) {
		case 'custom':
			$dir = $this->subDir;
			break;

		case 'date':
			$dir = date($this->dateFormat, time()) . '/';
			break;

		case 'hash':

		default:
			$name = md5($file['savename']);
			$dir = '';
			$i = 0;

			while ($i < $this->hashLevel) {
				$dir .= $name[$i] . '/';
				++$i;
			}

			break;
		}

		if (!(is_dir($file['savepath'] . $dir))) {
			mkdir($file['savepath'] . $dir, 511, true);
		}


		return $dir;
	}

	private function check($file)
	{
		if ($file['error'] !== 0) {
			$this->error($file['error']);
			return false;
		}


		if (!($this->checkSize($file['size']))) {
			$this->error = '上传文件大小不符！';
			return false;
		}


		if (!($this->checkType($file['type']))) {
			$this->error = '上传文件MIME类型不允许！';
			return false;
		}


		if (!($this->checkExt($file['extension']))) {
			$this->error = '上传文件类型不允许';
			return false;
		}


		if (!($this->checkUpload($file['tmp_name']))) {
			$this->error = '非法上传文件！';
			return false;
		}


		return true;
	}

	private function autoCharset($fContents, $from = 'gbk', $to = 'utf-8')
	{
		$from = ((strtoupper($from) == 'UTF8' ? 'utf-8' : $from));
		$to = ((strtoupper($to) == 'UTF8' ? 'utf-8' : $to));
		if ((strtoupper($from) === strtoupper($to)) || empty($fContents) || (is_scalar($fContents) && !(is_string($fContents)))) {
			return $fContents;
		}


		if (function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($fContents, $to, $from);
		}


		if (function_exists('iconv')) {
			return iconv($from, $to, $fContents);
		}


		return $fContents;
	}

	private function checkType($type)
	{
		if (!(empty($this->allowTypes))) {
			return in_array(strtolower($type), $this->allowTypes);
		}


		return true;
	}

	private function checkExt($ext)
	{
		if (!(empty($this->allowExts))) {
			return in_array(strtolower($ext), $this->allowExts, true);
		}


		return true;
	}

	private function checkSize($size)
	{
		return !($this->maxSize < $size) || (-1 == $this->maxSize);
	}

	private function checkUpload($filename)
	{
		return is_uploaded_file($filename);
	}

	private function getExt($filename)
	{
		$pathinfo = pathinfo($filename);
		return $pathinfo['extension'];
	}

	public function getUploadFileInfo()
	{
		return $this->uploadFileInfo;
	}

	public function getErrorMsg()
	{
		return $this->error;
	}
}


?>