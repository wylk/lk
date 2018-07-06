<?php
require_once dirname(__FILE__).'/global.php';


include display('card_orderlist');
echo ob_get_clean();
