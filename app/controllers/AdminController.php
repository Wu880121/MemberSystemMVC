<?php
class AdminController {
    public function dashboard() {
        $user = $_SERVER['user'];
        $nameOrEmail = $user->email ?? '管理員';
        require_once __DIR__ . '/../views/pages/dashboard.php';
    }
}
