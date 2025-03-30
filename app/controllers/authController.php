<?php
require_once __DIR__ . '/../models/user.php';

class AuthController
{


    public function register()
    {


        $status = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
			$email = $_POST['email'] ?? '';
			$phone = $_POST['phone'] ?? '';
			$birthday = $_POST['birthday'] ?? '';

            if (empty($username) || empty($password)) {
                $status = 'error';
            }

            $userModel = new user();
            $existing = $userModel->findByUsername($username);

            if ($existing) {
                $status = 'info';
            }

            $success = $userModel->register($username, $password,$email,$phone,$birthday);

            if ($success) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        include __DIR__ . '/../views/pages/register.php';
    }


    public function login()
    {
        $status = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $status = 'info';
            }

            $userModel = new user();
            $user = $userModel->verifyPassword($username, $password);

            if (!$user) {

                $status = 'error';
            }

            if ($user) {

                $status = 'success';
                $_SESSION['user'] = $user;

                // ✅ 處理記住我
                if (!empty($_POST['remember'])) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/');
                    $userModel->saveLoginToken($user['id'], $token);
                }

                
                header('Location: /index.php?route=home');
                exit;
            }
        }

        include __DIR__ . '/../views/pages/login.php';
    }


    public function logout()
    {


        $status = '';
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
