<?php

require_once __DIR__."/../models/user.php";
require_once __DIR__. "/../services/VerifyMailerService.php";
require_once __DIR__. "/../services/JwtService.php";

class UserProfileController{

public function UserProfile(){

	$userModel = new User;

try {
    $token = $_COOKIE['token'] ?? null;
    $payload = JwtService::decode($token);
    $email = $payload->email ?? null;
} catch (\RuntimeException $e) {
    // ✅ 自己處理錯誤，不讓它變 Fatal error
    $_SESSION['alert'] = [
		
		'status'=> 'Notoken',
        'message' => "請先登入"
    ];
    header("Location: index.php?route=login");
    exit;
}

	if(!$email){
		
		$_SESSION['alert']=[
			
			'status'=>'DoNotHaveEmail',
			'message'=>'發生錯誤，查無此email。'
			];
		
		header("Location: index.php?route=login");
		exit;
	}
	
	$user = $userModel->findByEmail($email);
	
		if(!$user){
		
		$_SESSION['alert']=[
			
			'status'=>'DoNotHaveEmail',
			'message'=>'發生錯誤，請重新嘗試登入'
			];
		
		header("Location: index.php?route=login");
		exit;
	}
	
	
	if($_SERVER['REQUEST_METHOD']=='GET'){
		
		require_once __DIR__. "/../views/pages/UserProfilePage.php";
		return;
	}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		if(isset($email)&&$user['register_verify_status']==0){
			
			$name= $_POST['name'];
			$email= $_POST['email'];
			$tel= $_POST['tel'];
			$birthdate= $_POST['birthdate'];
			$sex= $_POST['sex'];
			$city= $_POST['city'];
			$street= $_POST['street'];
			$id= $user['id'];
			$token = bin2hex(random_bytes(16));
			$userModel->UpdateUserProfile($name,$email,$tel,$birthdate,$sex,$city,$street,$id,$token);
			
			 (new MailerService)->sendVerifyToken($email, $token);
			 
			$_SESSION['alert']=[
			
			'status'=>'UpdateUserProfileSuccess',
			'message'=>'恭喜更改成功，請去信箱點擊驗證'
			];
		
		header("Location: index.php?route=UserProfile");
		exit;
	}
	
		if(isset($email)&&$user['register_verify_status']==1){
			
			$name= $_POST['name'];
			$email= $_POST['email'];
			$tel= $_POST['tel'];
			$birthdate= $_POST['birthdate'];
			$sex= $_POST['sex'];
			$city= $_POST['city'];
			$street= $_POST['street'];
			$id= $user['id'];
			$userModel->UpdateUserProfile($name,$email,$tel,$birthdate,$sex,$city,$street,$id);
			
		 }
		 
		 		if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_FILES['avatar'])){
			
			$file = $_FILES['avatar'];
			   
			   //Array
                       //(
                         // [name] => myphoto.jpg            // 原始檔名
                         // [type] => image/jpeg             // MIME 類型
                         // [tmp_name] => /tmp/php123.tmp    // 暫存檔路徑
                         // [error] => 0                     // 上傳錯誤代碼（0 表示成功）
                         // [size] => 14352                  // 檔案大小（位元組）
                        // )
						
			if($file['error']){
				
				$allowed = ['image/jpeg', 'image/png', 'image/gif'];
				if (!in_array($file['type'], $allowed)){
					$_SESSION['warrning']=[
						'message'=>"格式錯誤，只允許 JPG/PNG/GIF 格式。"
					];
				}
			}
			
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION); //取附檔名
			$uploadDir = __DIR__."/../../public/uploads/avatars/";
			if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
			
			$filename = uniqid('avatar_', true).'.'.$ext;    //這邊的uniqid是指唯一，然後true等於產生隨機亂數
			$destination = $uploadDir . $filename;
			$relativePath = 'uploads/avatars/' . $filename;  //用來存進資料庫，因為頁面要顯示
				
			if(move_uploaded_file($file['tmp_name'],$destination )){
				
				$userModel->UpdateUserProfileImagePath($relativePath, $email);
				
			$_SESSION['alert']=[
			
			'status'=>'UpdateUserProfileSuccess',
			'message'=>'恭喜更改成功'
			];
		
		header("Location: index.php?route=UserProfile");
		exit;
		  }
		}		
		 
	}		
		
			$_SESSION['alert']=[
			
			'status'=>'UploadFailed',
			'message'=>'查不到此頁面'
			];
		
		header("Location: index.php?route=login");
		exit;
		
	  }
   }



?>