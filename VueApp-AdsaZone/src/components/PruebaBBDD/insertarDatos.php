<?php
require_once 'DbConnection.php';
echo "Hola2, ¿q tal?";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        // $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Crear conexión
        $db = new DbConnection();
        $conn = $db->connect();


        $sql = "INSERT INTO usuarios (username , password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $username, $password); // 
            if ($stmt->execute()) {
                echo "Usuario registrado correctamente.";
            } else {
                echo "Error al insertar: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

        $db->close();
    } else {
        echo "Por favor completa todos los campos.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>