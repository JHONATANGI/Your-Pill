<?php
session_start();        // Iniciamos la sesión (aunque sea para destruirla)
session_unset();        // Limpiamos todas las variables de sesión
session_destroy();      // Destruimos la sesión
header("Location: ../index.php"); // Redirigimos al login u otra página
exit();
?>