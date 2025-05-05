<?php

require_once __DIR__. "/../models/user.php";
require_once __DIR__ . "/../models/socialAccountsModels.php";
require_once __DIR__."/../services/JwtService.php";


class GooleLoginCallback {
	
	public function LoginCallback(){
	
    $GoogleUser = $_SESSION['GoogleUser'];
		
	if($_SERVER['REQUEST_METHOD']=='GET'){
		
			if(isset($GoogleUser['user']['email'])){
				
				//查看拿了甚麼資料
			   //echo '<pre>';
               //print_r($GoogleUser['user']);
               //echo '</pre>';
			   //exit;
			   $email = $GoogleUser['user']['email'];
			   $userModel = new User;
			   $user = $userModel->findByEmail($email);	

			   $name = $GoogleUser['user']['name'];
			   $provider_id = $GoogleUser['user']['id'];
			   $verified_email = $GoogleUser['user']['verified_email']?1:0;
			   $given_name = $GoogleUser['user']['given_name'];
			   $family_name = $GoogleUser['user']['family_name'];
			   $picture = $GoogleUser['user']['picture'];
			   $created_at = date("Y-m-d H:i:s");
			   $user_id=$user['id']??null;
			   $socialAccountsModels= new socialAccountsModels;
			   
			   if($user){
				 
			  $socialAccountsModels->SaveGoogleInfo($user_id, $email, $provider_id, $verified_email, $name, $given_name, $family_name, $picture, $created_at);
				//以下是開始存cookie要丟middleware
			   $expiresIn = (3600 * 2);
              $token = JwtService::encode([
              'user_id' => $user['id']??null,
              'username' => $user['username']??null,
			   'role' => $user['role']??'user',  // admin or user
			   'email' => $user['email']??null
               ], $expiresIn);

               // 裝置資訊（也可以用 user agent 傳過來）
              $device = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
              $expiresAt = date('Y-m-d H:i:s', time() + $expiresIn);

              // 儲存到 login_tokens 表
             $userModel->saveLoginToken($user['id'], $token, $device, $expiresAt);

              // 寫入 Cookie（或回傳 JSON 給前端）
              setcookie('token', $token,   [
                                                               'expires' => time() + 3600,
                                                               'path' => '/',
                                                               'secure' => true,       // ⚠️ 僅 HTTPS 時使用
                                                               'httponly' => true,     // ✅ 防止 XSS
                                                               'samesite' => 'Strict'  // ✅ 防止 CSRF
                                                             ] );
					$_SESSION['token'] = $token; // ✨ 重點：先存在 session 裡
				   header("Location: index.php?route=middleware");
				   exit;
			   }else{
				   
				
					$socialAccountsModels->SaveGoogleInfo($user_id,$email, $provider_id, $verified_email, $name, $given_name, $family_name, $picture, $created_at);
					$userModel->UserSaveGoogleInfo($email, $name, $created_at);
								
				//以下是開始存cookie要丟middleware
			   $expiresIn =(3600 * 2);
              $token = JwtService::encode([
              'user_id' => $user['id']??null,
              'username' => $user['username']??null,
			   'role' => $user['role']??'user',  // admin or user
			   'email' => $user['email']??null
               ], $expiresIn);

               // 裝置資訊（也可以用 user agent 傳過來）
              $device = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
              $expiresAt = date('Y-m-d H:i:s', time() + $expiresIn);
			

              // 儲存到 login_tokens 表
             $userModel->saveLoginToken($user['id'], $token, $device, $expiresAt);

              // 寫入 Cookie（或回傳 JSON 給前端）
              setcookie('token', $token,   [
                                                               'expires' => time() + 3600,
                                                               'path' => '/',
                                                               'secure' => true,       // ⚠️ 僅 HTTPS 時使用
                                                               'httponly' => true,     // ✅ 防止 XSS
                                                               'samesite' => 'Strict'  // ✅ 防止 CSRF
                                                             ] );  
					$_SESSION['token'] = $token; // ✨ 重點：先存在 session 裡
					header("Location: index.php?route=middleware");
					exit;}
			
	}else{
				    $_SESSION['alert']=[
					
					'status'=>'GoogleLoingError',
					'message'=>"發生錯誤"
				   
				   ];
				   
				   header("Location: index.php?route=login");
	exit;}
   
   }else{
   
				    $_SESSION['alert']=[
					
					'status'=>'GoogleLoingError',
					'message'=>"發生錯誤"
				   
				   ];
				   
				   header("Location: index.php?route=login");
   exit;}
}
}




?>