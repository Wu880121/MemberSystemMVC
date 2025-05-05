<?php
require_once __DIR__ . '/JwtService.php';

class AuthMiddleware
{
    public static function handle($requiredRole = null)
    {
        $token = $_COOKIE['token'] ?? $_SESSION['token'] ?? null;

		if (!$token) {
			
			 http_response_code(401);
			  $_SESSION['alert']=[
			   'status' => 'noToken',
               'message' => '查無此Token!'];
			        
                header('Location: /index.php?route=login');
				exit;
        
		}

        try {
            $payload = JwtService::decode($token);
        } catch (Exception $e) {
			
			 http_response_code(401);
			
  			  $_SESSION['alert']=[
			   'status' => 'login_error',
               'message' => '登入失敗'.$e->getMessage()];
			   
                header('Location: /index.php?route=login');
				exit;
        }

        $_SERVER['user'] = $payload;

        if ($requiredRole && (!isset($payload->role) || $payload->role !== $requiredRole)) {
            
			http_response_code(403);
  			  
			  $_SESSION['alert']=[
			   'status' => 'cant_login',
               'message' => '權限不足'];
			   
                header('Location: /index.php?route=login');
				exit;
        }
    }
}
