<?php
// public/index.php

session_start();

// 載入路由設定
require_once __DIR__ . '/../routes/web.php';

// 顯示錯誤（開發用）
ini_set('display_errors', 1);
error_reporting(E_ALL);


