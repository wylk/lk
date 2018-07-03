<?php
require_once dirname(__FILE__)."/global.php";
$a = isset($_GET['a']) ? $_GET['a'] : "";
if($a == "bill"){
	include display("bill");	
}elseif($a == 'purse'){
	include display("purse");
}else{
	exit("非法访问");
}
