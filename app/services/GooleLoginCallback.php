<?php
// GoogleCallbackController.php

// 這裡不用再 session_start(); 因為你 index.php 已經有了

// 檢查 state（防止 CSRF）

class GooleLoginCallback{
	
	public function LoginCallback(){

if (!isset($_GET['state']) || $_GET['state'] !== ($_SESSION['oauth2_state'] ?? '')) {
    exit('⚠️ 非法請求，state 不符');
}

// 檢查 code
$code = $_GET['code'] ?? null;
if (!$code) {
    exit('⚠️ 缺少授權碼 (code)');
}

// 用 code 換 access_token
$token_endpoint = 'https://oauth2.googleapis.com/token';

$post_data = [
    'code' => $code,
    'client_id' => $_ENV['CLIENT_ID'],
    'client_secret' => $_ENV['CLIENT_SECRET'],
    'redirect_uri' => $_ENV['REDIRECT_URI'],
    'grant_type' => 'authorization_code',
];

// 使用 CURL 發送 POST 請求
$ch = curl_init($token_endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);
$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);
$access_token = $token_data['access_token'] ?? null;

if (!$access_token) {
    exit('⚠️ 無法取得 access_token');
}

// 用 access_token 拿使用者資料
$userinfo_endpoint = 'https://www.googleapis.com/oauth2/v2/userinfo';

$ch = curl_init($userinfo_endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token
]);
$userinfo_response = curl_exec($ch);
curl_close($ch);

$user_info = json_decode($userinfo_response, true);

//if(empty($user_info)){}

if(isset($user_info['id'])){
// 儲存使用者資料到 SESSION
$_SESSION['GoogleUser'] = [
    'user' => $user_info,
	'provider' => 'google',
];
}

// 清除 state（防止重複使用）
unset($_SESSION['oauth2_state']);

header("Location: index.php?route=GoogleCallbackController");
exit;
	
	}

}