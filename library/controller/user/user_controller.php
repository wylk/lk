<?php
class user_controller extends controller{
	public function login(){
		/*if(empty($this->store_session)){
			$stores = M('Store')->getStoresByUid($this->user_session['uid']);
			if(empty($stores)) redirect(url('team'));
			else redirect(url('store:select'));
		}*/
		// redirect(url('store:select'));
		$this->display();
	}
	
}