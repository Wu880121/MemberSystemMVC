<?php
// public/index.php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


session_start();

// 載入路由設定
require_once __DIR__ . '/../routes/web.php';

// 顯示錯誤（開發用）
ini_set('display_errors', 1);
error_reporting(E_ALL);


