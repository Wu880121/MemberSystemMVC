<?php
require_once '../app/models/user.php';
require_once '../app/services/JwtService.php';

class HomeController
{
    public function index()
    {
        $token = $_COOKIE['token'] ?? null;

        if (!$token) {
            header('Location: /index.php?route=login');
            exit;
        }

        try {
            $decoded = JwtService::decode($token);

            $userModel = new User();
            $user = $userModel->findById($decoded->user_id);

            if (!$user) {
                setcookie('token', '', time() - 3600, '/');
                header('Location: /index.php?route=login');
                exit;
            }

            // ✅ 你現在不需要 $_SESSION，直接把 $user 傳給 view 用即可
            include __DIR__ . '/../views/pages/home.php';

        } catch (Exception $e) {
            setcookie('token', '', time() - 3600, '/');
            header('Location: /index.php?route=login');
            exit;
        }
    }
}
