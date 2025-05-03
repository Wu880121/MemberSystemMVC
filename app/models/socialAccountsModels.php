<?php

require_once __DIR__. "/../../config/database.php";


class socialAccountsModels{
	
	private $conn;
	
	public function __construct(){
		
		$db = new Database;
		
		$this->conn = $db->connect();
		
	}
	
	
	public function SaveGoogleInfo($userid, $email, $provider_id, $verified_email, $name, $given_name, $family_name, $picture, $created_at){
		
		$stmt = $this->conn->prepare("INSERT INTO socialAccounts
		(user_id, email, provider_id, verified_email, name, given_name, family_name, picture, created_at) 
		VALUES(:user_id, :email, :provider_id, :verified_email, :name, :given_name, :family_name, :picture, :created_at)    
		  ON DUPLICATE KEY UPDATE 
            user_id = VALUES(user_id),
            email = VALUES(email),
            verified_email = VALUES(verified_email),
            name = VALUES(name),
            given_name = VALUES(given_name),
            family_name = VALUES(family_name),
            picture = VALUES(picture),
            created_at = VALUES(created_at)"
			);
		
		$stmt->bindValue(":user_id",$userid);
		$stmt->bindValue(":email",$email);
		$stmt->bindValue(":provider_id",$provider_id);
		$stmt->bindValue(":verified_email",$verified_email ? 1 : 0);
		$stmt->bindValue(":name",$name);
		$stmt->bindValue(":given_name",$given_name);
		$stmt->bindValue(":family_name",$family_name);
		$stmt->bindValue(":picture",$picture);
		$stmt->bindValue(":created_at",$created_at);
		
		return $stmt->execute();
	}
	
}

?>