<?php

// controllers/ResetPasswordController.php

require_once __DIR__. '/../models/user.php';
require_once __DIR__. '/../models/PasswordReset.php';

class ResetPasswordController
{
    // 顯示重設密碼表單（如果 token 合法）
    public function showForm()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
           
		   $_SESSION['alert']=[
			
			'status' => 'noFoundToken',
			'message' => '查無此Token'
			];
			
			header('Location: index.php?route=sendemail');
			exit;
        }

        $resetModel = new PasswordReset();
        $record = $resetModel->verifyToken($token);

        if (!$record) {
 		   $_SESSION['alert']=[
			
			'status' => 'TokenNotEffect',
			'message' => '此Token無效或過期'
			];
			
			header('Location: index.php?route=sendemail');
			exit;
        }

        // 顯示重設密碼頁面，帶入 token
        include '../views/reset_password.php';
    }

    // 處理使用者提交的新密碼
    public function handleReset()
    {
        $token = $_POST['token'] ?? null;
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$token || empty($password) || empty($confirm)) {
            
			$_SESSION['alert']=[
			
			'status' => 'noEnterpassword',
			'message' => '請輸入完整表單'
			];
			
			header('Location: index.php?route=resetpassword');
			exit;
        }

        if ($password !== $confirm) {
            
			$_SESSION['alert']=[
			
			'status' => 'PasswordNotSame',
			'message' => '輸入的確認密碼不一致'
			];
			
			header('Location: index.php?route=resetpassword');
			exit;
        }

        $resetModel = new PasswordReset();
        $record = $resetModel->verifyToken($token);

        if (!$record) {
			
		   $_SESSION['alert']=[
			
			'status' => 'TokenNotEffect',
			'message' => '此Token無效或過期'
			];
			
			header('Location: index.php?route=resetpassword');
			exit;
        
        }

        $email = $record['email'];
        $userModel = new User();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userModel->updatePasswordByEmail($email, $hashedPassword);

        // 移除該 token
        $resetModel->deleteToken($token);

		   $_SESSION['alert']=[
			
			'status' => 'SuccessChange',
			'message' => '已成功更新密碼，請重新登入'
			];
			
			header('Location: index.php?route=login');
			exit;
    }
}

?>