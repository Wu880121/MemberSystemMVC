<?php
require_once __DIR__ . "/../models/user.php";

class RegisterVerify {

    public function Verify($token) {
        if (empty($token)) {
            $_SESSION['alert'] = [
                'status' => 'RegisterVerifyFailedVerify',
                'message' => '沒有Token!，請重新寄信'
            ];
            header("Location: index.php?route=resendVerifyToken");
            exit;
        }

        $userModel = new User();
        $success = $userModel->UpdateVerifyStatus($token);

        if ($success) {
            $_SESSION['alert'] = [
                'status' => 'RegisterVerifySuccessVerify',
                'message' => '恭喜驗證完成!'
            ];
            header("Location: index.php?route=login");
            exit;
        }

        // Update 失敗，找找看資料
        $findEmailAndToken = $userModel->findByToken($token);

        if ($findEmailAndToken) {
            $token = urlencode($findEmailAndToken['register_verify_token']);
            $email = urlencode($findEmailAndToken['email']);

            $_SESSION['alert'] = [
                'status' => 'RegisterVerifyNofoundVerifyToken',
                'message' => '無效的Token!，請重新寄信'
            ];
            header("Location: index.php?route=resendVerifyToken&token={$token}&email={$email}");
            exit;
        } else {
            // 找不到 email
            $_SESSION['alert'] = [
                'status' => 'RegisterVerifyNofoundVerifyToken',
                'message' => '無效的Token!，請重新寄信'
            ];
            header("Location: index.php?route=resendVerifyToken");
            exit;
        }
    }
}
?>
