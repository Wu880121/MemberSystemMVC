<?php
// public/index.php

session_start();

// 顯示錯誤（開發用）
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 載入路由設定
require_once '../routes/web.php';
