<?php
class DBController {
	private $host = "localhost";
	private $user = "awptms_Hrwatania";
	private $password = "Alwatania@HR";
	private $database = "awptms_watania";
	private $conn;
	
        function __construct() {
        $this->conn = $this->connectDB();
	}	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		$arabic_char = mysqli_query($conn, "SET CHARACTER SET UTF8");
		return $conn;
	}
        function runQuery($query) {
                $result = mysqli_query($this->conn,$query);
                while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
                }		
                if(!empty($resultset))
                return $resultset;
	}
}
?>