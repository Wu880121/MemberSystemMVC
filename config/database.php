<?php
class Database
{
	private $host;
	private $port;
	private $db_name;
	private $username;
	private $password;
	public $conn;

	public function __construct()
	{
		$this->host = $_ENV['DB_HOST']; // ✅ 不要寫死
		$this->port = $_ENV['DB_PORT'];
		$this->db_name = $_ENV['DB_DATABASE'];
		$this->username = $_ENV['DB_USERNAME'];
		$this->password = $_ENV['DB_PASSWORD'];
	}

	public function connect()
	{



		try {
			$dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";



			$this->conn = new PDO($dsn, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "連線錯誤：" . $e->getMessage();
			exit;
		}

		return $this->conn;
	}
}
