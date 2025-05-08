<?php
// google-login.php
class GoogleLoginRequestInformation{


public function RequestInformation(){
	
$client_id = $_ENV['CLIENT_ID']??NULL;     //client_id      !!用getenv抓不到的話就用$_ENV[]抓環境變數，系統問題。
$redirect_uri  = $_ENV['REDIRECT_URI'] ?? null;;  //redirect_uri
echo urlencode($_ENV['REDIRECT_URI']); 
exit;

$scope = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
$state = bin2hex(random_bytes(16)); // 建議儲存在 session 裡防 CSRF

// 儲存 state 到 session 做比對
$_SESSION['oauth2_state'] = $state;


$url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => $scope,
    'state' =>$state,
    'access_type' => 'online',
]);


header('Location: ' . $url);
exit;
}

}


//這裡的流程是，我產生一個鑰匙(Token)然後跟ID去google授權網址對照身分後給他一把鑰匙，
//然後她回傳鑰匙給我跟一個臨時憑證(Code)
//然後我再拿這個鑰匙跟臨時憑證(Code)還有我自己的密碼去跟他要用戶的資料。