<?php
include 'conexiondatabase.php';

// Mostrar errores durante desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $tipo_identificacion    = $_POST['tipo_identificacion'] ?? '';
    $numero_identificacion  = $_POST['numero_identificacion'] ?? '';
    $primer_nombre          = $_POST['primer_nombre'] ?? '';
    $primer_apellido        = $_POST['primer_apellido'] ?? '';
    $genero                 = $_POST['genero'] ?? '';
    $telefono               = $_POST['telefono'] ?? '';
    $email                  = $_POST['email'] ?? '';
    $password               = $_POST['password'] ?? '';
    $especialidad           = $_POST['especialidad'] ?? '';
    $matricula_profesional  = $_POST['matricula_profesional'] ?? '';
    $rol_id                 = $_POST['rol_id'] ?? 1;

    // Validación básica
    if (
        empty($tipo_identificacion) || empty($numero_identificacion) || empty($primer_nombre) ||
        empty($primer_apellido) || empty($genero) || empty($telefono) || empty($email) ||
        empty($password) || empty($especialidad) || empty($matricula_profesional)
    ) {
        exit("Por favor completa todos los campos obligatorios.");
    }

    // Encriptar la contraseña
    $password_segura = password_hash($password, PASSWORD_BCRYPT);

    // Preparar consulta
    $stmt = $conn->prepare("INSERT INTO medicos (
        tipo_identificacion, numero_identificacion, primer_nombre, primer_apellido, genero,
        telefono, email, contrasena, especialidad, matricula_profesional, rol_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar que prepare no haya fallado
    if (!$stmt) {
        exit("Error al preparar la consulta: " . $conn->error);
    }

    // Asociar parámetros
    $stmt->bind_param(
        "ssssssssssi",
        $tipo_identificacion,
        $numero_identificacion,
        $primer_nombre,
        $primer_apellido,
        $genero,
        $telefono,
        $email,
        $password_segura,
        $especialidad,
        $matricula_profesional,
        $rol_id
    );

    // Ejecutar y manejar resultado
    if ($stmt->execute()) {
        header("Location: ../frontend/login_medico.html");
        exit();
    } else {
        if (str_contains($stmt->error, 'Duplicate')) {
            echo "Ya existe un médico con ese número de identificación o correo electrónico.";
        } else {
            echo "Error en el registro: " . $stmt->error;
        }
    }

    // Cerrar conexiones
    $stmt->close();
    $conn->close();
}
