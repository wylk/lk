<?php
require_once dirname(__FILE__).'/global.php';

if(IS_POST){
	$plugin = [1=>'offset',2=>'contract',3=>'vote',4=>'collection'];
	$data = clear_html($_POST);
	$data['plugin'] = $plugin[$data['plugin']];
	import('Hook');
	$hook = new Hook($data['plugin']);
  	$hook->add($data['plugin']);
  	$res = $hook->exec('indexHtml',[$data]);
}