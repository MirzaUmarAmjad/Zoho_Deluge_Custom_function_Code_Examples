<?php
class db
{
	private $host;
	private $db_name;
	private $id;
	private $password;
	protected $conn;

	function dbconect()
	{
		try {
		$this->host = "localhost"; 
		$this->db_name = "test";
		$this->id = "root";
		$this->password = "";

		$this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name",$this->id,$this->password); 

	    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//echo "Connection established";
			
		} catch (PDOException $e) {
			echo "DB Config. Error";
		}
	}
}


?>