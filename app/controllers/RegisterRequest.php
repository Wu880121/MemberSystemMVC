<?php
class RegisterRequest
{
    public static function validate($data)
    {
        $errors = [];

        if (empty($data['username']) || strlen($data['username']) < 4 || strlen($data['username']) >18 ) {
            $errors[] = '帳號至少 4 字，且小於18個字';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email 格式錯誤';
        }

        if (strlen($data['password']) < 6 || strlen($data['password']) > 15 || // 長度檢查
             !preg_match('/[A-Z]/', $data['password']) ||                       // 至少一個大寫
             !preg_match('/\d/', $data['password']) ||                          // 至少一個數字
             !preg_match('/[\W_]/', $data['password'])                          // 至少一個特殊字元（非英數字）
           ){  
		     $errors[] = '密碼需為 6~12 字，且包含大寫英文、數字與特殊符號';
}

        if (!empty($data['tel']) && !preg_match('/^09\d{8}$/', $data['tel'])) {
            $errors[] = '電話格式需為台灣手機號碼';
        }

        if (!empty($data['birthdate']) && strtotime($data['birthdate']) > time()) {
            $errors[] = '生日不能是未來日期';
        }

        return $errors;
    }
}
