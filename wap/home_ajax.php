<?php
require_once dirname(__FILE__).'/global.php';

if(IS_POST){
	$data = clear_html($_POST);
	import('Hook');
	$hook = new Hook($data['plugin']);
  	$hook->add($data['plugin']);
  	$res = $hook->exec('homeHtml',[$data]);
}