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
			
			
			public function getPasswordByEmail($email){
				
				$stmt = $this->conn->prepare("SELECT password FROM users WHERE email = :email LIMIT 1");
				$stmt->bindValue(":email", $email);
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			
			public function updatePasswordByEmail($email, $hashedPassword)
               {
                   $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                   return $stmt->execute([$hashedPassword, $email]);
                }
				
				public function findByEmail($email)
				{
					
					$stmt = $this->conn->prepare("SELECT * FROM users WHERE email= ? ");
					return $stmt->execute([$email]);
				}
				
				
				public function finddata(){
					
				
				$stmt=$this->conn->query("SELECT * FROM users");
				
			    return	$stmt->fetchALL(PDO::FETCH_ASSOC);
				
				}
				
				public function  getDataByPage($offset,$limit){
					
					$stmt = $this->conn->prepare("SELECT * FROM users LIMIT :offset , :limit ");
					$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
					$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
					$stmt->execute();
					
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				
				public function getAllCount(){
					
					$stmt = $this->conn->query("SELECT COUNT(*) FROM users");
					return $stmt-> fetchColumn();
				}
				
				
				public function selectById($id){
					
					$stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
					
					$stmt->bindParam(':id',$id);
					
					$stmt->execute();
					
					return $stmt->fetch(PDO::FETCH_ASSOC);
					
				}
				
				public function selectOldPasswordFromId($id){
					
					$stmt = $this->conn->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
					$stmt->bindValue(":id",$id);
					$stmt->execute();
					return $stmt->fetch(PDO::FETCH_ASSOC);
				}
				
				public function edit($id,$username,$password,$email,$tel,$birthdate,$sex,$city,$street,$role){
					
					$stmt = $this->conn->prepare("
					
					UPDATE users SET 
					username = :username,
					password = :password,
					email = :email,
					tel = :tel,
					birthdate = :birthdate,
					sex = :sex,
					city = :city,
					street = :street,
					role = :role 
					
					WHERE id = :id
					
					");
					
					$stmt->bindParam(":username",$username);
					$stmt->bindParam(":password",$password);
					$stmt->bindParam(":email",$email);
					$stmt->bindParam(":tel",$tel);
					$stmt->bindParam(":birthdate",$birthdate);
					$stmt->bindParam(":sex",$sex);
					$stmt->bindParam(":city",$city);
					$stmt->bindParam(":street",$street);
					$stmt->bindParam(":role",$role);
					$stmt->bindParam(":id",$id);
					
					$stmt->execute();
				
				    return $stmt->fetchALL(PDO::FETCH_ASSOC);
				}
				
				
				public function UserDelete($id){
					
					$stmt = $this->conn->prepare("DELETE  FROM users WHERE id = :id");
					
					$stmt->bindParam(':id',$id);
					
					return $stmt->execute();
				}
				
				public function ManageCreat($name,$username,$password,$email,$tel,$birthdate,$sex,$city,$street){
					
					$stmt = $this->conn->prepare("INSERT INTO 
					users( 
							 name,
							 username,
							 password,
							 email,
							 tel,
							 birthdate,
							 sex,
							 city,
							 street
					) 
					VALUES(
							:name,
							:username,
							:password,
							:email,
							:tel,
							:birthdate,
							:sex,
							:city,
							:street
					)");
					
					$stmt->bindValue(':name' , $name);
					$stmt->bindValue(':username' , $username);
					$stmt->bindValue(':password' , $password);
					$stmt->bindValue(':email' , $email);
					$stmt->bindValue(':tel', $tel);
					$stmt->bindValue(':birthdate' , $birthdate);
					$stmt->bindValue(':sex' ,$sex);
					$stmt->bindValue(':city' ,$city);
					$stmt->bindValue(':street' ,$street);
					
					return $stmt->execute();
					
				}
				
				
				public function ManageSearch($search,$offset,$limit){
					
					
					$stmt = $this->conn->prepare("SELECT * FROM  users WHERE 
					CONCAT(id, username, email, tel , birthdate, sex, city, street, role)
					COLLATE utf8mb4_general_ci
					LIKE :search LIMIT  :offset , :limit");
					$stmt->bindValue(":search", "%".$search."%");
					$stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
					$stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
					$stmt->execute();
					return  $stmt->fetchALL(PDO::FETCH_ASSOC);
					
				}
				
				public function ManageGetSearchCount($search){
					
					$stmt= $this->conn->prepare("SELECT COUNT(*) FROM users WHERE 
					CONCAT(id, username, email, tel ,birthdate, sex, city, street, role)
					COLLATE utf8mb4_general_ci
					LIKE :search");
					
					$stmt->bindValue(":search", "%".$search."%");
					$stmt->execute();
					return $stmt->fetchColumn();
				}
			
}

