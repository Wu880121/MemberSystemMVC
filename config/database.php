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
		$this->host = getenv('DB_HOST'); // ✅ 不要寫死
		$this->port = getenv('DB_PORT');
		$this->db_name = getenv('DB_DATABASE');
		$this->username = getenv('DB_USERNAME');
		$this->password = getenv('DB_PASSWORD');
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
