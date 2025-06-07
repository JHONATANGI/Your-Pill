<?php
session_start();
include '../database/conexiondatabase.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "dilan1706", "base_yourpill");

    // Verificar si el usuario existe y obtener su rol
    $stmt = $conn->prepare("SELECT usuario_id, contrasena, rol_id FROM Usuario WHERE email = ?");
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

            // Redirigir según el rol
            if ($rol_id == 1) {
                header("Location: medico_dashboard.php"); // Área de medicos
            } else {
                header("Location: paciente_dashboard.php"); // Área de pacientes
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no registrado.";
    }

    $stmt->close();
    $conn->close();
}
?>