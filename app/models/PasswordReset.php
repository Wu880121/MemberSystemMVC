<?php

// models/PasswordReset.php

require_once __DIR__. '/../../config/database.php'; // 你的資料庫連線（視你命名方式）

class PasswordReset
{
    private $conn;

    public function __construct()
    {
        $db=new Database();
		
		$this->conn=$db->connect();
		
    }

    public function createToken($email, $token, $expiresAt)
    {
        // 先刪除這個 email 舊的 token（保證每次一組）
        $stmt = $this->conn->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        // 插入新的 token
        $stmt = $this->conn->prepare("
            INSERT INTO password_resets (email, token, expires_at)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$email, $token, $expiresAt]);
    }

    public function verifyToken($token)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM password_resets
            WHERE token = ? AND expires_at > NOW()
            LIMIT 1
        ");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteToken($token)
    {
        $stmt = $this->conn->prepare("DELETE FROM password_resets WHERE token = ?");
        return $stmt->execute([$token]);
    }
}
?>