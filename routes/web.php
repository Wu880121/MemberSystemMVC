<?php
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController)->index();
        break;

    case 'login':
        require_once '../app/controllers/authController.php';
        (new AuthController)->login();
        break;

    case 'logout':
        require_once '../app/controllers/authController.php';
        (new AuthController)->logout();
        break;

    case 'register':
        require_once '../app/controllers/authController.php';
        (new AuthController)->register();
        break;

    case 'map':
       require_once __DIR__ . '/../app/controllers/StaticPageController.php';
        $controller = new StaticPageController();
        $controller->show_map();
        break;
		
	//case 'forgot-password':
	
	case 'sendemail':
		require_once __DIR__. '/../app/controllers/ForgotPasswordController.php';
		
	   if($_SERVER['REQUEST_METHOD']==='GET'){
		  (new ForgotPasswordController)->showForm();		
	 }else if($_SERVER['REQUEST_METHOD']==='POST'){
		  (new ForgotPasswordController)->handleRequest();
	    }
	      break;
		
    case 'resetpassword':
           require_once __DIR__. '/../app/controllers/ResetPasswordController.php';

             if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                  (new ResetPasswordController)->showForm(); // 顯示重設密碼頁
             } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new ResetPasswordController)->handleReset(); // 處理表單提交
             }
                break;

	
	
    default:
        include '../app/views/404.php';
        break;
}
