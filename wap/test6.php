<?php
require_once dirname(__FILE__).'/global.php';

import('Hook');
$contract = $_GET['card'];
$hook = new Hook($contract);
$hook->add($contract);
$html = $hook->exec('add_tpl');

include display('test6');
echo ob_get_clean();