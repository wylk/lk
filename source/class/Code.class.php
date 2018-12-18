<?php
header("Content-type:text/html;charset=utf-8");
class Code{
	protected $number;
	protected $codeType;
	protected $width;
	public function __construct($number=4,$codeType=0,$width=65,$height=40){
		$this->number = $number;
		$this->codeType= $codeType;
		$this->width = $width;
		$this->height = $height;
		$this->code = $this->createCode();
	}
	// public function __get(){}
	// public function getCode(){
	// 	return $this->code;
	// }
	public function __destruct(){}
	public function createCode(){
		switch ($this->codeType) {
			case 0: //纯数字
				$code = $this->getNumberCode();
				break;
			case 1: //纯字母
				$code = $this->getCharCode();
				break;
			case 2: //字符与数字混合
				$code = $this->getNumberCharCode();
				break;
			default:
				die("不支持此类验证码类型");
				break;
		}
		return $code;
	}
	public function getNumberCode(){
		$str = join("",range(0,9));
		$str = str_repeat($str, $this->number);
		$str = str_shuffle($str);
		$str = substr($str,0,$this->number);
		return $str;
	}
	public function getCharCode(){
		$str = join("",range('a','z'));
		$str = str_repeat($str, $this->number);
		$str = str_shuffle($str);
		$str = substr($str,0,$this->number);
		return $str;
	}
	public function getNumberCharCode(){
		$num = join("",range(0,9));
		$char = join("",range('a','z'));
		$str = str_repeat($num, $this->number).str_repeat($char, $this->number);
		$str = str_shuffle($str);
		$str = substr($str, 0,$this->number);
		return $str;
	}
	public function createImage(){
		// 创建画布
		$this->image = imagecreatetruecolor($this->width, $this->height);
		// 填充背景颜色
		imagefill($this->image, 0, 0, $this->lightColor());
		// 将验证码字符添加到画布上
		$width = ceil(($this->width-10)/$this->number);
		for($i=0;$i<$this->number;$i++){
			$x = mt_rand($i*$width+5,($i+1)*$width-8);
			$y = mt_rand(3,$this->height/2);
			imagechar($this->image, 8, $x, $y, $this->code[$i], $this->darkColor());
		}
	}
	// 浅色
	public function lightColor(){
		return imagecolorallocate($this->image, mt_rand(133,255), mt_rand(133,255), mt_rand(133,255));
	}
	// 深色
	public function darkColor(){
		return imagecolorallocate($this->image, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120));
	}
	public function drawDisturb(){
		for($i=0;$i<150;$i++){
			$x = mt_rand(0,$this->width);
			$y = mt_rand(0,$this->height);
			imagesetpixel($this->image, $x, $y, $this->lightColor());
		}
	}
	public function drawLine(){
		for($i=0;$i<5;$i++){
			imageline($this->image,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$this->darkColor());
		}
	}
	public function show(){
		header("Content-type:image/png");
		imagepng($this->image);
	}
	public function outImage(){
		// 创建画布 并填充背景色
		$this->createImage();
		// 将验证码字符串画到画布上
		// $this->drawChar();
		// 添加干扰素
		$this->drawDisturb();
		// 添加线条
		$this->drawLine();
		// 输出并显示
		$this->show();
	}
}