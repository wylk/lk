<?php
/*$base64_string = $_POST['base64_string'];
 
 $savename = uniqid().'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
 
 $savepath = 'images/'.$savename; 
 
 $image = base64_to_img( $base64_string, $savepath );
 
 if($image){
      echo '{"status":1,"content":"上传成功","url":"'.$image.'"}';
 }else{
      echo '{"status":0,"content":"上传失败"}';
 } 
 
 function base64_to_img( $base64_string, $output_file ) {
     $ifp = fopen( $output_file, "wb" ); 
     fwrite( $ifp, base64_decode( $base64_string) ); 
     fclose( $ifp ); 
     return( $output_file ); 
 }
 
 
 $base64_image_content = $_POST['base64img'];
$output_directory = './image'; //设置图片存放路径


/* 检查并创建图片存放目录 */
/*if (!file_exists($output_directory)) {
    mkdir($output_directory, 0777);
}*/


/* 根据base64编码获取图片类型 */
/*if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
    $image_type = $result[2]; //data:image/jpeg;base64,
    $output_file = $output_directory . '/' . md5(time()) . '.' . $image_type;
}*/


/* 将base64编码转换为图片编码写入文件 */
/*$image_binary = base64_decode(str_replace($result[1], '', $base64_image_content));
if (file_put_contents($output_file, $image_binary)) {
    echo $output_file; //写入成功输出图片路径
}*/
       
        if (!isset($_POST['formFile'])) return false;
        $base64_image_content = $_POST['formFile'];
        $output_directory = './upload'; //设置图片存放路径

        /* 检查并创建图片存放目录 */
        if (!file_exists($output_directory)) {
            mkdir($output_directory, 0777);
        }
        /* 根据base64编码获取图片类型 */
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $image_type = $result[2]; //data:image/jpeg;base64,
            $output_file = $output_directory . '/' . md5(time()) . '.' . $image_type;
        }
        /* 将base64编码转换为图片编码写入文件 */
        $image_binary = base64_decode(str_replace($result[1], '', $base64_image_content));
        if (file_put_contents($output_file, $image_binary)) {
//            echo $output_file; //写入成功输出图片路径
            echo json_encode(['path' => trim($output_file, '.'), 'status' => 0]);
        } else {
            echo json_encode(['code' => -1]);
        }

        