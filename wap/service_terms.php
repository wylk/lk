<?php
require_once dirname(__FILE__).'/global.php';


//dump($config['reg_readme_content']);
include display('service_terms');
echo ob_get_clean();
