<?php
/**
 * 基础类
 *
 */
class base_controller extends controller{
	public $user_session;
	public $store_session;
    public $allow_store_drp; //是否允许排他分销
    public $allow_platform_drp; //是否允许全网批发
    private $enabled_drp; //是否开启分销
	public function __construct()
    {
		parent::__construct();
       


        // var_dump($_SESSION);
        // die;
	}
}
?>