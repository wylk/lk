<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';
$array_data = json_decode(json_encode(simplexml_load_string(file_get_contents('php://input'), 'SimpleXMLElement', LIBXML_NOCDATA)), true);
echo $array_data['order_id'];die;