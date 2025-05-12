<?php
class DbConnection {
    private $host = "localhost:3307";
    private $username = "root";
    private $password = "Password1234";
    private $database = "adsaworlddb";
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
// <?php
// $servidor = "localhost";   // O tu servidor de base de datos
// $usuario = "root";         // Tu usuario de base de datos
// $contrasena = "";          // Tu contraseña de base de datos
// $baseDeDatos = "mi_base";  // Nombre de la base de datos

// // Crear la conexión
// $conn = new mysqli($servidor, $usuario, $contrasena, $baseDeDatos);

// // Verificar si la conexión fue exitosa
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }

?>
