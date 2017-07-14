<?php 
//close Notice: Undefined
error_reporting (E_ALL ^ E_NOTICE);

class Connect {

private $host = "localhost"; //host
private $user = "root"; //user
private $pass = ""; //pass
private $db = "search_location"; //db
public $conn;

public function ConDB () {
//connect db
$this->conn = new mysqli($this->host,$this->user,$this->pass,$this->db);

if($this->conn->connect_error){
die("Connection Database failed: ");
}
else {
mysqli_set_charset($this->conn, "utf8");
date_default_timezone_set('Asia/Bangkok');
}

}


}

?>