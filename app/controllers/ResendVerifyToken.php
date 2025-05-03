<?php

require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../services/VerifyMailerService.php";


class ResendVerifyToken{
	
	
	public function ResendVerify($email){
		
		if($email){
			
			$userModel = new User;
			
			//他有email的話我就重新產生一個token，並解重新寄送郵件及token
			$newToken = bin2hex(random_bytes(32));
			
			$newTokenExpiredAt = date("Y-m-d H:i:s", strtotime("+30 minutes"));
			
			$userModel->UpdateToken($email,$newToken,$newTokenExpiredAt);
			
			(new MailerService)->sendVerifyToken($email, $newToken);
			
			
			$_SESSION['alert']=[
			
				'status'=>'ResendVerifyTokenResendToken',
				'message'=>'信件已經重新寄出囉'
			];
			
			header("Location: index.php?route=login");
			exit;
		}else{
			
			$_SESSION['alert']=[
				
				'status'=>'ResendVerifyTokenFailedResendToken',
				'message'=>'找不到郵件地址，請重新註冊'
			];
			
			header("Location: index.php?route=register");
			exit;
		}
		
	}
	
}


?>