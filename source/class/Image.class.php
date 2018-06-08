<?php
class Image
{
	static public function getImageInfo($img)
	{
		$imageInfo = getimagesize($img);

		if ($imageInfo !== false) {
			$imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
			$imageSize = filesize($img);
			$info = array('width' => $imageInfo[0], 'height' => $imageInfo[1], 'type' => $imageType, 'size' => $imageSize, 'mime' => $imageInfo['mime']);
			return $info;
		}


		return false;
	}
	static public function test()
	{
		return 1111;
	}
	static public function water($source, $water, $savename = NULL, $alpha = 80)
	{
		if (!(file_exists($source)) || !(file_exists($water))) {
			return false;
		}


		$sInfo = self::getImageInfo($source);
		$wInfo = self::getImageInfo($water);
		if (($sInfo['width'] < $wInfo['width']) || ($sInfo['height'] < $wInfo['height'])) {
			return false;
		}


		$sCreateFun = 'imagecreatefrom' . $sInfo['type'];
		$sImage = $sCreateFun($source);
		$wCreateFun = 'imagecreatefrom' . $wInfo['type'];
		$wImage = $wCreateFun($water);
		imagealphablending($wImage, true);
		$posY = $sInfo['height'] - $wInfo['height'];
		$posX = $sInfo['width'] - $wInfo['width'];
		imagecopy($sImage, $wImage, $posX, $posY, 0, 0, $wInfo['width'], $wInfo['height']);
		$ImageFun = 'Image' . $sInfo['type'];

		if (!($savename)) {
			$savename = $source;
			@unlink($source);
		}


		if (($sInfo['type'] == 'jpg') || ($sInfo['type'] == 'jpeg')) {
			imagejpeg($sImage, $savename, 100);
		}
		 else {
			$ImageFun($sImage, $savename);
		}

		imagedestroy($sImage);
	}

	public function showImg($imgFile, $text = '', $x = '10', $y = '10', $alpha = '50')
	{
		$info = Image::getImageInfo($imgFile);

		if ($info !== false) {
			$createFun = str_replace('/', 'createfrom', $info['mime']);
			$im = $createFun($imgFile);

			if ($im) {
				$ImageFun = str_replace('/', '', $info['mime']);

				if (!(empty($text))) {
					$tc = imagecolorallocate($im, 0, 0, 0);
					if (is_file($text) && file_exists($text)) {
						$textInfo = Image::getImageInfo($text);
						$createFun2 = str_replace('/', 'createfrom', $textInfo['mime']);
						$waterMark = $createFun2($text);
						$imgW = $info['width'];
						$imgH = ($info['width'] * $textInfo['height']) / $textInfo['width'];
						imagecopymerge($im, $waterMark, $x, $y, 0, 0, $textInfo['width'], $textInfo['height'], $alpha);
					}
					 else {
						imagestring($im, 80, $x, $y, $text, $tc);
					}
				}


				if (($info['type'] == 'png') || ($info['type'] == 'gif')) {
					imagealphablending($im, false);
					imagesavealpha($im, true);
				}


				Header('Content-type: ' . $info['mime']);
				$ImageFun($im);
				@ImageDestroy($im);
				return;
			}


			$ImageFun($sImage, $savename);
			imagedestroy($sImage);
			$im = imagecreatetruecolor(80, 30);
			$bgc = imagecolorallocate($im, 255, 255, 255);
			$tc = imagecolorallocate($im, 0, 0, 0);
			imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
			imagestring($im, 4, 5, 5, 'no pic', $tc);
			Image::output($im);
			return;
		}

	}

