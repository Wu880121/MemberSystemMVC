<?php
require_once __DIR__ . '/../models/user.php';

class AuthController
{
    public function register()
    {


        $message = '';
        $color = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                echo "<p style='color:red;'>請填寫帳號與密碼</p>";
                return;
            }

            $userModel = new user();
            $existing = $userModel->findByUsername($username);

            if ($existing) {
                echo "<p style='color:red;'>帳號已存在，請使用其他名稱</p>";
                return;
            }

            $success = $userModel->register($username, $password);

            if ($success) {
                echo "<p style='color:green;'>註冊成功！<a href='index.php?route=login'>前往登入</a></p>";
            } else {
                echo "<p style='color:red;'>註冊失敗，請稍後再試</p>";
            }
        }
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                echo "<p style='color:red;'>請輸入帳號與密碼</p>";
                return;
            }

            $userModel = new user();
            $user = $userModel->verifyPassword($username, $password);

            if (!$user) {

                echo "<p style='color:red;'>帳號或密碼錯誤，請重新輸入</p>";
                return;
            }

            if ($user) {

                $_SESSION['user'] = $user;

                // ✅ 處理記住我
                if (!empty($_POST['remember'])) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/');
                    $userModel->saveLoginToken($user['id'], $token);
                }


                header('Location: index.php');
                exit;
            }
        }
    }


    public function logout()
    {


        // 清除 session
        session_unset();
        session_destroy();

        // 🔥 清除 cookie（記住我）
        setcookie('remember_token', '', time() - 3600, '/');

        // 🔥 也可以刪除 login_tokens 裡的 token（進階）

        header('Location: index.php?route=login');
        exit;
    }
}
