<?php
class Transfer{
	// $code : array("code"=>$zendVerify)
	public function message($phone,$code){
		import("message");
		$message = new Message();
		return $message->short_message("SMS_107800077",$phone,json_encode($code));
	}
}