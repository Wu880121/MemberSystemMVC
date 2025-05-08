<?php
$route = empty($_GET['route']) ? 'home' : $_GET['route'];

switch ($route) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController)->index();
        break;

    case 'login':
        require_once '../app/controllers/authController.php';
        (new AuthController)->login();
        break;    
		
	case 'SuccessRegister':
		if($_SERVER['REQUEST_METHOD']=='GET'){
		$email = $_GET['email'];
        require_once '../app/controllers/StaticPageController.php';
        (new StaticPageController)->show_SuccessRegister($email);
        }
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
		
		
		case 'verify':
		require_once __DIR__. '/../app/controllers/VerifyController.php';
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			$token = $_GET['token'];
            (new RegisterVerify)->Verify($token);
		}
	         break;		
			 
			 
		case 'resendVerifyToken':
		require_once __DIR__. '/../app/controllers/ResendVerifyToken.php';
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			$email = $_GET['email'];
            (new ResendVerifyToken)->ResendVerify($email);
		}
	         break;		
			 
		
		case 'google_login':
		require_once __DIR__. '/../app/services/GoogleLoginRequestInformation.php';
		require_once __DIR__ . '/../app/controllers/StaticPageController.php';
		// 在 router 判斷 google_login 時加入這段
         $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
         if (preg_match('/Line/i', $userAgent)) {
            (new StaticPageController)->ShowLineBlockNotice();
             exit;
         }		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
            (new GoogleLoginRequestInformation)->RequestInformation();
		}
	         break;		
			 
			 
		case 'google-callback':
		require_once __DIR__. '/../app/services/GooleLoginCallback.php';
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
            (new GooleLoginCallback)->LoginCallback();
		}
	         break;		
			 
		case 'GoogleCallbackController':
		require_once __DIR__. '/../app/controllers/GooleLoginCallbackController.php';
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
            (new GooleLoginCallback)->LoginCallback();
		}
	         break;
			 
		case 'UserProfile':		
         require_once __DIR__ . '/../app/controllers/UserProfileController.php';
         (new UserProfileController)->UserProfile(); // 不需要判斷 GET / POST，controller 內部已經判斷了
         break;		
		 
		 case '404':
         require_once __DIR__ . '/../app/controllers/StaticPageController.php';
         (new StaticPageController)->ShowErrorPage(); // 不需要判斷 GET / POST，controller 內部已經判斷了
         break;
    
	default:
        require_once __DIR__. '/../app/views/pages/404.php';
        break;
}
