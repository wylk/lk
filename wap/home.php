<?php
require_once dirname(__FILE__).'/global.php';

$storeUid = clear_html($_GET['shoreUid']);
$type = isset($_GET['plugin'])?$_GET['plugin']:'offset';
$card_id = isset($_GET['card_id'])?$_GET['card_id']:'';

include display('home');
echo ob_get_clean();
