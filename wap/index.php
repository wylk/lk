<?php
require_once dirname(__FILE__).'/global.php';
/*import_plugin('offset');
$a = new offsetCard();
$a->add();*/
include display('index');
echo ob_get_clean();
