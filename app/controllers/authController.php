<?php
require_once __DIR__ . '/../models/user.php';

require_once __DIR__ . '/RegisterRequest.php';

require_once __DIR__ . '/../services/JwtService.php';

class AuthController
{


    public function register()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = $_POST['name'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
			$confirm_password = $_POST['confirm_password'] ?? '';
			$email = $_POST['email'] ?? '';
			$tel = $_POST['tel'] ?? '';
			$birthdate= $_POST['birthdate'] ?? '';
			$sex = $_POST['sex'] ?? '';
			$city = $_POST['city'] ?? '';
			$street = $_POST['street'] ?? '';
			
			 $data = $_POST;
			 
			 
        // ✅ 進行格式驗證
        $errors = RegisterRequest::validate($data);

        if (!empty($errors)) {
            $_SESSION['alert'] = [
                'status' => 'register_error',
                'message' => implode(' / ', $errors) // 多筆錯誤合併顯示
            ];
            header('Location: index.php?route=register');
            exit;
        }

            if (empty($username) || empty($password)) {
                
				$_SESSION['alert']=[
				'status' => 'enter_error',
				'message' => '未正確輸入帳號或密碼'];
				header('Location: index.php?route=register');
				exit;
            }
			
			if($password!==$confirm_password){
				
				$_SESSION['alert']=[
				'status' => 'confirm_error',
				'message' => '請重新確認輸入的密碼'];
				header('Location: index.php?route=register');
				exit;
			}
			


            $userModel = new User();
            $existing = $userModel->findByUsername($username);

            if ($existing) {
				
				$_SESSION['alert']=[
                'status' => 'username_info',
				'message' => '此帳號重複，請重新新增帳號'];
				header('Location: index.php?route=register');
				exit;
            }

            $success = $userModel->register($name,$username, $password,$email,	$tel,$birthdate, $sex, $city, $street );

            if ($success) {
				
				$_SESSION['alert']=[
                'status' => 'register_success',
				'message' => '註冊成功!'];
				header('Location: index.php?route=login');
				exit;
            } else {
				
				$_SESSION['alert']=[
                'status' => 'register_error',
				'message' => '註冊失敗!'];
				header('Location: index.php?route=register');
				exit;
            }
		
        }

        include __DIR__ . '/../views/pages/register.php';
    }


    public function login()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
				
				$_SESSION['alert']=[
                'status' => 'login_info',
				'message' => '登入失敗!，請填寫帳號或密碼，不可為空'];
				
				header('Location: index.php?route=login');
				exit;
            }
			
		    $userModel = new User();
            $user = $userModel->findByUsername($username);
			
			if(!$user){
				
				    $_SESSION['alert'] = [
                    'status' => 'login_error',
                     'message' => '查無此帳號'
              ];
                    header('Location: index.php?route=login');
                 exit;
            }
							
		    if(!empty($user['lock_time'])&& strtotime($user['lock_time']) > time()){
					
					$remaining = strtotime($user['lock_time'])- time();
					$min =  floor($remaining/60);
					$sec = $remaining % 60;
					
					$_SESSION['alert']=[
					
						'status'=>'cantLogin',
						'message' =>"還剩下{$min}分，{$sec}秒後可以登入"
					];
					
					
					header ("Location: index.php?route=login");
					exit;
				}

            if (isset($user['password']) && password_verify($password, $user['password'])) {
				
			   $isRemember = !empty($_POST['remember']);
			   
			    // JWT token 有效時間（秒）
              $expiresIn = $isRemember ? (3600 * 24 * 1) : (3600 * 2);
              $token = JwtService::encode([
              'user_id' => $user['id'],
              'username' => $user['username'],
			   'role' => $user['role']  // admin or user
               ], $expiresIn);

               // 裝置資訊（也可以用 user agent 傳過來）
              $device = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
              $expiresAt = date('Y-m-d H:i:s', time() + $expiresIn);

              // 儲存到 login_tokens 表
             $userModel->saveLoginToken($user['id'], $token, $device, $expiresAt);

              // 寫入 Cookie（或回傳 JSON 給前端）
              setcookie('token', $token, time() + $expiresIn, '/', '', false, true); // HttpOnly ✅  
			  
			  $userModel->resetFailedAttempts($user['id']);
			  
			  $_SESSION['alert']=[
			   'status' => 'login_success',
               'message' => '登入成功!'];
			                 
                header('Location: /index.php?route=middleware');
				exit;
                
            }else{
				
				$failed =(int) ($user['failed_attempts'] ?? 0) + 1;
				$lockTime = NULL;
				   
                if ($failed >= 5) {
                $lockTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));
				 $userModel->increaseFailedAttempts($user['id'], $failed, $lockTime);
                $_SESSION['alert'] = [
                 'status' => 'attempts_lock',
                 'message' => '密碼錯誤已達 5 次，帳號鎖定 10 分鐘'
                ];
				
                header('Location: /index.php?route=login');
				exit;
				
              } else {
				    $userModel->increaseFailedAttempts($user['id'], $failed);
                     $_SESSION['alert'] = [
                       'status' => 'attempts',
                       'message' => "密碼錯誤，已錯誤 {$failed} 次，錯誤5次會鎖帳號。"
                 ];
				 

				header('Location: /index.php?route=login');
				exit;
    }
			
        }
    }
	      include __DIR__ . '/../views/pages/login.php';
}

			
	  public function logout()
    {
        $token = $_COOKIE['token'] ?? null;

        if ($token) {
            // 刪除 login_tokens 表中的該 token（進階做法）
            $UserTokenModel = new User();
            $UserTokenModel->deleteLoginToken($token);

            // 清空 cookie
            setcookie('token', '', time() - 3600, '/', '', false, true);
        }

        // 清除 Session（如果你有用）
        session_destroy();

        // 導回登入頁
        header('Location: /index.php?route=login');
        exit;
      }
	  
}
