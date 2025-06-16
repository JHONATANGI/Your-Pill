<?php
session_start();
include 'conexiondatabase.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "base_yourpill");

    // Verificar si el usuario existe y obtener su rol
    $stmt = $conn->prepare("SELECT usuario_id, contrasena, rol_id FROM Usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $hashed_password, $rol_id);
        $stmt->fetch();

        // Verificar la contraseña con password_verify()
        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['rol_id'] = $rol_id; // Guardar el rol en la sesión
            header("Location: login-success.php");
            exit();
        } else {
            header("Location: ../frontend/login.html?msg=" . urlencode("Contraseña incorrecta") . "&tipo=error");
        }
    } else {
        header("Location: ../frontend/login.html?msg=" . urlencode("Correo no registrado") . "&tipo=error");
    }

    $stmt->close();
    $conn->close();
}
