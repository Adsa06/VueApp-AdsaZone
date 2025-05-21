<?php
class DbConnection {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "adsaworlddb";
    private $conn = null;

    public function connect() {
        $this->conn = new mysqli("localhost", "root", "", "adsaworlddb", "3306");
        if ($this->conn->connect_error) {
            die("❌ Falló la conexión: " . $this->conn->connect_error);
        } else {
            echo "✅ Conexión exitosa a MySQL!";
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
