<?php
include '../database/conexiondatabase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_identificacion = $_POST['numero_identificacion'];
    $primer_nombre = $_POST['primer_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $rol_id = $_POST['rol_id'];
    $password = $_POST['password'];

    // Encriptar la contraseña antes de guardarla
    $password_segura = password_hash($password, PASSWORD_BCRYPT);

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO Usuario (email, contrasena, rol_id) VALUES (?, ?, ?)");
    $rol_id = 2; // 2 = Usuario normal, cambia si necesitas otro rol
    $stmt->bind_param("ssi", $email, $password_segura, $rol_id);

    if ($stmt->execute()) {
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        echo "Error en el registro.";
    }

    $stmt->close();
    $conn->close();
}
?>