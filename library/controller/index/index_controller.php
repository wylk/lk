<?php
class index_controller extends controller{
	
	public function __construct(){
	}
	public function index() {
		if(is_mobile()){
			redirect(option("config.wap_site_url"));
		}else{
			echo '<h2>welcome to lk<h2>';
		}

	}
}