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
	
    case 'manage':
       require_once __DIR__ . '/../app/controllers/ManageController.php';
        $controller = new  Manage();
        $controller->manage();
        break;
		
		case 'manageSearch':
		require_once __DIR__. '/../app/controllers/ManageController.php';
		$controller = new Manage();
		$controller->ManageSearch();
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

    case 'dashboard':
        require_once __DIR__ . '/../app/services/AuthMiddleware.php';
        AuthMiddleware::handle('admin'); // ✅ 限 admin 登入才能看
        require_once __DIR__.'/../app/controllers/AdminController.php';
        (new AdminController)->dashboard();
        break;
		
    case 'middleware':
        require_once __DIR__. '/../app/controllers/MiddlewareController.php';
        (new MiddlewareController)->profile();
         break;
	
	case 'edit':
		require_once __DIR__. '/../app/controllers/ManageController.php';
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			
			(new Manage )->edit();
		
		}elseif($_SERVER['REQUEST_METHOD']==='POST'){
			
			(new Manage)->edit();
		}
		break;
		
		case 'delete':
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			
			require_once __DIR__ . '/../app/controllers/ManageController.php';
			(new Manage)->ManageDelete();
		
		}elseif($_SERVER['REQUEST_METHOD']==='POST'){
			
			require_once __DIR__ . '/../app/controllers/ManageController.php';
			(new Manage)->ManageDelete();
		}
		break;
		
		
		case  'create':
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
		
		require_once __DIR__ . "/../app/controllers/ManageController.php";
		(new Manage)->ManageCreate();		
		
		}elseif ($_SERVER['REQUEST_METHOD']==='POST'){
			
		require_once __DIR__ . "/../app/controllers/ManageController.php";
		(new Manage)->ManageCreate();		
		}
		
		break;
	
    default:
        require_once __DIR__. '/../app/views/pages/404.php';
        break;
}
