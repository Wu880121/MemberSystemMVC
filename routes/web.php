<?php
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController)->index();
        include '../app/views/home.php';
        break;

    case 'login':
        require_once '../app/controllers/authController.php';
        (new AuthController)->login();
        include '../app/views/login.php';
        break;

    case 'logout':
        require_once '../app/controllers/authController.php';
        (new AuthController)->logout();
        break;

    case 'register':
        require_once '../app/controllers/authController.php';
        (new AuthController)->register();
        include '../app/views/register.php';
        break;

    default:
        include '../app/views/404.php';
        break;
}
