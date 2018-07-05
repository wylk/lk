<?php
require_once dirname(__FILE__).'/global.php';


include display('home');
echo ob_get_clean();
