<?php
require_once dirname(__FILE__).'/global.php';

$action  = $GET['action']?$GET['action']:'upload';

switch ($action) {
	case 'upload':
			if (!isset($_POST['formFile'])) echo json_encode(['code' => -1]);
	        $base64_image_content = $_POST['formFile'];
	        	//$output_directory = '../upload'; //设置图片存放路径
	        $rand_num = 'images/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
			$output_directory = $_SERVER['DOCUMENT_ROOT']."/upload/" . $rand_num;
	        	/* 检查并创建图片存放目录 */
	        if (!file_exists($output_directory)) {
	            mkdir($output_directory, 0777);
	        }
	        	/* 根据base64编码获取图片类型 */
	        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
	            $image_type = $result[2]; //data:image/jpeg;base64,
	            $path =  md5(time()) . '.' . $image_type;
	            $output_file = $output_directory . '/'.$path;
	        }
	        	/* 将base64编码转换为图片编码写入文件 */
	        $image_binary = base64_decode(str_replace($result[1], '', $base64_image_content));
	        if (file_put_contents($output_file, $image_binary)) {
				//echo $output_file; //写入成功输出图片路径
	            echo json_encode(['path' => trim("/upload/".$rand_num.$path, '.'), 'status' => 0]);
	        } else {
	            echo json_encode(['code' => -1]);
	        }
		break;
	
	default:
		# code...
		break;
}