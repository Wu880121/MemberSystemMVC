<?php

require_once __DIR__ . '/../../config/database.php';


class user
{

	private $conn;

	public function __construct()
	{

		$db = new Database();
		$this->conn = $db->connect();
	}


	public function register($username, $password,$email,$phone,$birthday)
	{

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (username,password,email,phone,birthday) VALUES(:username,:password,:email,:phone,:birthday)";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':username', $username);

		$stmt->bindParam(':password', $hashedPassword);
		
		$stmt->bindParam(':email', $email);
		
		$stmt->bindParam(':phone', $phone);
		
		$stmt->bindParam(':birthday', $birthday);

		return $stmt->execute();
	}

	public function findByUsername($username)
	{

		$sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':username', $username);

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function verifyPassword($username, $password)
	{
		$user = $this->findByUsername($username);
		if ($user && password_verify($password, $user['password'])) {
			return $user; // 登入成功，回傳使用者資料
		}
		return false; //
	}


	public function saveLoginToken($userId, $token)
	{
		$expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

		$sql = "INSERT INTO login_tokens (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':user_id', $userId);
		$stmt->bindParam(':token', $token);
		$stmt->bindParam(':expires_at', $expiresAt);
		$stmt->execute();
	}
}
