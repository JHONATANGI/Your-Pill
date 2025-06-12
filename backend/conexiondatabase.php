<?php
$server = "localhost"; // 🖥️ Servidor de la base de datos (por defecto es 'localhost')
$username = "root";    // 👤 Usuario de MySQL (ajústalo si tienes otro)
$password = "dilan1706";        // 🔑 Contraseña de MySQL (cambia si tienes una configurada)
$database = "base_yourpill"; // 📂 Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($server, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ajuste de charset para evitar problemas con acentos
$conn->set_charset("utf8");

?>
