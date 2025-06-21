<?php
include 'conexiondatabase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_identificacion = $_POST['tipo_identificacion'];
    $numero_identificacion = $_POST['numero_identificacion'];
    $primer_nombre = $_POST['primer_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $peso = $_POST['peso'];
    $altura = number_format($_POST['altura'], 2, '.', '');
    $rol_id = $_POST['rol_id'];

    // Encriptar la contraseña antes de guardarla
    $password_segura = password_hash($password, PASSWORD_BCRYPT);

    // Insertar en la base de datos asegurando el orden correcto
    $stmt = $conn->prepare("INSERT INTO Usuarios (tipo_identificacion, numero_identificacion, primer_nombre, primer_apellido, genero, telefono, email, contrasena, peso, altura, rol_id) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Asegurar que bind_param sigue el orden de columnas de la BD
    $stmt->bind_param("ssssssssssi", $tipo_identificacion, $numero_identificacion, $primer_nombre, $primer_apellido, $genero, $telefono, $email, $password_segura, $peso, $altura, $rol_id);

    if ($stmt->execute()) {
            header("Location: ../frontend/login.html");
    exit();
    } else {
        echo "Error en el registro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>