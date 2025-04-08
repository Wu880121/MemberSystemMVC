<?php

// controllers/ForgotPasswordController.php

require_once __DIR__. '/../models/user.php';
require_once __DIR__. '/../models/PasswordReset.php';
require_once __DIR__. '/../services/MailerService.php';

class ForgotPasswordController
{
    
	 public function showForm()
    {
        require_once __DIR__. '/../views/pages/sendemail.php'; // ✅ 這裡才是正確載入 view 的地方
    }

    public function handleRequest()
    {
        $email = $_POST['email'] ?? '';

        if (empty($email)) {
            
			$_SESSION['alert']=[
			
			'status' => 'noEnterEmail',
			'message' => '請輸入email'
			];
			
			header('Location: index.php?route=sendemail');
			exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
           
		   $_SESSION['alert']=[
			
			'status' => 'noFoundEmail',
			'message' => '沒有此email'
			];
			
			header('Location: index.php?route=sendemail');
			exit;
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $resetModel = new PasswordReset();
        $resetModel->createToken($email, $token, $expiresAt);

        $mailer = new MailerService();
        $mailer->sendResetLink($email, $token);

		   $_SESSION['alert']=[
            'status' => 'SuccessSendEmail',
			'message' => '已成功寄發郵件'
			];
			
			header('Location: index.php?route=login');
			exit;
    }
}
?>