	static public function thumb($image, $thumbname, $type = '', $maxWidth = 200, $maxHeight = 50, $interlace = true)
	{
		$info = Image::getImageInfo($image);

		if ($info !== false) {
			$srcWidth = $info['width'];
			$srcHeight = $info['height'];
			$type = ((empty($type) ? $info['type'] : $type));
			$type = strtolower($type);
			$interlace = (($interlace ? 1 : 0));
			unset($info);
			$scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight);

			if (1 <= $scale) {
				$width = $srcWidth;
				$height = $srcHeight;
			}
			 else {
				$width = (int) $srcWidth * $scale;
				$height = (int) $srcHeight * $scale;
			}

			$createFun = 'ImageCreateFrom' . (($type == 'jpg' ? 'jpeg' : $type));
			$srcImg = $createFun($image);

			if ($type == 'png') {
				imagesavealpha($srcImg, true);
			}


			if (($type != 'gif') && function_exists('imagecreatetruecolor')) {
				$thumbImg = imagecreatetruecolor($width, $height);
			}
			 else {
				$thumbImg = imagecreate($width, $height);
			}

			$bg = imagecolorallocate($thumbImg, 255, 255, 255);
			imagefill($thumbImg, 0, 0, $bg);

			if (function_exists('ImageCopyResampled')) {
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
			}
			 else {
				imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
			}

			if (('gif' == $type) || ('png' == $type)) {
				imagealphablending($thumbImg, false);
				imagesavealpha($thumbImg, true);
			}


			if (('jpg' == $type) || ('jpeg' == $type)) {
				imageinterlace($thumbImg, $interlace);
			}


			if ($type == 'jpg') {
				imagejpeg($image, $thumbname, 100);
			}
			 else {
				$imageFun = 'image' . $type;
				$imageFun($thumbImg, $thumbname);
			}

			imagedestroy($thumbImg);
			imagedestroy($srcImg);
			return $thumbname;
		}


