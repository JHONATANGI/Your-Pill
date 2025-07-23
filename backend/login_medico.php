<?php
session_start();
include 'conexiondatabase.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario existe y obtener su rol
    $stmt = $conn->prepare("SELECT medico_id, contrasena, rol_id, primer_nombre, primer_apellido FROM medicos WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($medico_id, $hashed_password, $rol_id, $primer_nombre, $primer_apellido);
        $stmt->fetch();

        // Verificar la contraseña con password_verify()
        if (password_verify($password, $hashed_password)) {
            $_SESSION['medico_id'] = $medico_id;
            $_SESSION['rol_id'] = $rol_id; // Guardar el rol en la sesión
            $_SESSION['primer_nombre'] = $primer_nombre; // Guardar nombre en la sesión
            $_SESSION['primer_apellido'] = $primer_apellido;
            $_SESSION['origen_login'] = 'medico'; // Indicar que el origen del login es médico
            header("Location: login-success.php");
            exit();
        } else {
            header("Location: ../frontend/login_medico.html?msg=" . urlencode("Contraseña incorrecta") . "&tipo=error");
        }
    } else {
        header("Location: ../frontend/login_medico.html?msg=" . urlencode("Correo no registrado") . "&tipo=error");
    }

    $stmt->close();
    $conn->close();
}
