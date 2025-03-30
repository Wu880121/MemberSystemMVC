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

    default:
        include '../app/views/404.php';
        break;
}
