<?php

require_once __DIR__ . '/../../config/database.php';


class login_tokens
{

    private $conn;

    public function __construct()
    {

        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findByRememberToken($token)
    {
        $sql = "SELECT * FROM login_tokens WHERE token = :token LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
