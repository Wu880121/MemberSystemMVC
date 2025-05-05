<?php
// public/index.php


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


session_start();

// 載入路由設定
try{
	require_once __DIR__ . '/../routes/web.php';
}catch(Throwable $e){
    logError($e); // ✅ 可用了
    header("Location: index.php?route=404");
    exit;
	
}
// 顯示錯誤（開發用）
ini_set('display_errors', 1);
error_reporting(E_ALL);


//正式環境請把ini_set('display_errors', 1); 和 error_reporting(E_ALL); 改成

//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING);

date_default_timezone_set('Asia/Taipei');
