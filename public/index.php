<?php
// public/index.php

ob_start(); // 啟用輸出緩衝

// ...原本程式

register_shutdown_function(function () {
    $output = ob_get_clean(); // 取得所有輸出
    file_put_contents('debug_output.html', $output); // 寫入檔案查看到底誰印的
});


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
