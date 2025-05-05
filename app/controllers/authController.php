<?php
require_once __DIR__ . '/../models/user.php';

require_once __DIR__ . '/RegisterRequest.php';

require_once __DIR__ . '/../services/JwtService.php';

require_once __DIR__ . '/../services/VerifyMailerService.php';


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
			

			//這邊是UpdateLocalNeverRegisterButGoogleRegister的邏輯判斷。
            $userModel = new User();
            $existing = $userModel->findByUsername($username);

			$emailExisting = $userModel->findByEmail($email);
			if($email==$emailExisting['email']&&$emailExisting['register_verify_status']==0){
			
			//這邊是要更新用的，因為有用第三方登入先存資料了，如果要在註冊一樣的東西，要更新，並且導去寄信驗證。
			$token = bin2hex(random_bytes(32));
			$tokenExpiredAt = date("Y-m-d H:i:s", strtotime("+ 30minutes"));
           
		   //這邊改成用更新的
			$success = $userModel->UpdateLocalNeverRegisterButGoogleRegister($name,$username, $password,$email,$tel,$birthdate, $sex, $city, $street, $token, $tokenExpiredAt);
			//user資料庫那邊也要寫一個更新function
            if ($success) {
				
				
				(new MailerService)->sendVerifyToken($email, $token);
				
				
				$urlEmail = urlencode($email);
				
				$_SESSION['alert']=[
                'status' => 'register_success',
				'message' => '註冊成功!'];
				
				
				header("Location: index.php?route=SuccessRegister&email={$urlEmail}");
				exit;
			} else {
				
				$_SESSION['alert']=[
                'status' => 'register_error',
				'message' => '註冊失敗!'];
				header('Location: index.php?route=register');
				exit;
            }
		}
			


		if($emailExisting){
				
				$_SESSION['alert']=[
                'status' => 'email_info',
				'message' => '此郵件重複，請重新新增郵件'];
				header('Location: index.php?route=register');
				exit;
            }
						
	

            if (isset($existing['username'])) {
				
				$_SESSION['alert']=[
                'status' => 'username_info',
				'message' => '此帳號重複，請重新新增帳號'];
				header('Location: index.php?route=register');
				exit;
            }
			
			
			$token = bin2hex(random_bytes(32));
			$tokenExpiredAt = date("Y-m-d H:i:s", strtotime("+ 30minutes"));
            $success = $userModel->register($name,$username, $password,$email,	$tel,$birthdate, $sex, $city, $street, $token, $tokenExpiredAt );

            if ($success) {
				
				
				(new MailerService)->sendVerifyToken($email, $token);
				
				
				$urlEmail = urlencode($email);
				
				$_SESSION['alert']=[
                'status' => 'register_success',
				'message' => '註冊成功!'];
				
				
				header("Location: index.php?route=SuccessRegister&email={$urlEmail}");
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
	
		$userModel = new User();
		
		if($_SERVER['REQUEST_METHOD']=='GET'){
			
		   include_once __DIR__ . '/../views/pages/login.php';
		}
		
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']) ?? '';
            $password = trim($_POST['password']) ?? '';
			
		
		 $user = $userModel->findByUsername($username);
		 	
            if (empty($username) || empty($password)) {
				
				$_SESSION['alert']=[
                'status' => 'login_info',
				'message' => '登入失敗!，請填寫帳號或密碼，不可為空'];
				
				header('Location: index.php?route=login');
				exit;
            }
			
		   
  
			
			if(!$user){
				
				    $_SESSION['alert'] = [
                    'status' => 'login_error',
                     'message' => '查無此帳號'
              ];
                    header('Location: index.php?route=login');
                 exit;
            }
			
			
			$timeFromDB = $user['lock_time'];
			if(!empty($timeFromDB)){
			$CleanTime = preg_replace('#\.\d+$#',' ',$timeFromDB);
			
		    if(strtotime($CleanTime) > strtotime('now')){
					
					$remaining = strtotime($CleanTime)- time();
					$min =  floor($remaining/60);
					$sec = $remaining % 60;
					
					$_SESSION['alert']=[
					
						'status'=>'cantLogin',
						'message' =>"還剩下{$min}分，{$sec}秒後可以登入"
					];
					
					
					header ("Location: index.php?route=login");
					exit;
				}else{
					
					$userModel->resetFailedAttempts($user['id']);
					header ("Location: index.php?route=login");
					exit;
			}
				}
			

			
			if(isset($user['email'])&&$user['register_verify_status']==0){
				
				$_SESSION['alert']=[
                'status' => 'register_verify_token_info',
				'message' => '尚未驗證，請去收信或重寄驗證信'];
				header('Location: index.php?route=login');
				exit;
			}
			
			
			$timeFromDB = $user['tokenExpiredAt'];
			$CleanTime = preg_replace('#\.\d+$#', ' ', is_string($timeFromDB) ? $timeFromDB : '');
             //這邊是把後面的.000毫秒去除掉，為了做比較。
			
			if(isset($user['email'])&& strtotime($CleanTime)<time()){   //這邊的time()我已經在index那邊放亞洲台北時區了。
				
				$urlEmail=urlencode($user['email']);
				//過期了那就顯示已經過期了，請去重寄驗證信
				$_SESSION['alert']=[
					
					'status'=>'ExpiredToken',
					'message'=>'Token已經過期，已經重新寄信，請去信箱查看。'
				];
				//並且導到重新寄信
			header("Location: index.php?route=resendVerifyToken&email={$urlEmail}");
				exit;
			}
			
			if(!strtotime($CleanTime)&&strtotime($CleanTime)>time()){
				//如果沒有大於現在時間就請他去郵件重新點擊驗證連結。
				$_SESSION['alert']=[
						
						'status'=>'HaveToken',
						'message'=>'驗證信已經寄出，請去信箱查看。',
				];
				
				header("Location: index.php?route=login");
				exit;
			}
		 
							


            if (isset($user['password']) && password_verify($password, $user['password'])) {
				
			   $isRemember = !empty($_POST['remember']);
			   
			   $user = $userModel->findByUsername($username);
			    // JWT token 有效時間（秒）
              $expiresIn = $isRemember ? (3600 * 24 * 1) : (3600 * 2);
              $token = JwtService::encode([
              'user_id' => $user['id'],
              'username' => $user['username'],
			   'role' => $user['role'],  // admin or user
               'email' => $user['email']
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
                                                               'samesite' => 'Lax'  // ✅ 防止 CSRF
                                                             ] );  
			  
			  $userModel->resetFailedAttempts($user['id']); //這邊是成功登入的話，刪掉登入錯誤次數的地方。
			  
			  $_SESSION['alert']=[
			   'status' => 'login_success',
               'message' => '登入成功!'];
			                 
                header('Location: /index.php?route=middleware');
				exit;
                
            }else{
				
				$failed =(int) ($user['failed_attempts'] ?? 0) + 1;
				$lockTime = NULL;
			}
                if ($failed >= 5) {
                $lockTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));
				 $userModel->increaseFailedAttempts($user['id']??' ', $failed, $lockTime);
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
	


			
	  public function logout()
    {
        $token = $_COOKIE['token'] ?? null;

        if ($token) {
            // 刪除 login_tokens 表中的該 token（進階做法）
            $UserTokenModel = new User();
            $UserTokenModel->deleteLoginToken($token);

            // 清空 cookie
            setcookie('token', '', time() - 3600, '/', '', true, true);
        }

        // 清除 Session（如果你有用）
        session_destroy();

        // 導回登入頁
        header('Location: /index.php?route=login');
        exit;
      }
	  
}
