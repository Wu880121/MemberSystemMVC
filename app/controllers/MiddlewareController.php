<?php
require_once __DIR__. '/../services/AuthMiddleware.php';

class MiddlewareController
{
    public function profile()
    {
		
		exit("🟢 我現在在 MiddlewareController::profile()，這是最新版本。");
        AuthMiddleware::handle(); // 檢查是否有登入
        $user = $_SERVER['user'];

        // 根據角色導向不同頁面
        if ($user->role === 'admin') {
            $_SESSION['alert'] = [
                'status' => 'role_login_success',
                'message' => '歡迎管理員登入成功！'
            ];
            header('Location: /index.php?route=dashboard');
        } else {
            
			$_SESSION['alert'] = [
                'status' => 'login_success',
                'message' => '登入成功！'
            ];
            header('Location: /index.php?route=home');
        }

        exit;
    }
}
?>
