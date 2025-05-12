<?php
class DbConnection {
private $host = "localhost";
private $username = "root";
private $password = "";
private $database = "test_db";
private $conn;

public function connect() {
$this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
if ($this->conn->connect_error) {
die("Connection failed: " . $this->conn->connect_error);
}
return $this->conn;
}

public function close() {
$this->conn->close();
}
}
?>