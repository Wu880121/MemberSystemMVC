<?php

require_once __DIR__ . '/../../config/database.php';


class User
{

	private $conn;

	public function __construct()
	{

		$db = new Database();
		$this->conn = $db->connect();
	}


	public function register($name,$username, $password,$email,	$tel,$birthdate, $sex, $city, $street)
	{

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (username,password,email,tel,birthdate,sex,city,street) VALUES(:username,:password,:email,:tel,:birthdate,:sex,:city,:street)";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':username', $username);

		$stmt->bindParam(':password', $hashedPassword);
		
		$stmt->bindParam(':email', $email);
		
		$stmt->bindParam(':tel', $tel);
		
		$stmt->bindParam(':birthdate', $birthdate);
		
		$stmt->bindParam(':sex', $sex);
		
		$stmt->bindParam(':city', $city);
		
		$stmt->bindParam(':street', $street);

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


          public function saveLoginToken($userId, $token, $device, $expiresAt)
          {
               $sql = "INSERT INTO login_tokens (user_id, token, device, expires_at)
                VALUES (:user_id, :token, :device, :expires_at)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':device', $device);
                $stmt->bindParam(':expires_at', $expiresAt);
                return $stmt->execute();
            }

           public function deleteLoginToken($token)
           {
              $sql = "DELETE FROM login_tokens WHERE token = :token";
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':token', $token);
              $stmt->execute();
            }


			public function findById($decoded){
				
				$sql = "SELECT * FROM login_tokens WHERE user_id= :user_id";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':user_id', $decoded);
               $stmt->execute();
			   
			    return $stmt->fetch(PDO::FETCH_ASSOC);
				
			}
}
