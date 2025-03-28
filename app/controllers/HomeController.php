<?php
require_once '../app/models/user.php';
require_once '../app/models/login_tokens.php';

class HomeController
{
    public function index()
    {


        if (!isset($_SESSION['user'])) {
            $token = $_COOKIE['remember_token'] ?? null;

            if ($token) {
                $tokenModel = new login_tokens();
                $user = $tokenModel->findByRememberToken($token);

                if ($user) {
                    $_SESSION['user'] = $user;
                } else {
                    setcookie('remember_token', '', time() - 3600, '/');
                    header('Location: index.php?route=login');
                    exit;
                }
            } else {
                header('Location: index.php?route=login');
                exit;
            }
        }
    }
}
