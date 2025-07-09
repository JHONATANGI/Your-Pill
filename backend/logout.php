<?php
session_start();        // Iniciamos la sesión (aunque sea para destruirla)
session_unset();        // Limpiamos todas las variables de sesión
session_destroy();      // Destruimos la sesión
header("Location: ../frontend/login_usuario.html"); // Redirigimos al login u otra página
exit();
?>