		return false;
	}

	static public function thumb2($image, $thumbname, $type = '', $maxWidth = 200, $maxHeight = 50, $interlace = true)
	{
		$info = Image::getImageInfo($image);

		if ($info !== false) {
			$srcWidth = $info['width'];
			$srcHeight = $info['height'];
			$type = ((empty($type) ? $info['type'] : $type));
			$type = strtolower($type);
			$interlace = (($interlace ? 1 : 0));
			unset($info);
			$scale = max($maxWidth / $srcWidth, $maxHeight / $srcHeight);

			if (($maxHeight / $srcHeight) < ($maxWidth / $srcWidth)) {
				$srcX = 0;
				$srcY = ($srcHeight - ($maxHeight / $scale)) / 2;
				$cutWidth = $srcWidth;
				$cutHeight = $maxHeight / $scale;
			}
			 else {
				$srcX = ($srcWidth - ($maxWidth / $scale)) / 2;
				$srcY = 0;
				$cutWidth = $maxWidth / $scale;
				$cutHeight = $srcHeight;
			}

			$createFun = 'ImageCreateFrom' . (($type == 'jpg' ? 'jpeg' : $type));
			$srcImg = $createFun($image);

			if (($type != 'gif') && function_exists('imagecreatetruecolor')) {
				$thumbImg = imagecreatetruecolor($maxWidth, $maxHeight);
			}
			 else {
				$thumbImg = imagecreate($maxWidth, $maxHeight);
			}

			if (function_exists('ImageCopyResampled')) {
				imagecopyresampled($thumbImg, $srcImg, 0, 0, $srcX, $srcY, $maxWidth, $maxHeight, $cutWidth, $cutHeight);
			}
			 else {
				imagecopyresized($thumbImg, $srcImg, 0, 0, $srcX, $srcY, $maxWidth, $maxHeight, $cutWidth, $cutHeight);
			}

			if (('gif' == $type) || ('png' == $type)) {
				$background_color = imagecolorallocate($thumbImg, 0, 255, 0);
				imagecolortransparent($thumbImg, $background_color);
			}


			if (('jpg' == $type) || ('jpeg' == $type)) {
				imageinterlace($thumbImg, $interlace);
			}


			$imageFun = 'image' . (($type == 'jpg' ? 'jpeg' : $type));
			$imageFun($thumbImg, $thumbname);
			imagedestroy($thumbImg);
			imagedestroy($srcImg);
			return $thumbname;
		}


		return false;
	}

	static public function buildString($string, $rgb = array(), $filename = '', $type = 'png', $disturb = 1, $border = true)
	{
		if (is_string($size)) {
			$size = explode(',', $size);
		}


		$width = $size[0];
		$height = $size[1];

		if (is_string($font)) {
			$font = explode(',', $font);
		}


		$fontface = $font[0];
		$fontsize = $font[1];
		$length = strlen($string);
		$width = (($width < (($length * 9) + 10) ? ($length * 9) + 10 : $width));
		$height = 22;

		if (($type != 'gif') && function_exists('imagecreatetruecolor')) {
			$im = @imagecreatetruecolor($width, $height);
		}
		 else {
			$im = @imagecreate($width, $height);
		}

		if (empty($rgb)) {
			$color = imagecolorallocate($im, 102, 104, 104);
		}
		 else {
			$color = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
		}

		$backColor = imagecolorallocate($im, 255, 255, 255);
		$borderColor = imagecolorallocate($im, 100, 100, 100);
		$pointColor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
		@imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
		@imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
		@imagestring($im, 5, 5, 3, $string, $color);

		if (!(empty($disturb))) {
			if (1 || ($disturb = 3)) {
				$i = 0;

				while ($i < 25) {
					imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pointColor);
					++$i;
				}
			}
			 else {
				if (2 || ($disturb = 3)) {
					$i = 0;

					while ($i < 10) {
						imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $pointColor);
						++$i;
					}
				}

			}
		}


		Image::output($im, $type, $filename);
	}

	static public function buildImageVerify($length = 4, $mode = 1, $type = 'png', $width = 48, $height = 22, $verifyName = 'verify')
	{
		import('source.class.String');
		$randval = String::randString($length, $mode);
		$_SESSION[$verifyName] = md5($randval);
		$width = (($width < (($length * 10) + 10) ? ($length * 10) + 10 : $width));

		if (($type != 'gif') && function_exists('imagecreatetruecolor')) {
			$im = imagecreatetruecolor($width, $height);
		}
		 else {
			$im = imagecreate($width, $height);
		}

		$r = array(225, 255, 255, 223);
		$g = array(225, 236, 237, 255);
		$b = array(225, 236, 166, 125);
		$key = mt_rand(0, 3);
		$backColor = imagecolorallocate($im, $r[$key], $g[$key], $b[$key]);
		$borderColor = imagecolorallocate($im, 100, 100, 100);
		imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
		imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
		$stringColor = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
		$i = 0;

		while ($i < 2) {
			imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $stringColor);
			++$i;
		}

		$i = 0;

		while ($i < $length) {
			imagestring($im, 5, ($i * 10) + 5, mt_rand(1, 8), $randval[$i], $stringColor);
			++$i;
		}

		Image::output($im, $type);
	}

	static public function GBVerify($length = 4, $type = 'png', $width = 180, $height = 50, $fontface = 'simhei.ttf', $verifyName = 'verify')
	{
		import('ORG.Util.String');
		$code = String::randString($length, 4);
		$width = (($width < ($length * 45) ? $length * 45 : $width));
		$_SESSION[$verifyName] = md5($code);
		$im = imagecreatetruecolor($width, $height);
		$borderColor = imagecolorallocate($im, 100, 100, 100);
		$bkcolor = imagecolorallocate($im, 250, 250, 250);
		imagefill($im, 0, 0, $bkcolor);
		@imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
		$i = 0;

		while ($i < 15) {
			$fontcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $fontcolor);
			++$i;
		}

		$i = 0;

		while ($i < 255) {
			$fontcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $fontcolor);
			++$i;
		}

		if (!(is_file($fontface))) {
			$fontface = dirname(__FILE__) . '/' . $fontface;
		}


		$i = 0;

		while ($i < $length) {
			$fontcolor = imagecolorallocate($im, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
			$codex = String::msubstr($code, $i, 1);
			imagettftext($im, mt_rand(16, 20), mt_rand(-60, 60), (40 * $i) + 20, mt_rand(30, 35), $fontcolor, $fontface, $codex);
			++$i;
		}

		Image::output($im, $type);
	}

	static public function showASCIIImg($image, $string = '', $type = '')
	{
		$info = Image::getImageInfo($image);

		if ($info !== false) {
			$type = ((empty($type) ? $info['type'] : $type));
			unset($info);
			$createFun = 'ImageCreateFrom' . (($type == 'jpg' ? 'jpeg' : $type));
			$im = $createFun($image);
			$dx = imagesx($im);
			$dy = imagesy($im);
			$i = 0;
			$out = '<span style="padding:0px;margin:0;line-height:100%;font-size:1px;">';
			set_time_limit(0);
			$y = 0;

			while ($y < $dy) {
				$x = 0;

				while ($x < $dx) {
					$col = imagecolorat($im, $x, $y);
					$rgb = imagecolorsforindex($im, $col);
					$str = ((empty($string) ? '*' : $string[$i++]));
					$out .= sprintf('<span style="margin:0px;color:#%02x%02x%02x">' . $str . '</span>', $rgb['red'], $rgb['green'], $rgb['blue']);
					++$x;
				}

				$out .= '<br>' . "\n";
				++$y;
			}

			$out .= '</span>';
			imagedestroy($im);
			return $out;
		}


		return false;
	}

	static public function UPCA($code, $type = 'png', $lw = 2, $hi = 100)
	{
		static $Lencode = array('0001101', '0011001', '0010011', '0111101', '0100011', '0110001', '0101111', '0111011', '0110111', '0001011');
		static $Rencode = array('1110010', '1100110', '1101100', '1000010', '1011100', '1001110', '1010000', '1000100', '1001000', '1110100');
		$ends = '101';
		$center = '01010';

		if (strlen($code) != 11) {
			exit('UPC-A Must be 11 digits.');
		}


		$ncode = '0' . $code;
		$even = 0;
		$odd = 0;
		$x = 0;

		while ($x < 12) {
			if ($x % 2) {
				$odd += $ncode[$x];
			}
			 else {
				$even += $ncode[$x];
			}

			++$x;
		}

		$code .= (10 - ((($odd * 3) + $even) % 10)) % 10;
		$bars = $ends;
		$bars .= $Lencode[$code[0]];
		$x = 1;

		while ($x < 6) {
			$bars .= $Lencode[$code[$x]];
			++$x;
		}

		$bars .= $center;
		$x = 6;

		while ($x < 12) {
			$bars .= $Rencode[$code[$x]];
			++$x;
		}

		$bars .= $ends;

		if (($type != 'gif') && function_exists('imagecreatetruecolor')) {
			$im = imagecreatetruecolor(($lw * 95) + 30, $hi + 30);
		}
		 else {
			$im = imagecreate(($lw * 95) + 30, $hi + 30);
		}

		$fg = ImageColorAllocate($im, 0, 0, 0);
		$bg = ImageColorAllocate($im, 255, 255, 255);
		ImageFilledRectangle($im, 0, 0, ($lw * 95) + 30, $hi + 30, $bg);
		$shift = 10;
		$x = 0;

		while ($x < strlen($bars)) {
			if (($x < 10) || ((45 <= $x) && ($x < 50)) || (85 <= $x)) {
				$sh = 10;
			}
			 else {
				$sh = 0;
			}

			if ($bars[$x] == '1') {
				$color = $fg;
			}
			 else {
				$color = $bg;
			}

			ImageFilledRectangle($im, ($x * $lw) + 15, 5, (($x + 1) * $lw) + 14, $hi + 5 + $sh, $color);
			++$x;
		}

		ImageString($im, 4, 5, $hi - 5, $code[0], $fg);
		$x = 0;

		while ($x < 5) {
			ImageString($im, 5, ($lw * (13 + ($x * 6))) + 15, $hi + 5, $code[$x + 1], $fg);
			ImageString($im, 5, ($lw * (53 + ($x * 6))) + 15, $hi + 5, $code[$x + 6], $fg);
			++$x;
		}

		ImageString($im, 4, ($lw * 95) + 17, $hi - 5, $code[11], $fg);
		Image::output($im, $type);
	}

	static public function output($im, $type = 'png', $filename = '')
	{
		header('Content-type: image/' . $type);
		$ImageFun = 'image' . $type;

		if (empty($filename)) {
			$ImageFun($im);
		}
		 else {
			$ImageFun($im, $filename);
		}

		imagedestroy($im);
	}
}
