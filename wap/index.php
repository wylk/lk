<?php
require_once dirname(__FILE__).'/global.php';

import('Hook');
$a = $_GET['card'];
$hook = new Hook($a);
$hook->add($a);
$html = $hook->exec('add_tpl');

include display('index');
echo ob_get_clean();
