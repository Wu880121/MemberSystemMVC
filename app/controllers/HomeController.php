<?php
require_once '../app/models/user.php';
require_once '../app/services/JwtService.php';

class HomeController
{
    public function index()
    {
			include_once __DIR__."/../views/pages/home.php";
  }
